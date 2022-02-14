<?php
namespace app\common\logic;
class Base
{

	protected $model;

    public function setmodel($model)
    {
        $this->model = $model;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->model, $name], $arguments);
    }

}