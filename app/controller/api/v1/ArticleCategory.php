<?php
/**
 * Class ArticleCategory
 * @package app\controller\api\v1
 * author:lzcong
 * time:2:04 PM
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\api\v1;

use app\common\Base\ApiBaseController;
use think\App;
use app\common\logic\article\ArticleCategory as Repository;

class ArticleCategory extends ApiBaseController
{
    public function __construct(App $app,Repository $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }

    public function getList(){
        [$page, $limit] = $this->request->getMore([['page', 1],['limit',20]], true);
        $param = [];
        $result = $this->repository->getList($param,$limit);
        return $this->success($result);
    }

}