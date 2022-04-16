<?php
/**
 * author lzhicong
 * Date: 2022/2/16
 * Time: 14:35
 * comment:文件说明
 */

/**
 * Class ArticleCategory
 * @package app\common\logic\article
 * author:lzhicong
 * time:14:35
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\article;

use app\common\logic\Base;
use app\common\model\article\ArticleCategory as ArticleCategoryModel;

class ArticleCategory extends Base
{
    public function __construct()
    {
        $this->model = new ArticleCategoryModel();
    }

    public function getdata($id,array $where)
    {
        $where['article_category_id'] = $id;
        $query = $this->model->search($where);
        $data = $query->find();
        $newData = [
            'id'=>$data['article_category_id'],
            'pid'=>$data['pid'],
            'title'=>$data['title'],
            'info'=>$data['info'],
            'image'=>$data['image'],
            'status'=>$data['status'],
            'sort'=>$data['sort']
        ];
        return $newData;
    }

    /**
     * Notes:
     * User: lzcong
     * DateTime: 2022/2/16 16:50
     * @param $data
     */
    public function create($param)
    {
        if (isset($arr['pid']) && !empty($arr['pid']) && !$this->getCategoryId($param['pid']))
            E('上级分类不存在');
        return $this->model->save($param);
    }

    public function switchStatus(int $id,int $status){
        if (!$this->getCategoryId(['article_category_id'=>$id]))E('分类不存在');
        $res = $this->model->where(['article_category_id'=>$id])->update(compact('status'));
        return $res;
    }

    public function getFormatList($status = null)
    {
        $where = ['status'=>$status];
        $query = $this->model->search($where);
        $list = $query->select()->toArray();
        return formatCategory($list, 'article_category_id');
    }

    public function getCategoryId($cid){
        return $this->model->existsWhere(['article_category_id'=>$cid]);
    }

    public function getList($where,$limit)
    {
        $query = $this->model->search($where);
        $list = $query->paginate($limit, false);
        return formatPaginate($list);
    }

}