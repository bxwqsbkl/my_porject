<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - 添加管理员 </title>
    <meta name="robots" content="noindex, nofollow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="/Public/Styles/general.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/Styles/main.css" rel="stylesheet" type="text/css"/>
    <link href="/Public/ext/uploadify/common.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">管理员列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加管理员 </span>
</h1>
<div style="clear:both"></div>
<div class="main-div">
    <form method="post" action="<?php echo U();?>" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">管理员名称</td>
                <td>
                    <?php if(isset($row)): echo ($row["username"]); ?>
                    <?php else: ?>
                        <input type="text" name="username" maxlength="60" value=""/><?php endif; ?>
                </td>
            </tr>
            <?php if(!isset($row)): ?><tr>
                    <td class="label">密码</td>
                    <td>
                        <input type="password" name="password" value=""/>
                    </td>
                </tr>
                <tr>
                    <td class="label">确认密码</td>
                    <td>
                        <input type="password" name="repassword" value=""/>
                    </td>
                </tr><?php endif; ?>
            <tr>
                <td class="label">邮箱</td>
                <td>
                    <?php if(isset($row)): echo ($row["email"]); ?>
                    <?php else: ?>
                        <input type="text" name="email" value=""/><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="label">所属角色</td>
                <td>
                    <?php if(is_array($roles)): foreach($roles as $key=>$role): ?><label><input type="checkbox" class="role_id" name="role_id[]" value="<?php echo ($role["id"]); ?>"/><?php echo ($role["name"]); ?></label><?php endforeach; endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br/>
                    <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>"/>
                    <input type="submit" class="button" value=" 确定 "/>
                    <input type="reset" class="button" value=" 重置 "/>
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="footer">
    共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br/>
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/ext/layer/layer.js"></script>
<script type="text/javascript">
    <?php if(isset($row)): ?>$('.role_id').val(<?php echo ($row["role_id"]); ?>);<?php endif; ?>
</script>
</body>
</html>