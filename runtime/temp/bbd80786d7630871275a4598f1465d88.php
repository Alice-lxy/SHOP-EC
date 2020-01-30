<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\exam\examadd.html";i:1542618157;s:73:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\layout.html";i:1541750001;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\head.html";i:1542158279;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\left.html";i:1542163269;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>layout 后台大布局 - Layui</title>
  <link rel="stylesheet" href="__STATIC__/layui/css/layui.css">
  <script src="__STATIC__/layui/layui.js"></script>
  <script src="__STATIC__/jquery-3.2.1.min.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">

  
  <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
     <div class="layui-header">
    <div class="layui-logo">layui 后台布局</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
<!--     <ul class="layui-nav layui-layout-left">
  <li class="layui-nav-item"><a href="">控制台</a></li>
  <li class="layui-nav-item"><a href="">商品管理</a></li>
  <li class="layui-nav-item"><a href="">用户</a></li>
  <li class="layui-nav-item">
    <a href="javascript:;">其它系统</a>
    <dl class="layui-nav-child">
      <dd><a href="">邮件管理</a></dd>
      <dd><a href="">消息管理</a></dd>
      <dd><a href="">授权管理</a></dd>
    </dl>
  </li>
</ul> -->
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <!-- <img src="http://t.cn/RCzsdCq" class="layui-nav-img"> -->
          <?php echo \think\Session::get('adminInfo.admin_name'); ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="<?php echo url('login/quit'); ?>">退了</a></li>
    </ul>
  </div>
  

    </body>
</html>
  
  <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    	  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item ">
          <a class="" href="javascript:;">分类管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('Category/cateAdd'); ?>">分类添加</a></dd>
            <dd><a href="<?php echo url('Category/cateList'); ?>">分类展示</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">品牌管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('Brand/brandAdd'); ?>">品牌添加</a></dd>
            <dd><a href="<?php echo url('Brand/brandList'); ?>">品牌展示</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">商品管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('Goods/goodsAdd'); ?>">商品添加</a></dd>
            <dd><a href="<?php echo url('Goods/goodsList'); ?>">商品展示</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">管理员管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('Admin/adminAdd'); ?>">管理员添加</a></dd>
            <dd><a href="<?php echo url('Admin/adminList'); ?>">管理员展示</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">友链管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('Friend/friendAdd'); ?>">友链添加</a></dd>
            <dd><a href="<?php echo url('Friend/friendList'); ?>">友链展示</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">系统管理</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;">系统添加</a></dd>
            <dd><a href="javascript:;">系统展示</a></dd>
          </dl>
        </li>
      </ul>
    </div>
  </div>
    </body>
</html>

  <div class="layui-body">
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;">welcome to here</div> -->
    <div style="padding: 15px; width:900px">
<!-- <form action="<?php echo url('Exam/examInsert'); ?>" method="post"> -->
	<form class="layui-form" action="">
	<table>
		<thead>
		<tr align="center">
				<td>学生姓名</td>
				<td>学生年龄</td>
				<td>学生性别</td>
				<td>符号</td>
			</tr>
		</thead>
		<!-- <tr>
			<td><input type="text" name="username[]"></td>
			<td><input type="text" name="age[]"></td>
			<td><input type="text" name="sex[]"></td>
			<td><input type="button" value="+" style="width: 30px;" class="btn"></td>
		</tr> -->
		<tbody id="show">
			<tr>
				<td><input type="text" name="username"></td>
				<td><input type="text" name="age"></td>
				<td><input type="text" name="sex"></td>
				<td><input type="button" value="+" style="width: 30px;" class="btn"></td>
			</tr>
		</tbody>
	</table>
	<input type="submit" value="保存" class="add" style='width: 80px; background-color: #256678; border: 2px #872941 solid'>
	</form>
<!-- </form> -->
</div>
<script>
	$(function(){
		layui.use(['form','layer'],function(){
			var form = layui.form;
			var layer = layui.layer;
			//+-
			$(document).on('click','.btn',function(){
				var _this = $(this);//+
				var _value = _this.val();
				if(_value=='+'){
					var _tr = _this.parents('tr').clone();
					_this.parents('tr').after(_tr);
					_this.val('-');
				}else{
					//删除
					_this.parents('tr').remove();
				}
			})
			//
			
			$(document).click(function(){
				var _tr = $('#show').find('tr');
				//找到每个tr中的input
				var str="";
				for(var i=0;i<_tr.length;i++){
					var _input = _tr.eq(i).find("input[name]");
					// console.log(_input)
					for(var g=0;g<_input.length;g++){
						var n = _input.eq(g).prop('name');
						// console.log(n); 字段名
						var v = _input.eq(g).val();
						// console.log(v);//值
						str+=n+":"+v+",";
					}
					str+="|";
					// console.log(str);
				}
				$.post(
					"<?php echo url('Exam/examInsert'); ?>",
					{str:str},
					function(msg){
						// layer.msg(msg.font,{icon:msg.code});
						console.log(msg);
					}
				);
			})
		})
		

	})
</script>
  </div>
  
</div>

<script>
//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;
});
</script>
</body>
</html>