<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\goods\goodsList.html";i:1542779435;s:73:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\layout.html";i:1541750001;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\head.html";i:1542158279;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\left.html";i:1542685539;}*/ ?>
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
    <div style="padding: 15px; cursor: pointer;">

    <h2 align="center">商品列表展示</h2>
	<table class="layui-table" id="demo">
    	<thead>
    		<tr>
    			<th>商品名称</th>
    			<th>本店售价</th>
    			<th>市场售价</th>
    			<th>是否上架</th>
                <th>新品</th>
                <th>精品</th>
    			<th>热卖</th>
    			<th>库存</th>
    			<th>赠送积分</th>
    			<th>商品图片</th>
    			<!-- <th>轮播图</th> -->
    			<th>添加时间</th>
    			<th>商品分类</th>
    			<th>商品品牌</th>
    			<th>操作</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php foreach($data as $v): ?>
    		<tr goods_id=<?php echo $v['goods_id']; ?>>
                <th>
                    <div id="div_test">
                        <span class="clk"><?php echo $v['goods_name']; ?></span>
                        <input type="text" class="imp" field="goods_name" value="<?php echo $v['goods_name']; ?>" style="display: none; width: 110px">
                    </div>
                </th>
                <th>
                    <div>
                        <span class="clk"><?php echo $v['goods_selfprice']; ?></span>
                        <input type="text" class="imp" field="goods_selfprice" value="<?php echo $v['goods_selfprice']; ?>" style="display: none; width: 110px">
                    </div>
                </th>
                <th>
                    <div>
                        <span class="clk"><?php echo $v['goods_allprice']; ?></span>
                        <input type="text" class="imp" field="goods_allprice" value="<?php echo $v['goods_allprice']; ?>" style="display: none; width: 110px">
                    </div>
                </th>
                <th class="show" static=<?php echo $v['goods_up']; ?> field='goods_up'>
                    <?php if($v['goods_up'] == 1): ?>
                    √
                    <?php else: ?>
                    ×
                    <?php endif; ?>
                </th>
                <th class="show" static=<?php echo $v['goods_new']; ?> field='goods_new'>
                    <?php if($v['goods_new'] == 1): ?>
                    √
                    <?php else: ?>
                    ×
                    <?php endif; ?>
                </th>
                <th class="show" static=<?php echo $v['goods_best']; ?> field='goods_best'>
                    <?php if($v['goods_best'] == 1): ?>
                    √
                    <?php else: ?>
                    ×
                    <?php endif; ?>
                </th>
                <th class="show" static=<?php echo $v['goods_hot']; ?> field='goods_hot'>
                    <?php if($v['goods_hot'] == 1): ?>
                    √
                    <?php else: ?>
                    ×
                    <?php endif; ?>
                </th>
                <th><?php echo $v['goods_num']; ?></th>
                <th><?php echo $v['goods_fen']; ?></th>
                <th>
                    <img src="__PUBLIC__<?php echo $v['goods_img']; ?>" width="50px">
                </th>
                <!-- <th>
                    <?php echo $v['goods_imgs']; ?>
                </th> -->
                <th><?php echo $v['create_time']; ?></th>
                <th><?php echo $v['cate_name']; ?></th>
                <th><?php echo $v['brand_name']; ?></th>
                <th>
                    <a href="javascript:;" class="del" goods_id=<?php echo $v['goods_id']; ?>>删除</a>/<a href="<?php echo url('Goods/goodsUpdate'); ?>?goods_id=<?php echo $v['goods_id']; ?>">编辑</a>
                </th>      
            </tr>
    		<?php endforeach; ?>
    	</tbody>
    </table>
</div>
<script>
    $(function(){
        layui.use(['layer','table'],function(){
            var table = layui.table;
            var layer = layui.layer;
           
            //删除
            $('.del').click(function(){
                var _this = $(this);//del
                //console.log(_this);
                var goods_id = _this.attr('goods_id');//获取对应的id值
                // console.log(goods_id);
               layer.confirm('是否确认删除？',{icon:3},function(index){
                    $.post(
                        "<?php echo url('Goods/goodsDel'); ?>",
                        {goods_id:goods_id},
                        function(msg){
                            //console.log(msg);
                            layer.msg(msg.font,{icon:msg.code});
                            if(msg.code==1){
                                _this.parents('tr').remove();
                            }
                        }
                        ,'json'
                    );
                });
            })

            //即点即改
            $('.clk').click(function(){
                var _this = $(this);//span
                //span隐藏 input 展示
                _this.hide();
                _this.next('input').show();
            })
            $('.imp').blur(function(){
                //新值 id 字段
                var _this = $(this);//input
                var value = _this.val();
                var goods_id = _this.parents('tr').attr('goods_id');
                var field = _this.attr('field');
                $.post(
                    "<?php echo url('Goods/goodsUpdateField'); ?>",
                    {value:value,goods_id:goods_id,field:field},
                    function(msg){
                        layer.msg(msg.font,{icon:msg.code});
                        if(msg.code==1){
                            //span展示 input 隐藏
                            _this.hide();
                            _this.prev('span').html(value).show();
                        }
                    },'json'
                );
            })
            $('.show').click(function(){
                var _this = $(this);//th
                var field = _this.attr('field');//字段名
                var static = _this.attr('static');//当前状态
                var goods_id = _this.parents('tr').attr('goods_id');//id
                //处理状态
                if(static==1){
                    static=2;
                }else{
                    static=1;
                }
                $.post(
                    "<?php echo url('Goods/goodsUpdateField'); ?>",
                    {field:field,value:static,goods_id:goods_id},
                    function(msg){
                        // console.log(msg);
                        layer.msg(msg.font,{icon:msg.code});
                        if(msg.code==1){
                            if(static==1){
                                _this.text('√');
                                _this.attr('static',1)
                            }else{
                                _this.text('×');
                                _this.attr('static',2);
                            }
                        }
                    },'json'
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