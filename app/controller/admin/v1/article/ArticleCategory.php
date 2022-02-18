<?php
/**
 * author lzcong
 * Date: 2022/2/16
 * Time: 13:41
 * comment:文件说明
 */

/**
 * Class ArticleCategory
 * @package app\controller\admin\v1\article
 * author:lzcong
 * time:13:41
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\admin\v1\article;

use app\common\Base\AdminBaseController;
use app\validate\admin\article\ArticleCategoryValidate;
use app\common\logic\article\ArticleCategory as ArticleCategoryRepository;
use think\App;

class ArticleCategory extends AdminBaseController
{

    public function __construct(App $app,ArticleCategoryRepository $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }

    public function list()
    {
       [$static] = $this->request->postMore(['static'],true);
       $result = $this->repository->getFormatList($static);
       return $this->success($result);
    }

    public function switchStatus($id)
    {
        $status = $this->request->postMore(['status'], true) == 1 ? 1 : 0;
        $res = $this->repository->switchStatus($id,$status);
        return $this->success($res,'修改成功');
    }

    public function create(ArticleCategoryValidate $validate)
    {
        $param = $validate->isCreate()->goCheck();
        $this->repository->create($param);
        return $this->success([],'添加成功');
    }

    public function update($id, ArticleCategoryValidate $validate)
    {
        if($this->request->isGet())
        {
            $data = $this->repository->getdata($id,[]);
            return $this->success($data,'操作成功');
        }else{
            $validate->isUpdate()->goCheck();
            $arr = request()->post();
            if (!$this->repository->existsWhere(['article_category_id'=>$id]))
                E('数据不存在');
            if (isset($arr['pid']) && !$this->repository->existsWhere(['pid'=>$arr['pid']]))
                E('上级分类不存在');
            $this->repository->save($arr,['article_category_id'=>$id]);
            return $this->success('编辑成功');
        }
    }

    public function delete($id)
    {
        if ($this->repository->existsWhere(['pid'=>$id]))
            E('存在子级,无法删除');
        $data = $this->repository->get($id);
        if(empty($data))E('已经删除');
        $res = $data->delete($id);
        return $this->success('删除成功',$res);
    }
}