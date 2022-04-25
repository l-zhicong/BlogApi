<?php
namespace app\common\logic\homepage;
use app\common\logic\Base;
use app\common\model\homepage\MyHomePage as MyHomePageModel;
use think\Exception;
use think\facade\Db;
use think\facade\Log;

/**
 * Class MyHomePage
 * @package app\common\logic\article
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class MyHomePage extends Base
{

    public function __construct()
    {
        $this->model = new MyHomePageModel();
    }

    public function getInfo(){

        $MyHomePageObj = $this->model->search([],1)->find();
        if (is_null($MyHomePageObj)){
            return [];
        }
        $newData = $MyHomePageObj->toArray();
        $newData['img'] = $MyHomePageObj->Img()->where('is_del',0)->select()->toArray();
        $newData['skills'] = $MyHomePageObj->Skills;
        return $newData;
    }

    public function create($name,$synopsis,$is_app,array $skils,array $img_class_ids){
        $homepageData = [
            'name'=>$name,
            'synopsis'=>$synopsis,
            'is_app'=>$is_app,
            'img_class_ids'=>implode(",",$img_class_ids)
        ];
        foreach ($skils as $v){
            $skilsData[]  = [
                'name' => $v['name'],
                'schedule' => $v['schedule']
            ];
        }
        $this->model->startTrans();
        try{
            $MyHomePageModel = $this->model->create($homepageData);
            $MyHomePageModel->Skills()->saveAll($skilsData);
            $this->model->commit();
        }catch (Exception $e){
            $this->model->rollback();
//            Log::save()
            E("添加失败");
        }
        return ['id'=>$MyHomePageModel->id];

    }


}