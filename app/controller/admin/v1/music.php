<?php
/**
 * Class music
 * @package app\controller\admin\v1
 * author:lzcong
 * time:11:52
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\admin\v1;

use app\common\Base\AdminBaseController;
use app\common\logic\music\music as musicLogic;
use think\App;

class music extends AdminBaseController
{

    public function __construct(App $app,musicLogic $logic )
    {
        parent::__construct($app);
        $this->repository = $logic;
    }

    public function getList(){
        $this->repository->getList();
    }


    public function add(){

    }

    public function delete(){

    }

}