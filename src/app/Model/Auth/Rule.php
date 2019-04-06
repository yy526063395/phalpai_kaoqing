<?php
namespace App\Model\Auth;

use PhalApi\Model\NotORMModel as Model;

class Rule extends Model {
    /**
     * [getAllDatas 获取所有数据]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getAllDatas()
    {
        $datas = $this->getORM()->where('status', 1)->fetchAll();
        return $datas;
    }
}