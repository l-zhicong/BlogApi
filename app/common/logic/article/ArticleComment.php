<?php
/**
 * Class ArticleComment
 * @package app\common\logic\article
 * author:lzcong
 * time:16:39
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\article;

use app\common\logic\Base;
use app\common\model\article\ArticleComment as CommentModel;

class ArticleComment extends Base
{
    public function __construct()
    {
        $this->model = new CommentModel();
    }

    public function create($data)
    {
        try {
            if (isset($data['id']) && $data['id'] != 0) {
                $CommentObj = $this->model->field( 'level,pid,id')->find($data['id']);
                if ($CommentObj->isEmpty()){
                    $data['pid'] = 0;
                }else{
                    if ($CommentObj->level < 3) {
                        $data['pid'] = $CommentObj->id;
                        $data['level'] = $CommentObj->level + 1;
                    } else {
                        $data['pid'] = $CommentObj->pid;
                        $data['level'] = $CommentObj->level;
                    }
                }
                unset($data['id']);
                $this->model->create($data);
                return true;
            }else{
                unset($data['id']);
                $this->model->create($data);
                return true;
            }
        }catch (\Exception $e){
            return false;
        }
    }

    public function getList($articleId){
        $where = ["article_id"=>$articleId];
        $commentObj = $this->model->search($where)->select();
        return formatCategory($commentObj->toArray(),'id','pid','list');
    }

}