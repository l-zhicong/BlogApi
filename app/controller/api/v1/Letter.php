<?php
/**
 * Class letter
 * @package app\controller\api\v1
 * author:lzcong
 * time:20:03
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\api\v1;

use app\common\Base\ApiBaseController;
use think\App;
use app\common\logic\homepage\Letter as LetterRepository;

class Letter extends ApiBaseController
{
    public function __construct(App $app,LetterRepository $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }


    public function sendOut(){
        [$name, $email,$message] = $this->request->postMore([['name'],['email'],['message']], true);
        $data = [
            "name" => $name,
            "email" => $email,
            "message" => $message,
            "ip" => $this->request->ip()
        ];
        $res = $this->repository->create($data);
        return $this->success($res);
    }

}