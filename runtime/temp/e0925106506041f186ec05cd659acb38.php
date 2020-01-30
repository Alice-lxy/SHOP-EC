<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\admin\adminlist.html";i:1542545545;s:73:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\layout.html";i:1541750001;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\head.html";i:1542158279;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\left.html";i:1542849080;}*/ ?>
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
        <li class="layui-nav-item"><!-- $_SESSION['admin_name'] -->  
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
          <a href="javascript:;">系统设置</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('System/system'); ?>">网站设置</a></dd>
            <dd><a href="<?php echo url('Admin/updatePwd'); ?>">修改密码</a></dd>
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
    <div style="padding: 15px; width:690px">
    <h2 align="center">管理员列表展示</h2>
	<table id="demo" lay-filter = "table_edit"></table>
</div>

<script type="text/html" id="barDemo">
	<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
	<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script>
	$(function(){
		layui.use(['table','layer'],function(){
			var table = layui.table;
			var layer = layui.layer;
			
			table.render({
			    elem: '#demo'
			    ///,height: 312
			    ,url: "<?php echo url('Admin/getAdminInfo'); ?>" //数据接口
			    ,page: true //开启分页
			    ,limit:3
			    ,cols: [[ //表头
			      {field: 'admin_id', title: 'ID', width:60, sort: true, fixed: 'left'}
			      ,{field: 'admin_name', title: '管理员名称', width:80}
			      ,{field: 'admin_email', title: '邮箱', edit: 'text',width:140}
			      ,{field: 'admin_tel', title: '手机号', edit: 'text',width:120} 
			      ,{field: 'create_time', title: '添加时间', width:160} 
			      ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:122}
			    ]]
			});
			//监听单元格编辑
			table.on('edit(table_edit)',function(obj){
				var value = obj.value//得到修改后的值
					,admin_id = obj.data.admin_id//得到所在行的所有键值data = obj.data
					,field = obj.field;//得到字段
				$.post(
						"<?php echo url('Admin/adminUpdate'); ?>",
						{value:value,field:field,admin_id:admin_id},
						function(msg){
							layer.msg(msg.font,{icon:msg.code});
						}
						,'json'
					)
			})
			//监听工具条 删除.编辑
			table.on('tool(table_edit)',function(obj){
				var data = obj.data;//获得当前数据
				
				if(obj.event==='del'){
					//是否确认删除？
					layer.confirm('是否确认删除？',{icon:3},function(index){
						$.post(
							"<?php echo url('Admin/adminDel'); ?>",
							{admin_id:data.admin_id},
							function(msg){
								layer.msg(msg.font,{icon:msg.code});
								if(msg.code==1){
									table.reload('demo');//重载表格
								}
							},'json'
						);
					});
				}else if(obj.event==='edit'){
					location.href="<?php echo url('admin/adminUpd'); ?>?admin_id="+data.admin_id;
				}

			})
		});

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