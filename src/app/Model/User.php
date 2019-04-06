<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as Model;

class User extends Model {
    /**
     * [getDataByUserName 根据用户名获取数据]
     * @Author   czt
     * @DateTime 2019-03-31
     * @return   [type]     [description]
     */
    public function getDataByUserName($username)
    {
        return $this->getORM()->where('username', $username)->fetchOne();
    }
}