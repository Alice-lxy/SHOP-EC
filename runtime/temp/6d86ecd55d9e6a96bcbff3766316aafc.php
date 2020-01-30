<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/data/wwwroot/default/shop/public/../application/index/view/index/div.html";i:1545035137;}*/ ?>
<div cate_id="<?php echo $info['topData']['cate_id']; ?>" floor_num="<?php echo $floor_num; ?>">
    <div class="i_t mar_10">
        <span class="floor_num"><?php echo $floor_num; ?>F</span>
        <span class="fl"><?php echo $info['topData']['cate_name']; ?></span>                
        <span class="i_mores fr">
            <?php if(is_array($info['cateData']) || $info['cateData'] instanceof \think\Collection || $info['cateData'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['cateData'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <a href="#"><?php echo $v['cate_name']; ?></a>&nbsp; &nbsp; &nbsp; 
            <?php endforeach; endif; else: echo "" ;endif; ?>  
        </span>
    </div>
    <div class="content">
        <div class="fresh_mid">
            <ul>
                <?php if(is_array($info['goodsData']) || $info['goodsData'] instanceof \think\Collection || $info['goodsData'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['goodsData'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li>
                    <div class="name"><a href="#"><?php echo $v['goods_name']; ?></a></div>
                    <div class="price">
                        <font>￥<span><?php echo $v['goods_selfprice']; ?></span></font> &nbsp; <?php echo $v['goods_fen']; ?>R
                    </div>
                    <div class="img"><a href="<?php echo url('product/product'); ?>?id=<?php echo $v['goods_id']; ?>"><img src="/shop/public/goodsimg/<?php echo $v['goods_img']; ?>" width="185" height="155" /></a></div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>                     
            </ul>
        </div>
    </div>   
</div> 