<?php
namespace logic\user;
class User{

    private $plat;
    public $userObject = null;
    public function __construct($plat)
    {
        if(!$plat) E('平台不存在');
        $this->plat = $plat;
        $this->loadPlatUser();
    }

    /**
     * 加载各个平台的用户对象
     */
    private function loadPlatUser()
    {
        if($this->plat == 1){
            $this->userObject = new \logic\admin\Admin();
        }elseif($this->plat == 2){
            $this->userObject = new \logic\school\SchoolAdmin();
        }elseif($this->plat == 4){
            $this->userObject = new \logic\member\NewUser();
        }elseif($this->plat == 5){
            $this->userObject = new \logic\member\NewUser();
        }
    }

}