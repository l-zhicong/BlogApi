<?php

namespace app\service\admin\user;

class User
{
    public function getInfo(){
        return ['roles'=>["超级管理员",'饲养员'],"name"=>"廖淑慧"];
    }
}