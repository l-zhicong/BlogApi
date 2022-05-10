<?php
/**
 * Class Music
 * @package app\controller\api\v1
 * author:lzcong
 * time:8:36 PM
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\api\v1;

use app\common\Base\ApiBaseController;
use app\common\logic\music\music as musicRepository;
use app\validate\api\music\MusicValidata;
use think\App;

class Music extends ApiBaseController
{
    public function __construct(App $app,musicRepository $repository,MusicValidata $validata)
    {
        parent::__construct($app);
        $this->repository = $repository;
        $this->validate = $validata;
    }

    public function getlist(){
        $this->validate->getList()->goCheck();
        [$name, $limit] = $this->request->getMore([['name'],['limit',20]], true);
        $where = ['name'=>$name];
        $res = $this->repository->getlist($where,$limit);
        return $this->success($res);
    }

}