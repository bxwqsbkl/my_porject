<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">新增商品</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="<?php echo U();?>" name="searchForm">
    <img src="/Public/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
    <input type="text" name="goods_name" size="15" />
    <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>商品名称</th>
                <th>所属分类</th>
                <th>品牌</th>
                <th>供应商</th>
                <th>市售(元)</th>
                <th>实售(元)</th>
                <th>库存</th><th>商品状态</th><th>上架</th><th>排序</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                <td class="first-cell" align="center">
                 <span><?php echo ($row["name"]); ?></span>
                 </td>
                 <td class="first-cell" align="center">
                     <span><?php echo ($row["gcname"]); ?></span>
                 </td>
                <td align="center">
                    <?php echo ($row["bname"]); ?>
                </td>
                 <td align="center">
                     <?php echo ($row["sname"]); ?>
                 </td>
                 <td align="center">
                     <?php echo ($row["market_price"]); ?>
                 </td>
                 <td align="center">
                     <?php echo ($row["shop_price"]); ?>
                 </td>
                 <td align="center">
                     <?php echo ($row["stock"]); ?>
                 </td>
                <td align="center"><?php echo ($row["goodsstatus"]); ?></td>
                <td align="center"><img src="/Public/Images/<?php echo ($row["is_on_sale"]); ?>.gif" /></td>
                 <td class="first-cell" align="center">
                     <span><?php echo ($row["sort"]); ?></span>
                 </td>
                <td align="center">
                <a href="<?php echo U('edit',['id'=>$row['id']]);?>" title="编辑">编辑</a> |
                <a href="<?php echo U('remove',['id'=>$row['id']]);?>" title="移除">移除</a>
                </td>
            </tr><?php endforeach; endif; ?>
            <tr>
                <td align="center" nowrap="true" colspan="11">
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