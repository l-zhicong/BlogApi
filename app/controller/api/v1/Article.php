<?php
/**
 * Class Article
 * @package app\controller\api\v1
 * author:lzcong
 * time:1:34 PM
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\api\v1;

use app\common\Base\ApiBaseController;
use think\App;
use app\common\logic\article\Article as ArticleRepository;

class Article extends ApiBaseController
{
    public function __construct(App $app,ArticleRepository $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }

    public function getList(){
        [$page, $limit] = $this->request->getMore([['page', 1],['limit',20]], true);
        $param = [];
        $res = $this->repository->List($param,$limit);
        return $this->success($res);
    }

    public function getInfo($id){
        $where = ["id"=>$id];
        $res = $this->repository->getData($where);
        return $this->success($res);
    }
}