<?php
/**
 * author lzhicong
 * Date: 2022/2/16
 * Time: 14:35
 * comment:文件说明
 */

/**
 * Class ArticleFabulous
 * @package app\common\logic\article
 * author:lzhicong
 * time:14:35
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\article;
use app\common\logic\Base;
use app\common\logic\article\ArticleFabulous as model;

class ArticleFabulous extends Base
{
    public function __construct()
    {
        $this->model = new model();
    }

    /**
     * 用户是否点赞
     */
    public function isFabulous($uid,$article_id)
    {
        $map['uid'] = $uid;
        $map['article_id'] = $article_id;
        $map['status'] = 1;
        return $this->model->where($map)->count() > 0 ? true :false;
    }

    /**
     * 更改点赞状态
     */
    public function updateFabulous($uid,$article_id,Article $article)
    {
        $data['uid'] = $uid;
        $data['article_id'] = $article_id;
        if(!$article->find($article_id))E('文章不存在');
        $info = $this->model->where($data)->find();
        if(!$info){
            $this->model->save($data);
        }else{
            $status = $info['status'] == 1 ? 0 : 1;
            $info->save(['status'=>$status]);
        }
        return true;
    }
}