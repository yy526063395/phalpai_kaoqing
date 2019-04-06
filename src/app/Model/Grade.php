<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as Model;
/**
 * 年级表
 */
class Grade extends Model {
    /**
     * [getAllParentMenu 获取所有年级]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getAllDatas()
    {
        return $this->getORM()->where('status', 1)->fetchAll();
    }

}