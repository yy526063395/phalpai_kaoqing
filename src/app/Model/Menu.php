<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as Model;

class Menu extends Model {
    /**
     * [getAllParentMenu 获取所有父节点]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getAllParentMenu()
    {
        return $this->getORM()->where(['parent_id' => 0, 'status' => 1])->fetchAll();
    }

    /**
     * [getAllParentMenu 获取子节点]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getChildrenMenu($parent_id)
    {
        return $this->getORM()->where(['parent_id' => $parent_id, 'status' => 1])->fetchAll();
    }

    public function getAllMenus()
    {
        return $this->getORM()->where('status', 1)->fetchAll();
    }

}