<?php

namespace app\controller\admin\v1;

use app\common\Base\AdminBaseController;
use think\App;
use app\service\admin\user\User as Service;

class User extends AdminBaseController
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