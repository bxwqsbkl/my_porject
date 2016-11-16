<?php

/**
 * @link http://blog.kunx.org/.
 * @copyright Copyright (c) 2016-11-12 
 * @license kunx-edu@qq.com.
 */

namespace Common\Behaviors;

/**
 * Description of CheckPermissionBehavior
 *
 * @author kunx <kunx-edu@qq.com>
 */
class CheckPermissionBehavior extends \Think\Behavior {

    public function run(&$param) {
        //执行逻辑
        //增加排除列表，login captcha
        $ignores =C('RBAC.IGNORE');
        $url     = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
        if (in_array($url, $ignores)) {
            return true;
        }
        //检查用户是否登录
        if (!$userinfo = session('ADMIN_INFO')) {
            //尝试自动登录
            if (!D('Admin')->autoLogin()) {
                //没有登录跳转到登录页面
                $url = U('Admin/login');
                redirect($url);
            }
        }
        $user_ignores=C('RBAC.USER_IGNORE');
        //已登录用户的忽略列表
        $user_ignores = C('RBAC.USER_IGNORE');
        if (in_array($url, $user_ignores)) {
            return true;
        }
        //获取管理员的权限列表
        $permissions = session('ADMIN_PATH');
        if (in_array($url, $permissions)) {
            return true;
        } else {
            echo '<script type="text/javascript">alert("无权访问");history.back();</script>';
            exit;
        }
    }

}
