<?php

namespace app\common\logic\user;

interface  AbsUser
{
    public function login($param);

    public function getInfo($uid);

    public function register(Array $param);
}