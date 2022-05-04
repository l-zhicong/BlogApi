<?php
/**
 * Class Letter
 * @package app\controller\admin\v1
 * author:lzcong
 * time:12:07
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\admin\v1;

use app\common\Base\AdminBaseController;
use app\common\logic\homepage\Letter as LetterLogic;
use think\App;

class Letter extends AdminBaseController
{
    public function __construct(App $app,LetterLogic $logic)
    {
        parent::__construct($app);
        $this->repository = $logic;
    }

    public function getList(){
        [$limit] = $this->request->getMore([['limit',20]], true);
        $res = $this->repository->getList([],$limit);
        return $this->success($res);
    }

}