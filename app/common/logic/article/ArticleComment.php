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
        $this->model = new  CommentModel;
    }

    public function create($data)
    {
        if (isset($data['id']) && empty($data['id'])) {
            $CommentOjb = $this->model->getField($data['id'], 'level,pid,id');
            if ($CommentOjb->level <= 3) {
                $data['pid'] = $CommentOjb->id;
            } else {
                $data['pid'] = $CommentOjb->pid;
            }
        }
        $res = $this->model->create($data);
        return $res;
    }

}