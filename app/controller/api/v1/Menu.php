<?php
namespace app\controller\api\v1;
use app\AdminBaseController;
use app\ApiBaseController;
use think\App;
use app\common\logic\system\admin\Menu as MenuLogic;

/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class Menu extends ApiBaseController
{
    public function __construct(App $app, MenuLogic $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }

    public function getList(){

        $this->repository->getList($this->plat);

        return $this->success();
    }

}