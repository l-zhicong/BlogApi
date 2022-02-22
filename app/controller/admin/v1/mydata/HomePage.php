<?php
/**
 * Class HomePage
 * @package app\controller\admin\v1\mydata
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
namespace app\controller\admin\v1\mydata;

use app\common\Base\AdminBaseController;
use app\common\logic\homepage\MyHomePage;
use app\validate\admin\mydata\HomePageValidate;
use think\App;

class HomePage extends AdminBaseController
{
    public function __construct(App $app,MyHomePage $repository)
    {
        $this->repository = $repository;
        parent::__construct($app);
    }

    public function getList(){
        [$page, $limit] = $this->request->getMore([['page', 1],['limit',20]], true);
        $newData["list"] = [
            [
              "id"=>1,
              "name"=>"名称",
              "synopsis"=>"摘要",
              "status"=>1,
              "is_app_str"=>"应用",
              "skills_id"=>[
                  ["id"=>1,"name"=>"php"]
              ],
            "skills_name"=> "php,java",
          "img_class"=>[
              ["id"=>1,"name"=>"家里的图"]
          ],
                "img_class_name"=>
            "家里的图"
          ],
        ];
        return $this->success($newData);
    }

    public function create(HomePageValidate $validate){
        $validate->goCheck();
        [$name,$synopsis,$is_app,$skils,$img_class_ids] = $this->request->postMore(['name','synopsis',['is_app',0],'skils','img_class_ids'],true);
        $res = $this->repository->create($name,$synopsis,$is_app,$skils,$img_class_ids);
        return $this->success($res);
    }

    public function getInfo(){

    }

    public function updata(){

    }

    public function delete(){

    }

}