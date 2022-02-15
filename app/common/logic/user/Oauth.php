<?php
/**
 * 第三方授权登录
 */
namespace app\common\logic\user;
class Oauth{
    
    private $type;  // 第三方登录类型
    private $driver;    // 登录驱动
    public function __construct($type , $setConfig = array()){
        $this->type     = $type;
        $config = config('system.oauth')[$type];
        $class = '\org\oauth\driver\\'. ucfirst($type);
        if(is_array( $setConfig )) $config = array_merge($config,$setConfig);
        $this->driver   =  new $class($config);
    }
    
    /**
     * 跳转至第三方授权登录页面
     */
    public function login(){
        return $this->driver->login();
    }
    
    /**
     * 授权登录之后获取 AccessToken 和 openID  等信息
     */
    public function getAccessToken($code){
        $info =  $this->driver->getAccessToken($code);
        // TODO 保存更新 最新的 授权资料
        return $info;
    }
    
    /**
     * 获取用户资料
     */
    public function getOauthInfo(){
        $info = $this->driver->getOauthInfo();
        return $info;
    }
    
    
    
    
    
    
}