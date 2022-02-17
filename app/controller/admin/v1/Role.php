<?php

namespace app\controller\admin\v1;
use app\common\Base\AdminBaseController;
use app\common\logic\system\admin\Role as RoleLogic;
use app\validate\admin\setting\SystemRoleValidata;
use think\App;

Class Role extends AdminBaseController
{
	public function __construct(App $app,RoleLogic $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }

    public function getList()
    {
        [$page, $limit] = [input('page',1),input('limit',20)];
        if($this->request->plat() == 1){
    		$platId = 0;
    	}else{
    		$platId = $this->schoolId();
    	}
        return $this->success($this->repository->search($platId, [], $page, $limit));
    }

    public function create(SystemRoleValidata $validate)
    {
    	$data = $validate->goCheck();
    	$data['plat_type'] = $this->request->plat();
    	if($this->request->plat() == 1){
    		$platId = 0;
    	}else{
    		$platId = $this->schoolId();
    	}
        $data['plat_id'] = $platId;
        $this->repository->save($data);
        return $this->success([],'添加成功');
    }

    private function checkParam($validate)
    {
    	$data = [
    		'role_name' => input('role_name'),
    		'rules' => input('rules',[1,2,3]),
    		'status' => input('status',0),
    	];
        if(!$validate->check($data)) E($validate->getError());
        return $data;
    }

    public function createForm()
    {
        return $this->success($this->repository->getMenuTree($this->plat));
    }

    public function update($id,SystemRoleValidata $validate)
    {
        if($this->request->isGet()){
            $info = $this->repository->platExists($id, $this->request->plat(), $this->plat);
            if(!$info)
                return $this->fail('数据不存在');
            $data['info'] = $info;
            $data['from'] = $this->repository->getMenuTree($this->plat);
            return $this->success($data);
        }else{
            $data = $validate->goCheck();
            if (!$this->repository->platExists($id, $this->request->plat(), $this->plat))
                return $this->fail('数据不存在');
            $this->repository->update($data,['role_id'=>$id]);
            return $this->success([],'编辑成功');
        }
            
    }

    public function updateStatus($id)
    {
        $info = $this->repository->platExists($id, $this->plat);
        if(!$info) $this->fail('数据不存在');
        $type = input('type');//1-启用，0-禁用
        if(!in_array($type, [0,1])) return $this->fail('类型不存在');
        switch ($type) {
            case 1:
                if($info['status'] == 1) return $this->fail('该管理员已是启用状态了');
                $info->save(['status' => 1]);
                break;
            case 0:
                if($info['status'] == 0) return $this->fail('该管理员已是禁用状态了');
                $info->save(['status' => 0]);
                break;
        }
        return $this->success('操作成功');
    }

    public function delete($id)
    {
        $info = $this->repository->platExists($id, $this->plat);
        if (!$info)
            return $this->fail('数据不存在');
        $info->delete($id);
        return $this->success([],'删除成功');
    }

    
}