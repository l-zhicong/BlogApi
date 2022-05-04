<?php
/**
 * Class HomePage
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\api\v1;

use app\common\Base\ApiBaseController;
use app\common\logic\homepage\MyHomePage;
use think\App;

class HomePage extends ApiBaseController
{
    public function __construct(App $app,MyHomePage $repository)
    {
        $this->repository = $repository;
        parent::__construct($app);
    }

    public function getInfo(){
        $res = $this->repository->getInfo([],1);
        return $this->success($res);
    }

}