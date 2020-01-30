<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:82:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\goods\goodslist.html";i:1542868373;s:73:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\layout.html";i:1541750001;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\head.html";i:1542158279;s:78:"D:\phpStudy\WWW\month11\shop\public/../application/admin\view\public\left.html";i:1544429736;}*/ ?>
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
    <div style="padding: 15px;">
    <h2 align="center">商品列表展示</h2>
    <input type="text" placeholder="请输入商品名称" id="goods_name">
    商品分类：
    <select id="cate_name">
        <option value="">--请选择--</option>
        <?php foreach($cate as $k=>$v): ?>
        <option value="<?php echo $v['cate_name']; ?>">
            <?php echo str_repeat('&nbsp;&nbsp;',$v['level']*2); ?>
            <?php echo $v['cate_name']; ?>
        </option>
        <?php endforeach; ?>
    </select>
    商品品牌：
    <select id="brand_name">
        <option value="">--请选择--</option>
        <?php foreach($brand as $k=>$v): ?>
        <option value="<?php echo $v['brand_name']; ?>"><?php echo $v['brand_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="button" value="搜索" id="btn">

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

              //第一个实例
            table.render({
                elem: '#demo'
                ,url: "<?php echo url('Goods/getInfo'); ?>" //数据接口
                ,page: true //开启分页
                ,limit: 3   //限制条数
                ,cols: [[ //表头
                    {field: 'goods_name', title: '商品名称',edit: 'text', width:90, sort: true, fixed: 'left'}
                    ,{field: 'goods_selfprice', title: '本店售价',edit: 'text', width:80}
                    ,{field: 'goods_allprice', title: '市场售价', width:80, sort: true}
                    ,{field: 'goods_up', title: '是否上架', width:70} 
                    ,{field: 'goods_new', title: '新品', width:70} 
                    ,{field: 'goods_best', title: '精品', width:70} 
                    ,{field: 'goods_hot', title: '热卖', width:70} 
                    ,{field: 'goods_num', title: '库存',edit: 'text', width:80} 
                    ,{field: 'goods_fen', title: '赠送积分',edit: 'text', width:80} 
                    ,{field: 'create_time', title: '添加时间', width:120} 
                    ,{field: 'cate_name', title: '商品分类', width:100} 
                    ,{field: 'brand_name', title: '商品品牌', width:80}
                    ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:120}
                ]]
            });
            //监听单元格编辑   即点即改
            table.on('edit(table_edit)', function(obj){ //注：edit是固定事件名，table_edit是table原始容器的属性 lay-filter="对应的值"
                var value = obj.value,//得到修改后的值
                    data = obj.data,//得到所在行的数据
                    field = obj.field;//得到编辑的字段名
                $.post(
                    "<?php echo url('Goods/goodsUpd'); ?>",
                    {value:value,field:field,goods_id:data.goods_id},
                    function(msg){
                        // console.log(msg);
                        layer.msg(msg.font,{icon:msg.code});
                    }
                    ,'json'
                )
            });
            //搜索
            $('#btn').click(function(){
                var goods_name = $('#goods_name').val();
                var cate_name = $('#cate_name').val();
                var brand_name = $('#brand_name').val();
                table.reload('demo',{
                    where:{goods_name:goods_name,cate_name:cate_name,brand_name:brand_name}
                });
            })
            //监听行工具事件
            table.on('tool(table_edit)', function(obj){
                var data = obj.data;
                //console.log(obj)
                if(obj.event === 'del'){
                    layer.confirm('您是否确认删除？',{icon:3},function(index){
                        $.post(
                            "<?php echo url('Goods/goodsDel'); ?>",
                            {goods_id:data.goods_id},
                            function(msg){
                                layer.msg(msg.font,{icon:msg.code});
                                if(msg.code==1){
                                    table.reload('demo');
                                }
                            },'json'
                        );
                    })
                }else if(obj.event === 'edit'){
                    location.href="<?php echo url('Goods/goodsUpdate'); ?>?goods_id="+data.goods_id;
                }
            });

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