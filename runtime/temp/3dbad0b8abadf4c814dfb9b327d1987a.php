<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"/data/wwwroot/default/shop/public/../application/admin/view/admin/giverole.html";i:1545461850;s:71:"/data/wwwroot/default/shop/public/../application/admin/view/layout.html";i:1541750001;s:76:"/data/wwwroot/default/shop/public/../application/admin/view/public/head.html";i:1542158279;s:76:"/data/wwwroot/default/shop/public/../application/admin/view/public/left.html";i:1545302390;}*/ ?>
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
            <dd><a href="<?php echo url('role/roleadd'); ?>">角色添加</a></dd>
            <dd><a href="<?php echo url('role/rolelist'); ?>">角色展示</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">节点管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('Node/nodeAdd'); ?>">节点添加</a></dd>
            <dd><a href="<?php echo url('node/nodelist'); ?>">节点展示</a></dd>
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
    <div style="padding: 15px; width:600px;">
    	<h2 align="center"></h2>
<form class="layui-form" action="">
	<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">

	<div class="layui-form-item">
		<label class="layui-form-label">可选角色</label>
		<fieldset class="layui-elem-field">
			<legend>角色分类</legend>
			<div class="layui-field-box">
				<?php if(is_array($roleInfo) || $roleInfo instanceof \think\Collection || $roleInfo instanceof \think\Paginator): $i = 0; $__LIST__ = $roleInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if(in_array(($v['role_id']), is_array($adminInfo)?$adminInfo:explode(',',$adminInfo))): ?>
						<input type="checkbox" lay-skin="primary" checked name="role_id[]" value="<?php echo $v['role_id']; ?>" title="<?php echo $v['role_name']; ?>">
					<?php else: ?>
						<input type="checkbox" lay-skin="primary" name="role_id[]" value="<?php echo $v['role_id']; ?>" title="<?php echo $v['role_name']; ?>">
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</fieldset>
	</div>
	<div class="layui-form-item">
		<div class="layui-input-block">
			<button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
			<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		</div>
	</div>
	</form>
	 
<script>
	$(function(){
		layui.use(['form','layer'],function(){
			var form = layui.form;
			var layer = layui.layer;

			//提交数据
			form.on('submit(*)', function(data){
			   $.post(
			  		"<?php echo url('Admin/giveRole'); ?>",
			  		data.field,
			  		function(result){
						layer.msg(result.font,{icon:result.code,time:2000},function(){
							if(result.code==1){
								location.href="<?php echo url('admin/adminList'); ?>";
							}
						});
			  		}
			  		,'json'
			  	);
			  return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
			});
		});
	})
		
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