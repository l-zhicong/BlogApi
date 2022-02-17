<?php
/**
 * author lzcong
 * Date: 2022/2/16
 * Time: 13:41
 * comment:文件说明
 */

/**
 * Class article
 * @package app\controller\admin\v1\article
 * author:lzcong
 * time:13:41
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\admin\v1\article;

use app\common\Base\AdminBaseController;
use app\common\logic\article\Article as ArticleRepository;
use app\common\logic\article\ArticleCategory as ArticleCategoryRepository;
use app\validate\admin\article\ArticleValidate;
use think\App;

class Article extends AdminBaseController
{

    public function __construct(App $app,ArticleRepository $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }

    public function getList(ArticleValidate $validate)
    {
        $where = [];
        [$page, $limit] = $this->request->postMore([['page', 1],['limit',20]], true);
        $res = $this->repository->List($where,$limit,$page);
        return $this->success($res);
    }

    public function ArticleCreate(ArticleValidate $validate)
    {
        $param = $validate->goCheck();
        $res = $this->repository->create($param);
        return $this->success($res,'发布成功');
    }

    public function ArticleUpdate($id , ArticleValidate $validate)
    {
        if($this->request->isGet()) {
            $res = $this->repository->getData(['id'=>$id]);
            return $this->success($res);
        }else{
            $validate->isUpdate()->goCheck();
            $param = $this->request->post();
            return $this->success($this->repository->update($id,$param));
        }
    }

    public function delete($id)
    {
        $res = $this->repository->delete($id);
        if($res)
        {
            return  $this->success('删除成功',$res);
        }else{
            return $this->fail('删除失败');
        }

    }
}