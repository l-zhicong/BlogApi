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
use app\validate\api\article\ArticleCategoryValidate;
use think\App;
use app\common\logic\article\ArticleCategory as Repository;

class ArticleCategory extends ApiBaseController
{
    public function __construct(App $app,Repository $repository,ArticleCategoryValidate $validate)
    {
        parent::__construct($app);
        $this->repository = $repository;
        $this->validate = $validate;
    }

    public function getList(){
        $this->validate->goCheck();
        [$limit] = $this->request->getMore([['limit',20]], true);
        $param = [];
        $result = $this->repository->getList($param,$limit);
        return $this->success($result);
    }

}