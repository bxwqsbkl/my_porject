<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($act); ?> </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Styles/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/ext/uploadify/common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">商品列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($act); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U();?>" enctype="multipart/form-data" >
        <input name="name" value="<?php echo ($row["name"]); ?>" style="width:100%;height:40px;text-align: center;font-size:35px;"  placeholder="请输入商品名称" />
        <!-- 加载编辑器的容器 -->
        <script id="container" style="height:400px;" name="content" type="text/plain"><?php echo ($row["content"]); ?></script>
        <!-- 配置文件 -->
        <script type="text/javascript" src="/Public/ext/ueditor/ueditor.config.js"></script>
        <!-- 编辑器源码文件 -->
        <script type="text/javascript" src="/Public/ext/ueditor/ueditor.all.js"></script>
        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            var ue = UE.getEditor('container', {
                autoHeight: false,
//               配置工具按钮,全部工具在这个配置文件中ueditor.config.js
                toolbars:[['fullscreen', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'map', 'gmap', 'insertframe', 'webapp', 'pagebreak', 'template', 'background', '|',
                    'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                    'print', 'preview', 'searchreplace', 'drafts', 'help']],
            });
        </script>
        <!--请选择分类:-->
        <!--<select name="goods_category_id" id="goods_category">-->
            <!--<?php if(is_array($gcs)): foreach($gcs as $key=>$gc): ?>-->
                <!--<option value="<?php echo ($gc["id"]); ?>]">[<?php echo ($gc["name"]); ?></option>-->
            <!--<?php endforeach; endif; ?>-->
        <!--</select><br>-->
        请选择分类:
        <input type="hidden" name="goods_category_id" id="goods_category_id" value="<?php echo ($row["goods_category_id"]); ?>"/>
        <input type="text" disabled="disabled" style="padding-left:1em" id="goods_category_name"/>
        <ul id="parent_nodes" class="ztree"></ul>
        所属品牌:
        <select name="brand_id" id="brand">
            <?php if(is_array($brands)): foreach($brands as $key=>$brand): ?><option value="<?php echo ($brand["id"]); ?>"><?php echo ($brand["name"]); ?></option><?php endforeach; endif; ?>
        </select>
        供应商:
        <select name="supplier_id" id="supplier">
            <?php if(is_array($suppliers)): foreach($suppliers as $key=>$supplier): ?><option value="<?php echo ($supplier["id"]); ?>"><?php echo ($supplier["supplier_name"]); ?></option><?php endforeach; endif; ?>
        </select><br>
        市场价:<input type="text" name="market_price" value="<?php echo ($row["market_price"]); ?>" />
        本店售价:<input type="text" name="shop_price" value="<?php echo ($row["shop_price"]); ?>" /><br>
        库存:<input type="text" name="stock" value="<?php echo ($row["stock"]); ?>" />
        商品状态:
        <input type="checkbox" name="goods_status[]" value="1" class="goods_status" />精品
        <input type="checkbox" name="goods_status[]" value="2" class="goods_status" />新品
        <input type="checkbox" name="goods_status[]" value="4" class="goods_status" />热销<br>
        是否上架:
        <input type="radio" name="is_on_sale" value="1" class="is_on_sale" />是
        <input type="radio" name="is_on_sale" value="0" class="is_on_sale" />否<br>

        商品排序: <input type="text" name="sort" value="<?php echo ($row["sort"]); ?>" placeholder="数字越小越靠前" /><br>
        上传商品LOGO:<input type="file" id="logo" />
        <img src='<?php echo ($row["logo"]); ?>' id='logo-preview' style='max-width: 80px;max-height: 60px;margin-top:10px'/><br>
        商品相册:
        <div>
            <span style="color: red;"><%--双击删除图片--%></span>
            <div id="fileQueue"></div>
            <input type="file" name="uploadify" id="uploadify" />
        </div>
        <input type="hidden" name="logo" id="logo-url" value="<?php echo ($row["logo"]); ?>" />
        <input name="status" type="hidden" value="1" />
        <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>" />
        <input type="submit" class="button" value=" 确定 " />
        <input type="reset" class="button" value=" 重置 " />
    </form>
</div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/ext/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/Public/ext/layer/layer.js"></script>
<link href="/Public/ext/ztree/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/ext/ztree/jquery.ztree.core.min.js"></script>
<script type="text/javascript">
    $('#fileQueue').on('dblclick','img',function(){
        var src=$(this).attr('src');
            $("input[type='hidden']").each(function(){
                if($(this).val() == src){
                    this.remove();
                }
            })
        this.remove();
    });
    $('#logo-preview').dblclick(function(){
        $('#logo-preview').removeAttr('src');
    });
    $(function() {
        //回显状态
        <?php if(isset($row)): ?>var img_html='';
            var input_html='';
            $(<?php echo ($row["path"]); ?>).each(function(i,v){
                img_html+="<img src="+ v + " style='width:100px; height:80px;' />";
                input_html+="<input type='hidden' class='gallery_img' name='gallery_img[]' value="+v+" />";
            });
            $('#fileQueue').html(img_html+input_html);<?php endif; ?>
        $('.goods_status').val(<?php echo ($row["goods_status"]); ?>);
        $('.is_on_sale').val([<?php echo ((isset($row["is_on_sale"]) && ($row["is_on_sale"] !== ""))?($row["is_on_sale"]):1); ?>]);
        $('#supplier').val([<?php echo ((isset($row["supplier_id"]) && ($row["supplier_id"] !== ""))?($row["supplier_id"]):1); ?>]);
        $('#brand').val([<?php echo ((isset($row["brand_id"]) && ($row["brand_id"] !== ""))?($row["brand_id"]):1); ?>]);
        $('#goods_category').val([<?php echo ((isset($row["goods_category_id"]) && ($row["goods_category_id"] !== ""))?($row["goods_category_id"]):1); ?>]);
    $('#logo').uploadify({
        swf: '/Public/ext/uploadify/uploadify.swf',
        uploader: "<?php echo U('Upload/upload');?>",
        buttonText:'选择图片',
        fileTypeDesc:'选择文件吧',
        onUploadSuccess:function(file,data){
            //将响应数据转换为json对象
            data = $.parseJSON(data);
            if(data.status == 0){
                layer.msg(data.msg,{icon: 5});
            }else{
                layer.msg(data.msg,{icon: 6});
                $('#logo-url').val(data.url);
                $('#logo-preview').attr('src',data.url);
            }
        },
    });
    $('#uploadify').uploadify({
        swf: '/Public/ext/uploadify/uploadify.swf',
        uploader: "<?php echo U('Upload/upload');?>",
        buttonText:'立即上传',
        fileTypeDesc:'选择文件吧',
        queueID: 'fileQueue',
        multi: true,
        onUploadSuccess:function(file,data){
            //将响应数据转换为json对象
            data = $.parseJSON(data);
            var path='';
            if(data.status == 0){
                layer.msg(data.msg,{icon: 5});
            }else{
                layer.msg(data.msg,{icon: 6});
                var str_html="<img src="+ data.url + " style='width:100px; height:80px;'>"+"<input type='hidden' class='gallery_img' name='gallery_img[]' value="+data.url+" />";
                $('#fileQueue').append(str_html);
            }
        },
    });
    });
</script>
<script type="text/javascript">
    var setting = {
        data: {
            simpleData: {
                enable: true,
                pIdKey:'parent_id',
            }
        },
        callback:{
            onClick:function(event,tree_ele,node){
                $('#goods_category_id').val(node.id);
                $('#goods_category_name').val(node.name);
            },
        },
    };
    var zNodes = <?php echo ($gcs); ?>;
    $(document).ready(function() {
        var ztree_obj = $.fn.zTree.init($("#parent_nodes"),setting,zNodes);
        ztree_obj.expandAll(true);
        <?php if(isset($row)): ?>//回显数据，选中父级节点
            //找到节点
            var parent_node = ztree_obj.getNodeByParam('id',<?php echo ($row["goods_category_id"]); ?>);
            ztree_obj.selectNode(parent_node);
            $('#goods_category_name').val(parent_node.name);<?php endif; ?>
    });
</script>
</body>
</html>