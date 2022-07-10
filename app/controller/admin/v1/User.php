<?php

namespace app\controller\admin\v1;

use app\common\Base\AdminBaseController;
use think\App;
use app\service\admin\User as Server;

class User extends AdminBaseController
{
    public function __construct(App $app,Server $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    public function getInfo()
    {
       return $this->success($this->userInfo);
    }
}