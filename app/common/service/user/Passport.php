<?php
/**
 * 用户登陆身份验证类
 */
namespace app\common\service\user;
use service\JwtToken;
use think\facade\Cache;
use app\lib\exception\PlatException;
use app\lib\exception\AuthException;
class Passport{

	private static $instance = null;
	private $passportObject;
	private $plat;  //访问的平台应用 1 管理后台
    public $platList;
	protected $loginInfo;

	private function __construct($plat) 
	{
        $this->platList = config('system.loadPlatList');
		if(!$this->platList[$plat]) throw new PlatException('平台不存在');
		$this->plat = $plat;
		$this->loadPlatPassport();
	}

	public static function getInstance($plat='') 
	{
        // if (self::$instance == null) {
        //     self::$instance = new self($plat);
        // }
        return new self($plat);
	}

	/**
     * 加载各个渠道的身份校验类
     */
    private function loadPlatPassport() 
    {
        $classList = config('system.loadPlatPassport');
        if(!$classList[$this->plat]) return false;
        $this->passportObject = new $classList[$this->plat]();
    }

    public function login($param) 
    {
        $loginInfo = $this->passportObject->login($param);
        $this->loginInfo = $loginInfo;
        return $loginInfo;
    }

    /**
     * 创建登录验证码key
     */
    public function createLoginKey($code)
    {
        $key = uniqid(microtime(true), true);
        cache('am_captcha' . $key, $code, config('system.captcha_exp', 5) * 60);
        return $key;
    }

    /**
     * 检查验证码
     */
    public function checkCode($key, $code)
    {
        $_code = cache('am_captcha' . $key);
        if (!$_code) {
            E('验证码过期');
        }

        if (strtolower($_code) != strtolower($code)) {
            E('验证码错误');
        }

        //删除code
        cache('am_captcha' . $key, NULL);
    }

    public function createToken($userId)
    {
        $service = new JwtToken();
        $exp = intval(config('system.token_exp'));
        $lastTime = date('Y-m-d H:i:s');
        $platLastTime = Cache::set('login_last_time_'.$this->plat.'_'.$userId,$lastTime);
        $token = $service->createToken($userId, $this->platList[$this->plat], $this->plat, strtotime("+ {$exp}hour"), ['login_time' => $lastTime]);
        $this->cacheToken($token['token'], $token['out']);
        return $token;
    }

    public function cacheToken(string $token, string $exp)
    {
        Cache::set($this->platList[$this->plat].'_' . $token, time() + $exp, $exp);
    }

    public function checkToken(string $token)
    {
        $has = Cache::has($this->platList[$this->plat].'_' . $token);
        if (!$has)
            throw new AuthException('无效的token');
        $lastTime = Cache::get($this->platList[$this->plat].'_' . $token);
        if (($lastTime + (intval(config('system.token_valid_exp'))) * 60) < time())
            throw new AuthException('token 已过期');
    }

    public function updateToken(string $token)
    {
        $exp = intval(config('system.token_valid_exp')) * 60;
        Cache::set($this->platList[$this->plat].'_' . $token, time() + $exp, $exp);
    }

    public function clearToken(string $token)
    {
        Cache::rm($this->platList[$this->plat].'_' . $token);
    }

    public function updateLastTime($userInfo)
    {
        $userInfo->last_time = time();
        $userInfo->save();
    }
}