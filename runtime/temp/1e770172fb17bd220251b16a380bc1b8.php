<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:84:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\goods\goodsupdate.html";i:1542797791;s:73:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\layout.html";i:1541750001;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\head.html";i:1542158279;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\left.html";i:1542849080;}*/ ?>
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
       <!-- 内容主体区域 -->
    <div style="padding: 15px; width: 600px;">
    	<h2 align="center">商品修改</h2>
<form class="layui-form" action="">
	<input type="hidden" name="goods_id" value="<?php echo $data['goods_id']; ?>">
	<div class="layui-form-item">
		<label class="layui-form-label">商品名称</label>
		<div class="layui-input-block"><!-- "  -->
			<input type="hidden" id="old_name" value="<?php echo $data['goods_name']; ?>">
			<input type="text" name="goods_name" required lay-verify="required|checkName" autocomplete="off" class="layui-input" value="<?php echo $data['goods_name']; ?>">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">本店售价</label>
		<div class="layui-input-block">
			<input type="text" name="goods_selfprice" required lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo $data['goods_selfprice']; ?>">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">市场售价</label>
		<div class="layui-input-block"><!-- lay-verify="required|checkPwd" -->
			<input type="text" name="goods_allprice" required lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo $data['goods_allprice']; ?>">
		</div>
	</div>
		<div class="layui-form-item">
		<label class="layui-form-label">是否上架</label>
		<div class="layui-input-block">
			<?php if($data['goods_up'] == 1): ?>
				<input type="radio" name="goods_up" value="1" title="是" checked>
				<input type="radio" name="goods_up" value="2" title="否">
			<?php else: ?>
				<input type="radio" name="goods_up" value="1" title="是">
				<input type="radio" name="goods_up" value="2" title="否" checked>
			<?php endif; ?>
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">复选框</label>
		<div class="layui-input-block">
			<input type="checkbox" name="goods_new" title="新品" value="1">
			<input type="checkbox" name="goods_best" title="精品" value="1">
			<input type="checkbox" name="goods_hot" title="热卖" value="1">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">库存</label>
		<div class="layui-input-block">
			<input type="text" name="goods_num" required lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo $data['goods_num']; ?>">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">赠送积分</label>
		<div class="layui-input-block">
			<input type="text" name="goods_fen" required lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo $data['goods_fen']; ?>">
		</div>
	</div>
	<!-- <div class="layui-form-item">
	    	<label class="layui-form-label">商品图片</label>
	    	<input type="hidden" name="goods_img" id="goods_img">
		<button type="button" class="layui-btn" id="img">
			<i class="layui-icon">&#xe67c;</i>上传图片
		</button>
		<img src="__PUBLIC__<?php echo $data['goods_img']; ?>" width="50px">
	</div> -->
	<div class="layui-form-item">
		<label class="layui-form-label">商品分类</label>
		<div class="layui-input-block">
			<select name="cate_id">
				<option value="0">--请选择--</option>
				<?php foreach($cateInfo as $k=>$v): if($v['cate_id'] == $data['cate_id']): ?>
						<option value="<?php echo $v['cate_id']; ?>" selected>
							<?php echo str_repeat('&nbsp;&nbsp;',$v['level']*2); ?>
							<?php echo $v['cate_name']; ?>
						</option>
					<?php else: ?>
						<option value="<?php echo $v['cate_id']; ?>">
							<?php echo str_repeat('&nbsp;&nbsp;',$v['level']*2); ?>
							<?php echo $v['cate_name']; ?>
						</option>
					<?php endif; endforeach; ?>
			</select>
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">商品品牌</label>
		<div class="layui-input-block">
			<select name="brand_id">
				<option value="0">--请选择--</option>
				<?php foreach($brandInfo as $k=>$v): if($v['brand_id'] == $data['brand_id']): ?>
						<option value="<?php echo $v['brand_id']; ?>" selected>
							<?php echo $v['brand_name']; ?>
						</option>
					<?php else: ?>
						<option value="<?php echo $v['brand_id']; ?>">
							<?php echo $v['brand_name']; ?>
						</option>
					<?php endif; endforeach; ?>
			</select>
		</div>
	</div>
	<div class="layui-form-item">
		<div class="layui-input-block">
			<button class="layui-btn" lay-submit lay-filter="*">立即修改</button>
			<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		</div>
	</div>
</form>	 
<script>
	$(function(){
		layui.use(['form','upload','layer'],function(){
			var form = layui.form;
			var upload = layui.upload;
			var layer = layui.layer;

			 //执行实例  上传单张图片
		/*	var uploadInst = upload.render({
				elem: '#img' //绑定元素
				,url: "<?php echo url('Goods/goodsUpload'); ?>?type=1" //上传接口
				,done: function(res){
					layer.msg(res.font,{icon:res.code});
					if(res.code==1){
						$('#goods_img').val(res.src);
					}
				}
			});
			//轮播图
			var uploadInst = upload.render({
				elem: '#imgs' //绑定元素
				,url: "<?php echo url('Goods/goodsUpload'); ?>?type=2" //上传接口
				,multiple:true
				,number:3
				,done: function(res){
					// console.log(res);
					layer.msg(res.font,{icon:res.code});
					if(res.code==1){
						var _src = $('#goods_imgs').val();
						_src = _src+res.src+"|";
						$('#goods_imgs').val(_src);	
					}
				}
			});
		*/
			//唯一性验证
			form.verify({
				checkName: function(value, item){
					var font;
					var old_name = $('#old_name').val();
		  			$.ajax({
						url:"<?php echo url('Goods/checkName'); ?>",
						method:'post',
						data:{goods_name:value,old_name:old_name,type:2},
						async:false,
						success:function(msg){
							if(msg=='no'){
								font = '该名称已存在';
							}
						}
					});
		  			return font;
				}
			});
			//复选框
			/*form.on('checkbox(filter)', function(data){
				console.log(data.elem); //得到checkbox原始DOM对象
				console.log(data.elem.checked); //是否被选中，true或者false
				console.log(data.value); //复选框value值，也可以通过data.elem.value得到
				console.log(data.othis); //得到美化后的DOM对象
			});   */
			//提交
			form.on('submit(*)',function(data){
				$.post(
					"<?php echo url('Goods/goodsUpdate'); ?>",
					data.field,
					function(msg){
						layer.msg(msg.font,{icon:msg.code});
						if(msg.code==1){
							location.href="<?php echo url('Goods/goodsList'); ?>";
						}
					},'json'
				);
				return false;
			})  
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