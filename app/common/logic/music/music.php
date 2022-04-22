<?php
namespace app\common\logic\music;
use app\common\logic\Base;
use app\common\model\music\music as musicModel;
/**
 * Class music
 * @package ${NAMESPACE}
 * author:lzcong
 * time:15:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class music extends Base
{
    public function __construct()
    {
        $this->model = new musicModel();
    }

    public function getList($where,$limit){
        $musicModel = $this->model->search($where);
        $list = $musicModel->paginate($limit, false);
        return formatPaginate($list);
    }

}