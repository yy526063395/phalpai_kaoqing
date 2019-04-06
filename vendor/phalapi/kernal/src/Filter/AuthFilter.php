<?php
namespace PhalApi\Filter;

use PhalApi\Filter;
use PhalApi\Exception\BadRequestException;


class AuthFilter implements Filter {

    public function check()
    {
        $di     = \PhalApi\DI();
        // $cookie = new \PhalApi\Cookie();
        // $userId = $cookie->get('user_id');

        $userId = $di->session->user_id;
        if (!$userId) {
            throw new BadRequestException('未登录', 4001);
        }
        $api    = $di->request->get('service','Default.IndexAction'); //获取当前访问的接口
        if (!stripos($api, 'Action')) {
            throw new BadRequestException('方法不存在', 4003);
        }
        $r      = $di->authLite->check($api,$userId);
        if (!$r) {
            throw new BadRequestException('没有权限', 4002);
        }
    }
}
