<?php
namespace app\common\model\user;
use app\common\logic\article\ArticleComment;
use app\common\model\article\ArticleFabulous;
use app\common\model\BaseModel;

/**
 * Class User
 * @package ${NAMESPACE}
 * author:lzcong
 * time:22:30
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class User extends BaseModel
{
    public $table = "user";
    public $pk = 'id';

    /**
     * 我点赞的
     * @return \think\model\relation\HasOne
     */
    public function articleFabulous()
    {
        return $this->hasOne(ArticleFabulous::class,'id','uid');
    }

    /**
     * 我评论的
     * @return \think\model\relation\HasOne
     */
    public function crticleComment()
    {
        return $this->hasOne(ArticleComment::class,'id','uid');
    }


    public function getAccountInfo($account)
    {
        $UserMode = $this->find();
        return $UserMode;
    }

}