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
use app\common\logic\article\ArticleComment;
use app\common\logic\article\ArticleFabulous;
use app\validate\api\article\ArticleValidate;
use think\App;
use app\common\logic\article\Article as ArticleRepository;
use think\Cache;
use think\Exception;

class Article extends ApiBaseController
{
    public function __construct(App $app,ArticleRepository $repository,ArticleValidate $validate)
    {
        parent::__construct($app);
        $this->repository = $repository;
        $this->validate = $validate;
    }

    public function getList(){
        $this->validate->goCheck();
        [$cid, $limit] = $this->request->getMore([['cid'],['limit',20]], true);
        $where = ['cid'=>$cid];
        $res = $this->repository->List($where,$limit);
        return $this->success($res);
    }

    public function getInfo($id){
        $this->validate->getInfo()->goCheck();
        $where = ["id"=>$id];
        $res = $this->repository->getData($where);
        return $this->success($res);
    }

    public function Fabulous(){
        [$uid,$article_id] = $this->request->postMore(['uid','article_id']);
        $has = (new ArticleFabulous())->updateFabulous($uid,$article_id);
        if ($has){
            return $this->success([]);
        }else{
            return $this->fail();
        }

    }

    public function Comment(){
        $this->validate->getInfo()->goCheck();
        try {
            $param = $this->request->post();
            $ArticleCommentModel = new ArticleComment();
            $res  = $ArticleCommentModel->create($param);
            return $this->success($res);
        }catch (Exception){
            $this->fail("评论失败");
        }
    }
}