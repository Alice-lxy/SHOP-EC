<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:83:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\category\cateadd.html";i:1542851485;s:73:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\layout.html";i:1541750001;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\head.html";i:1542158279;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\left.html";i:1544408193;}*/ ?>
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
          <a href="javascript:;">角色管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('role/nodeadd'); ?>">角色添加</a></dd>
            <dd><a href="javascript:;">角色展示</a></dd>
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
     
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
    	<h2 align="center">分类添加</h2>
<form class="layui-form" action="">
	  <div class="layui-form-item">
	    <label class="layui-form-label">分类名称</label>
	    <div class="layui-input-block">
	      <input type="text" name="cate_name" required  lay-verify="required|checkName" placeholder="请输入分类名称" autocomplete="off" class="layui-input">
	    </div>
	  </div>
	  
	 
	 <div class="layui-form-item">
		<label class="layui-form-label">是否展示</label>
		<div class="layui-input-block">
			<input type="radio" name="cate_show" value="1" title="是">
			<input type="radio" name="cate_show" value="2" title="否" checked>
		</div>
	</div>
	  <div class="layui-form-item">
		<label class="layui-form-label">是否在导航栏上展示</label>
		<div class="layui-input-block">
			<input type="radio" name="cate_navshow" value="1" title="是">
			<input type="radio" name="cate_navshow" value="2" title="否" checked>
		</div>
	</div>
	  
	 <div class="layui-form-item">
	    <label class="layui-form-label">父分类</label>
	    <div class="layui-input-block">
	      <select name="pid" lay-verify="required">
	        <option value="0">--请选择--</option>
	        <?php foreach($info as $v): ?>
	        	<option value="<?php echo $v['cate_id']; ?>">
	        		<?php echo str_repeat('&nbsp;&nbsp;',$v['level']*2); ?>
	        		<?php echo $v['cate_name']; ?>
	        	</option>
	        <?php endforeach; ?>
	      </select>
	    </div>
  	</div>
	  <div class="layui-form-item">
	    <div class="layui-input-block">
	      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
	      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
	    </div>
	  </div>
	</form>
	 
	<script>
	//Demo
	layui.use(['form','layer'], function(){
		var form = layui.form;
		var layer = layui.layer;
	  
	  	//验证 唯一性
	  	form.verify({
	  		checkName:function(value,item){
	  			var font;
	  			$.ajax({
					url:"<?php echo url('Category/checkName'); ?>",
					method:'post',
					data:{cate_name:value},
					async:false,
					success:function(msg){
						if(msg=='no'){
							font = '该名称已存在';
						}
					}
				});
	  			return font;
	  		}
	  	})
	  	
		//监听提交
		form.on('submit(formDemo)', function(data){
			$.post(
				"<?php echo url('Category/cateAdd'); ?>",
				data.field,
				function(msg){
					layer.msg(msg.font,{icon:msg.code})
					if(msg.code==1){
						layer.open({
							type:0,
							content:'添加成功!',
							btn:['继续添加','展示'],
							yes:function(index,layero){
								location.href="<?php echo url('category/cateAdd'); ?>";
								return false;
							},
							btn2:function(index,layero){
								location.href="<?php echo url('category/cateList'); ?>";
								return true;
							}
						})
			  		}
				},'json'
			);
			return false;
		});
	});
	</script>
    </div>
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