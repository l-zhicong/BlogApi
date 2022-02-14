<?php

namespace app\controller\admin\v1;

use app\BaseController;
use think\App;
use app\service\admin\user\User as Service;

class User extends BaseController
{
    public function __construct(App $app,Service $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    public function getInfo()
    {
       return $this->success($this->userInfo);
    }
}