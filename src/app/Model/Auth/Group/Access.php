<?php
namespace App\Model\Auth\Group;

use PhalApi\Model\NotORMModel as Model;

class Access extends Model {
    /**
     * [getDataByUid 获取所有数据]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getDataByUid($uid)
    {
        $datas = $this->getORM()->where(['status' => 1, 'uid' => $uid])->fetchOne();
        return $datas;
    }
}