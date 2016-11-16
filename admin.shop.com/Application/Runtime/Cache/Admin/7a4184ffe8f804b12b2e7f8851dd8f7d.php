<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 文章列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">发表新文章</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 文章列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="<?php echo U();?>" name="searchForm">
    <img src="/Public/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
    <input type="text" name="brand_name" size="15" />
    <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>文章标题</th>
                <th>所属分类</th>
                <th>文章概要</th>
                <th>展示状态</th>
                <th>展示排序</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                <td class="first-cell" align="center">
                 <span><?php echo ($row["name"]); ?></span>
                 </td>
                 <td class="first-cell" align="center">
                     <span><?php echo ($row["cname"]); ?></span>
                 </td>
                <td align="center">
                    <?php echo ($row["intro"]); ?>
                </td>
                <td align="center"><img src="/Public/Images/<?php echo ($row["status"]); ?>.gif" /></td>
                <td align="center"><?php echo ($row["sort"]); ?></td>
                 <td class="first-cell" align="center">
                     <span><?php echo ($row["inputtime"]); ?></span>
                 </td>
                <td align="center">
                <a href="<?php echo U('edit',['id'=>$row['id']]);?>" title="编辑">编辑</a> |
                <a href="<?php echo U('remove',['id'=>$row['id']]);?>" title="移除">移除</a>
                </td>
            </tr><?php endforeach; endif; ?>
            <tr>
                <td align="center" nowrap="true" colspan="7">
                    <div id="turn-page" class='page'>
                        <?php echo ($page_html); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>