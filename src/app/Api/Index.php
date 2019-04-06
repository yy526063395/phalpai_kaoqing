<?php
namespace App\Api;

use PhalApi\Api;

/**
 * 后台首页模块
 */
class Index extends Api {
    // public function getRules() {
    //     return array(
    //         'login' => array(
    //             'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号'),
    //             'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
    //         ),
    //     );
    // }
    public function indexAction()
    {
        return ['errcode' => 0];
    }
}
