<?php
namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception\BadRequestException;

/**
 * 用户模块接口服务
 */
class User extends Api {
    public function getRules() {
        return array(
            'loginAction' => array(
                'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号'),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
            ),
        );
    }
    /**
     * 登录接口
     * @desc 根据账号和密码进行登录操作
     * @return boolean is_login 是否登录成功
     * @return int user_id 用户ID
     */
    public function loginAction() {
        $username = $this->username;   // 账号参数
        $password = $this->password;   // 密码参数
        // 判断账号密码是否正确
        $user     = new \App\Model\User();
        $userInfo = $user->getDataByUserName($username);
        if (!$userInfo) {
            throw new BadRequestException('账号密码错误');
        }
        //设置session
        $session = \PhalApi\DI()->session;
        $session->user_id = $userInfo['id'];
    }
}
