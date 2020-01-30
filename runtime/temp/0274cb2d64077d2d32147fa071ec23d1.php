<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpStudy\WWW\month11\shop\public/../application/index\view\product\detail.html";i:1544010458;}*/ ?>
<div class="list_c">
    <ul class="cate_list">
        <?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <li>
            <div class="img">
                <a href="<?php echo url('product/product'); ?>?id=<?php echo $v['goods_id']; ?>">
                    <img src="/public/goodsimg/<?php echo $v['goods_img']; ?>" width="210" height="185" />
                </a>
            </div>
            <div class="price">
                <font>￥<span><?php echo $v['goods_selfprice']; ?></span></font> &nbsp; <?php echo $v['goods_fen']; ?>R <b align="right">销量<?php echo $v['goods_score']; ?></b>
            </div>
            <div class="name"><a href="<?php echo url('product/product'); ?>?id=<?php echo $v['goods_id']; ?>"><?php echo $v['goods_name']; ?></a></div>
            <div class="carbg">
                <a href="#" class="ss">收藏</a>
                <a href="#" class="j_car">加入购物车</a>
            </div>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="pages">
        <?php echo $page_str; ?>
        <!--<a href="#" class="p_pre">上一页</a><a href="#" class="cur">1</a><a href="#">2</a><a href="#">3</a>...<a href="#">20</a><a href="#" class="p_pre">下一页</a>-->
    </div>
</div>