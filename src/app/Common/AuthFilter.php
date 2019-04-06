<?php
namespace App\Common;

use PhalApi\Filter;
use PhalApi\Exception\BadRequestException;

class AuthFilter implements Filter
{
    public function check()
    {
        $session = \PhalApi\DI()->session;
        $user_id = $session->user_id;
        var_dump($user_id);exit;
        $userId  = $di->request->get('user_id',1);//获取用户id参数
        // $user    = new App\Model\User();
        // $row     = $model->get(1);
        // var_dump($row);exit;
        $api    = $di->request->get('service','Default.Index'); //获取当前访问的接口
        $r      = $di->authLite->check($api,$userId);
        if (!$r) {
            throw new BadRequestException('没有权限', 4001);
        }
    }

}