<?php
namespace app\common\logic\upload;

use think\Cache;



class Upload
{
    private $type;
    private $driver;

    //默认本地上传
    private $typeArray = [
        1 => 'Local',//储存本地
    ];

    public function __construct($type)
    {
        $this->type = $type;
        if(!$this->typeArray[$type]) E('配置不存在');
        $class = 'app\\common\\logic\\upload\\storage\\'. ucfirst($this->typeArray[$type]);
        $this->driver = new $class();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->driver, $name], $arguments);
    }
}