<?php
namespace App\Model\Menu;

use PhalApi\Model\NotORMModel as Model;
use App\Model\Auth\Group\Access;
class User extends Model {
    /**
     * [getAllDatas 获取所有数据]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getAllDatasByUid($uid)
    {
        $access = new Access;
        $userInfo = $access->getDataByUid($uid);
        if (!$userInfo) {
            return [];
        }
        $datas = $this->getORM()->where(['auth_group_id' => $userInfo['group_id'], 'status' => 1])->fetchOne();
        return $datas;
    }


    public function getDataByGid($gid)
    {
        $datas = $this->getORM()->where(['auth_group_id' => $gid, 'status' => 1])->fetchOne();
        return $datas;
    }
}