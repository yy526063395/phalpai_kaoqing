<?php
namespace App\Api;

use PhalApi\Api;
use App\Model\Auth\Rule;
use App\Model\Menu;
use App\Model\Menu\User as menuUser;
use App\Model\Menu\User as menuGroup;
use App\Model\Auth\Group;
use PhalApi\Exception\BadRequestException;

/**
 * 后台首页模块
 */
class Auth extends Api {

    public function getRules() {
        return array(
            'getMenuMangeAction' => array(
                'group_id' => array('name' => 'group_id', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '角色组ID'),
            ),
            'editRoleMenuAction' => array(
                'group_id' => array('name' => 'group_id', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '角色组ID'),
                'menus' => array('name' => 'menus', 'require' => false, 'desc' => '节点权限','type' => 'array'),
            ),

        );
    }


    /**
     * [addAuthResource 获取权限资源]
     * @Author   czt
     * @DateTime 2019-03-31
     */
    public function addAuthResource()
    {
        $result    = [];
        $allAuths  = $this->getAllControllerAction();
        $rules     = new Rule();
        $haveRules = array_column($rules->getAllDatas(), 'name');
        foreach ($allAuths as $allAuth) {
            foreach ($allAuth as $namespace => $controllerName) {
                $className = $namespace . $controllerName;
                $class   = new \ReflectionClass($className);
                $methods = $class->getMethods();
                foreach ($methods as $method) {
                    $name = $controllerName .'.'. $method->name;
                    if (stripos($method->name, 'Action') && !in_array($name, $haveRules)) {
                        $data = array('id' => null, 'name' => $name, 'status' => '1');
                        $ret  = $rules->insert($data);
                        if (!$ret) {
                            var_dump('插入失败');exit;
                        }
                    }
                    // if () {
                    //     var_dump($name);exit;
                    // }
                }
            }
        }


        return $result;
    }


    /**
     * [getAllControllerAction 获取所有权限的控制器方法]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    private function getAllControllerAction()
    {
        return [
            ['App\Api\\' => 'User'],
            ['App\Api\\' => 'Index'],
        ];
    }
    /**
     * [getAllMothedAction 获取所有方法]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getAllMothedAction()
    {
        $rules     = new Rule();
        $ruleDatas = $rules->getAllDatas();
        foreach ($ruleDatas as $key => $rule) {
            $thisRule = explode('.', $rule['name']);
            $rule['name'] = str_replace('.', '-', $rule['name']);
            $rule['controller_name'] = $thisRule[0];
            $rule['action_name']     = $thisRule[1];
            $rule['title']     = $rule['title'] ? : '';
            $ruleDatas[$key] = $rule;
        }
        array_multisort(array_column($ruleDatas, 'controller_name'), SORT_ASC, $ruleDatas);
        return $ruleDatas;
    }
    /**
     * [getMyMenuAction 获取我的菜单]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getMyMenuAction()
    {

        $di     = \PhalApi\DI();
        $userId = $di->session->user_id;
        $menuObj = new Menu();
        $menus = $menuObj->getAllParentMenu();
        $menuUser     = new menuUser;
        $menuUserData = $menuUser->getAllDatasByUid($userId);
        $menuIds      = explode(',', $menuUserData['menu_id']);

        $result = [];
        foreach ($menus as $key => $menu) {
            if (!in_array($menu['id'], $menuIds)) {
                continue;
            }
            $data = [];
            $data['icon']  = $menu['icon'];
            $data['index'] = $menu['index'];
            $data['title'] = $menu['title'];
            $result[$menu['id']] = $data;
            $childrens = $menuObj->getChildrenMenu($menu['id']);

            foreach ($childrens as $child) {
                if (!in_array($child['id'], $menuIds)) {
                    continue;
                }
                $childData = [];
                $childData['index'] = $child['index'];
                $childData['title'] = $child['title'];
                $result[$menu['id']]['subs'][] = $childData;
            }
        }
        $result = array_values($result);
        return $result;
    }


    public function getAllMenuAction()
    {

        $di       = \PhalApi\DI();
        $userId   = $di->session->user_id;

        $menuObj = new Menu();
        $menus = $menuObj->getAllMenus();
        $menuUser     = new menuUser;
        $menuUserData = $menuUser->getAllDatasByUid($userId);
        $menuIds      = explode(',', $menuUserData['menu_id']);
        $result = [];
        $group = new Group;
        $result['roles'] = $group->getAllDatas();

        foreach ($menus as $key => $menu) {
            $result['allMenus'][] = $menu;
            if (in_array($menu['id'], $menuIds)) {
                $result['haveMenus'][] = $menu;
            }
        }
        $result['haveMenus'] = isset($result['haveMenus']) ? array_column($result['haveMenus'], 'id') : [];
        return $result;
    }





    /**
     * [getMenuMangeAction 获取节点权限管理的数据]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getMenuMangeAction()
    {

        $group_id = $this->group_id;

        $menuGroup = new menuGroup;
        $menuGroupData = $menuGroup->getDataByGid($group_id);

        return explode(',', $menuGroupData['menu_id']);
    }


    public function editRoleMenuAction()
    {

        $group_id = $this->group_id;
        $menus    = $this->menus;
        $menuGroup = new menuGroup;
        $row = $menuGroup->getDataByGid($group_id);
        if (!$row) {
            throw new BadRequestException('找不到角色');
        };
        $menu_id = $menus ? implode(',', $menus) : '';
        $ret = $menuGroup->update($row['id'], ['menu_id'=>$menu_id]);
        if ($ret === false) {
            throw new BadRequestException('修改错误');
        }
        return [];

    }


}
