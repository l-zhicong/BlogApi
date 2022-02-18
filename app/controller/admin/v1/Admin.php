<?php
/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\admin\v1;

use app\common\Base\AdminBaseController;
use app\common\logic\system\admin\Admin as AdminLogic;
use app\validate\admin\setting\AdminValidate;
use think\App;

class Admin extends AdminBaseController
{
    public function __construct(App $app,AdminLogic $repository)
    {
        parent::__construct($app);
        $this->repository = $repository;
    }

    public function getList()
    {
        [$page, $limit] = $this->request->getMore([['page', 1],['limit',20]], true);
        $data = $this->repository->getList([], $page, $limit);
        return $this->success($data);
    }

    public function create(AdminValidate $validate)
    {
        $validate->goCheck();
        $data = [
            'account' => input('account'),
            'pwd' => input('pwd'),
            'phone' => input('phone'),
            'againPassword' => input('againPassword'),
            'real_name' => input('real_name'),
            'roles' => input('roles',[]),
            'status' => input('status',0),
            'level' => 1,
        ];
        if(!$validate->check($data)) E($validate->getError());
        if ($data['pwd'] !== $data['againPassword'])
            return $this->fail('两次密码输入不一致');
        unset($data['againPassword']);
        if ($this->repository->fieldExists('account', $data['account']))
            return $this->fail('账号已存在');
        $data['pwd'] = md5($data['pwd']);
        $this->repository->save($data);

        return $this->success([],'添加成功');
    }

    public function roleForm()
    {
        return $this->success($this->repository->roleForm($this->request->plat()));
    }

    public function update($id)
    {
        if($this->request->isGet()){
            $info = $this->repository->find($id)->hidden(['pwd']);
            if(!$info)
                return $this->fail('数据不存在');
            return $this->success($info->toArray());
        }else{
            $validate = new AdminValidate();
            $data = [
                'account' => input('account'),
                'phone' => input('phone'),
                'real_name' => input('real_name'),
                'roles' => input('roles',[])
            ];
            if(!$validate->isUpdate()->check($data))  E($validate->getError());
            if ($this->repository->fieldExists('account', $data['account'], $id))
                return $this->fail('账号已存在');
            $this->repository->update($data,['admin_id'=>$id]);
            return $this->success([],'编辑成功');
        }

    }

    public function updateStatus($id)
    {
        $info = $this->repository->find($id);
        if(!$info) return $this->fail('数据不存在');
        if($info['level'] == 0) return $this->fail('超级管理员状态不可更改');
        [$type] = $this->request->postMore(['type'],true);//1-启用，0-禁用
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
        return $this->success([],'操作成功');
    }

    public function password($id)
    {
        $validate = new AdminValidate();
        $data = [
            'pwd' => input('pwd'),
            'againPassword' => input('againPassword')
        ];
        $validate->isPassword()->check($data);

        if ($data['pwd'] !== $data['againPassword'])
            return $this->fail('两次密码输入不一致');
        if (!$this->repository->find($id))
            return $this->fail('管理员不存在');
        $data['pwd'] = md5($data['pwd']);
        unset($data['againPassword']);
        $this->repository->update($data,['admin_id'=>$id]);

        return $this->success([],'修改密码成功');
    }

    public function delete($id)
    {
        $info = $this->repository->find($id);
        if (!$info)
            return $this->fail('数据不存在');
        if($info['level'] == 0) return $this->fail('超级管理员状态不可删除');
        $this->repository->update(['is_del' => 1],['admin_id'=>$id]);
        return $this->success([],'删除成功');
    }


}