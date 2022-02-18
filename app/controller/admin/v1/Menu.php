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
use app\common\logic\system\admin\Menu as MenuLogic;
use app\validate\admin\setting\SystemMenusValidate;
use think\App;

class Menu extends AdminBaseController
{

    public function __construct(App $app,MenuLogic $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    /**
     * Notes:
     * User: lzcong
     * DateTime: 2022/2/14 14:28
     * @return \think\Response
     */
    public function getList()
    {
        $data = $this->service->getList([], $this->plat);
        $data['list'] = formatCategory($data['list'], 'menu_id');
        return $this->success($data);
    }

    /**
     * Notes:
     * User: lzcong
     * DateTime: 2022/2/14 14:28
     * @return \think\Response
     * @throws \Exception
     */
    public function create(SystemMenusValidate $validate)
    {
        $data = $validate->isCreate()->goCheck();
        if ($data['pid'] && !$this->service->platExists($data['pid'], $data['plat_type']))
            return $this->fail('父级分类不存在');
        $this->service->add($data);
        return $this->success([]);
    }

    public function createForm()
    {
        return $this->success($this->service->menuForm($this->plat));
    }

    public function menus()
    {
        $menus = $this->request->userInfo()['level']
//            ? $this->service->ruleByMenuList($this->request->adminRule(), $this->request->plat())
            ? $this->service->getValidMenuList($this->request->plat())
            : $this->service->getValidMenuList($this->request->plat());
        foreach ($menus as $k => $menu) {
            $menu['path'] = $menu['route'];
            $menus[$k] = $menu;
        }
        return $this->success(array_values(array_filter(formatCategory($menus, 'menu_id'), function ($v) {
            return 0 == $v['pid'];
        })));
    }

    public function update($id,SystemMenusValidate $validate)
    {
        if($this->request->isGet()){
            $info = $this->service->platExists($id, $this->plat);
            if(!$info)
                return $this->fail('数据不存在');
            $data['info'] = $info;
            $data['from'] = $this->service->menuForm($this->plat, $id);
            return $this->success($data);
        }else{
            $data = $validate->isUpdate()->goCheck();
            if (!$data['pid']) $data['pid'] = 0;
            if (!$this->service->platExists($id, $this->plat))
                return $this->fail('数据不存在');
            if ($data['pid'] && !$this->service->platExists($data['pid'], $this->plat))
                return $this->fail('父级分类不存在');
            $this->service->update($data,['menu_id'=>$id]);
            return $this->success([],'编辑成功');
        }

    }

    public function delete($id)
    {
        if ($id) {
            $this->service->del($id);
            return $this->success([],'删除成功!');
        } else {
            return $this->fail('参数错误');
        }
    }

}