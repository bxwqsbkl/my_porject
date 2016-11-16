<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($act); ?> </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public//Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public//Styles/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/ext/uploadify/common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">文章列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($act); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U();?>" enctype="multipart/form-data" >
        <input name="name" value="<?php echo ($row["name"]); ?>" style="width:100%;height:40px;text-align: center;font-size:35px;"  placeholder="请输入标题" />
        <!-- 加载编辑器的容器 -->
        <script id="container" style="height:400px;" name="content" type="text/plain"><?php echo ($row["content"]); ?></script>
        <!-- 配置文件 -->
        <script type="text/javascript" src="/Public/ext/ueditor/ueditor.config.js"></script>
        <!-- 编辑器源码文件 -->
        <script type="text/javascript" src="/Public/ext/ueditor/ueditor.all.js"></script>
        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            var ue = UE.getEditor('container', {
                autoHeight: false
            });
        </script>

        文章摘要:<textarea rows="3" cols="186" name="intro"><?php echo ($row["intro"]); ?></textarea><br>
        请选择分类:<select name="article_category_id" id="article_category">
        <?php if(is_array($cates)): foreach($cates as $key=>$cate): ?><option value="<?php echo ($cate["id"]); ?>"><?php echo ($cate["name"]); ?></option><?php endforeach; endif; ?>
    </select>
        文章排序:<input type="text" name="sort" value="<?php echo ($row["sort"]); ?>" placeholder="数字越小越靠前" />
        <input name="status" type="radio" value="1" class="status" />立即发表
        <input name="status" type="radio" value="0" class="status" />仅保存
        <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>" />
        <input type="submit" class="button" value=" 确定 " />
        <input type="reset" class="button" value=" 重置 " />
    </form>
</div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="/Public//Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/ext/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/Public/ext/layer/layer.js"></script>
<script type="text/javascript">
    $(function() {
        //回显状态
        $('.status').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
        $('#article_category').val([<?php echo ((isset($row["article_category_id"]) && ($row["article_category_id"] !== ""))?($row["article_category_id"]):1); ?>]);
    });
</script>
</body>
</html>