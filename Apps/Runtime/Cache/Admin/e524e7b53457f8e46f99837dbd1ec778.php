<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['shopTitle']['fieldValue']); ?>后台管理中心</title>
      <link href="/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="/Public/js/html5shiv.min.js"></script>
      <script src="/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/Public/js/jquery.min.js"></script>
      <script src="/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Public/js/common.js"></script>
      <script src="/Public/plugins/plugins/plugins.js"></script>
      <script src="/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
      <script src="/Public/plugins/kindeditor/kindeditor.js"></script>
      <script src="/Public/plugins/kindeditor/lang/zh-CN.js"></script>
   </head>
   <script>
   $(function () {
	   KindEditor.ready(function(K) {
			editor1 = K.create('textarea[name="articleContent"]', {
				height:'350px',
				allowFileManager : false,
				allowImageUpload : true,
				items:[
				        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
				        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
				        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
				        'anchor', 'link', 'unlink', '|', 'about'
				],
				afterBlur: function(){ this.sync(); }
			});
		});
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   edit();
			       return false;
			},onError:function(msg){
		}});
	   $("#articleTitle").formValidator({onFocus:"请输入文章标题"}).inputValidator({min:1,max:100,onError:"请输入100字以内文章标题"});
	   $("#catId").formValidator({onFocus:"请选择文章分类"}).inputValidator({min:1,onError: "请选择文章分类"});
	   $("#articleKey").formValidator({onFocus:"请输入关键字"}).inputValidator({min:1,max:80,onError:"请输入关键字"});
	   
   });
   function edit(){
	   var params = {};
	   params.id = $('#id').val();
	   params.re_title = $('#re_title').val();
	   params.recruit_type_id = $('#recruit_type_id').val();
	   params.re_job = $('#re_job').val();
	   params.re_dept = $('#re_dept').val();
	   params.re_position = $('#re_position').val();
	   params.re_num = $('#re_num').val();
	   params.isShow = $("input[name='isShow']:checked").val();
	   params.re_desc = $('#re_desc').val();
	   params.articleKey = $('#articleKey').val();
	   if(params.articleContent==''){
		   Plugins.Tips({title:'信息提示',icon:'error',content:'请输入文章内容!',timeout:1000});
		   return;
	   }
	   Plugins.waitTips({title:'信息提示',content:'正在提交数据，请稍后...'});
	   $.post("<?php echo U('Admin/Recruit/edit');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				Plugins.setWaitTipsMsg({ content:'操作成功',timeout:1000,callback:function(){
				   location.href="<?php echo U('Admin/Recruit/showlist');?>";
				}});
			}else{
				Plugins.closeWindow();
				Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
			}
		});
   }
   </script>
   <body class="wst-page">
       <form name="myform" method="post" id="myform" autocomplete="off">
        <input type='hidden' id='id' value='<?php echo ($object["articleId"]); ?>'/>
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th width='120' align='right'>标题<font color='red'>*</font>：</th>
             <td><input type='text' id='re_title' class="form-control wst-ipt" value='<?php echo ($object["articleTitle"]); ?>' maxLength='25'/></td>
           </tr>
           <tr>
             <th align='right'>分类<font color='red'>*</font>：</th>
             <td>
             <select id='recruit_type_id'>
                <option value='0'>请选择</option>
                <!--<?php if(is_array($catList)): $i = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                <!--<option value='<?php echo ($vo['catId']); ?>' <?php if($object['catId'] == $vo['catId'] ): ?>selected<?php endif; ?>><?php echo ($vo['catName']); ?></option>-->
                <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                 <option value="1">社会招聘</option>
                 <option value="2">校园招聘</option>
             </select>
             </td>
           </tr>
            <tr>
                <th width='120' align='right'>招聘职位<font color='red'>*</font>：</th>
                <td><input type='text' id='re_job' class="form-control wst-ipt" value='<?php echo ($object["articleTitle"]); ?>' maxLength='25'/></td>
            </tr>
            <tr>
                <th width='120' align='right'>招聘部门<font color='red'>*</font>：</th>
                <td><input type='text' id='re_dept' class="form-control wst-ipt" value='<?php echo ($object["articleTitle"]); ?>' maxLength='25'/></td>
            </tr>
            <tr>
                <th width='120' align='right'>工作地点<font color='red'>*</font>：</th>
                <td><input type='text' id='re_position' class="form-control wst-ipt" value='<?php echo ($object["articleTitle"]); ?>' maxLength='25'/></td>
            </tr>
            <tr>
                <th width='120' align='right'>招聘人数<font color='red'>*</font>：</th>
                <td><input type='text' id='re_num' class="form-control wst-ipt" value='<?php echo ($object["articleTitle"]); ?>' maxLength='25'/></td>
            </tr>
           <tr>
             <th align='right'>是否显示<font color='red'>*</font>：</th>
             <td>
             <label>
             <input type='radio' id='isShow1' name='isShow' value='1' <?php if($object['isShow'] ==1 ): ?>checked<?php endif; ?> />显示&nbsp;&nbsp;
             </label>
             <label>
             <input type='radio' id='isShow0' name='isShow' value='0' <?php if($object['isShow'] ==0 ): ?>checked<?php endif; ?> />隐藏
             </label>
             </td>
           </tr>
           <tr>
             <th align='right'>内容<font color='red'>*</font>：</th>
             <td>
             <textarea id='re_desc' name='articleContent' style='width:80%;height:400px;'><?php echo ($object["articleContent"]); ?></textarea>
             </td>
           </tr>
           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button type="submit" class="btn btn-success">保&nbsp;存</button>
                 <button type="button" class="btn btn-primary" onclick='javascript:location.href="<?php echo U('Admin/Recruit/showlist');?>'>返&nbsp;回</button>
             </td>
           </tr>
        </table>
       </form>
   </body>
</html>