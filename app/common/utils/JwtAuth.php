<?php

namespace app\common\utils;


use app\lib\exception\AdminException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\facade\Env;

/**
 * Jwt
 * Class JwtAuth
 * @package crmeb\utils
 */
class JwtAuth
{

    /**
     * token
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $app_key = 'app_key';

    /**
     * 获取token
     * @param int $id
     * @param string $type
     * @param int $plat 平台参数
     * @param int $exp 过期时间
     * @param array $params
     * @return array
     */
    public function getToken(int $id, string $type, int $plat, int $exp, array $params = []): array
    {
        $host = app()->request->host();
        $time = time();
        $exp_time = strtotime('+ 7day');
        if (app()->request->isApp()) {
            $exp_time = strtotime('+ 30day');
        }
        if ($type == 'out') {
            $exp_time = strtotime('+ 1day');
        }
        $params += [
            'iss' => $host,
            'aud' => $host,
            'iat' => $time,
            'nbf' => $time,
            'exp' => $exp_time,
        ];
        $params['jti'] = compact('id', 'type','plat');
        $token = JWT::encode($params, Env::get('app.app_key', $this->app_key) ?: $this->app_key,'HS256',null,null);

        return compact('token', 'params');
    }

    /**
     * 解析token
     * @param string $jwt
     * @return array
     */
    public function parseToken(string $jwt): array
    {
        $this->token = $jwt;
        list($headb64, $bodyb64, $cryptob64) = explode('.', $this->token);
        $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64));
        return [$payload->jti->id,$payload->jti->type,$payload->jti->plat];
    }

    /**
     * 验证token
     */
    public function verifyToken()
    {
        JWT::$leeway = 60;
//        JWT::decode($this->token, Env::get('app.app_key', $this->app_key) ?: $this->app_key, array('HS256'));
        JWT::decode($this->token, new Key(Env::get('app.app_key', $this->app_key) ?: $this->app_key, 'HS256'));
        $this->token = null;
    }

    /**
     * 获取token并放入令牌桶
     * @param int $id
     * @param string $type
     * @param array $params
     * @return array
     */
    public function createToken(int $id, string $type,int $plat, int $exp, array $params = [])
    {
        $tokenInfo = $this->getToken($id, $type, $plat, $exp, $params);
        $exp = $tokenInfo['params']['exp'] - $tokenInfo['params']['iat'] + 60;
        $res = CacheService::setTokenBucket(md5($tokenInfo['token']), ['uid' => $id, 'type' => $type, 'token' => $tokenInfo['token'], 'exp' => $exp], (int)$exp);
        if (!$res) {
            throw new AdminException(ApiErrorCode::ERR_SAVE_TOKEN);
        }
        return $tokenInfo;
    }
}
