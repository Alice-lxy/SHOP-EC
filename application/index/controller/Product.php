<?php
namespace app\index\controller;
use page\AjaxPage;

class Product extends Common
{
	/**详情页*/
    public function product()
    {
        //获取左侧分类信息
        $this->getIndexCateInfo();
        $goods_id = input('get.id',0,'intval');
        if(empty($goods_id)){
            $this->error('请选择商品...');
        }
        //查新商品信息
        $where = [
            'goods_id' => $goods_id,
        ];
        $goods = model('Goods');
        $goodsInfo = $goods->where($where)->find();
        if(empty($goodsInfo)){
            $this->error('无此商品,请重新选择');
        }
        if($goodsInfo['goods_up']==2){
            $this->error('此商品已下架,请重新选择');
        }
        $goodsInfo['goods_imgs'] = explode('|',$goodsInfo['goods_imgs']);
        //dump($goodsInfo['goods_imgs']);die;

        //记录浏览记录
        if($this->checkUserLogin()){
            //存数据库
            $this->saveHistoryDb($goods_id);
        }else{
            //存cookie
            $this->saveHistoryCookie($goods_id);
        }
        //获取面包屑导航
        $cate_str = $this->getCrumbs($goodsInfo['cate_id']);

        $this->assign('goodsInfo',$goodsInfo);
        $this->assign('cate_str',$cate_str);
        return view();
    }
    /** 存浏览记录到cookie中*/
    public function saveHistoryCookie($goods_id){
        $now = time();
        $prevHistory = cookie('history');
        if(!empty($prevHistory)){
            //解开为数据
            $history = unserialize(base64_decode($prevHistory));
            //加入这一次的浏览记录
            $history[]=['goods_id' => $goods_id,'ctime'=>$now];
            //再次存入cookie中
            $str = base64_encode(serialize($history));
            cookie("history",$str);
            // $history = unserialize(base64_decode(cookie("history")));
        }else{
            $arr[] = ['goods_id' => $goods_id,'ctime'=>$now];
            $str = base64_encode(serialize($arr));
            cookie("history",$str);
        }
    }
    /** 存浏览记录到数据库中*/
    public function saveHistoryDb($goods_id){
        $history = [
            'user_id' => $this->getUserId(),
            'goods_id' => $goods_id,
        ];
        $model = model('History');
        $model->save($history);

    }
    /** 商品列表*/
    public function productList(){
        //查询首页左侧分类数据
        $this->getIndexCateInfo();
        //查询所有品牌
        $cate_id = input('param.cate_id',0);
        if(empty($cate_id)){
            $where = [];
            cookie('cate_id',null);
        }else{
            $cateInfo = model('Category')->field('cate_id,cate_name,pid')->select();
//            echo model('Category')->getLastSql();die;
            $cate_id = getCateId($cateInfo,$cate_id);
            $cate_id = implode(',',$cate_id);
            cookie('cate_id',$cate_id);
            $where = ['cate_id' => ['in',$cate_id]];
        }
        /*$goods = model('Goods');
        $goods->field('distinct(brand_id)')->where($where)->select();
        //$goods->where($where)->select();
         echo $goods->getLastSql();die;*/

        //查询品牌数据
        $brand = model('Brand');
        $brandInfo = $brand
                ->field('distinct(g.brand_id),brand_name')
                ->alias('b')
                ->join("shop_goods g",'b.brand_id = g.brand_id')
                ->where($where)
                ->select();

        //查询价格区间
        $goods = model('Goods');
        $maxprice = $goods->where($where)->value('max(goods_selfprice)');
        $priceInfo = $this->getPriceSection($maxprice);
        //dump($priceInfo);die;

        //获取默认商品数据
        $goodsWhere = [
            'goods_up' => 1
        ];
        $p=1;
        $page_num = 8;
        $goodsInfo = $goods
                ->where($where)
                ->where($goodsWhere)
                ->order('goods_score desc')
                ->page($p,$page_num)->select();
        //调用分类  获取页码
        $count = $goods->where($where)->count();
        $page_str = AjaxPage::ajaxpager($p,$count,$page_num,url('Product/productsearch'),'show');
        /*//获取面包屑导航
        $cate_str = $this->getCrumbs($goodsInfo['cate_id']);
        $this->assign('cate_str',$cate_str);*/
        //获取浏览记录
        if($this->checkUserLogin()){
            //数据库
            $historyInfo = $this->getHistoryDb();
        }else{
            $historyInfo = $this->getHistoryCookie();
        }
        $this->assign('historyInfo',$historyInfo);
        $this->assign('price',$priceInfo);
        $this->assign('goods',$goodsInfo);
        $this->assign('page_str',$page_str);
        $this->assign('count',$count);
        $this->assign('brand',$brandInfo);
        return view();
    }
    /** 获取价格区间*/
    public function getPriceSection($maxprice){
        for($i=0;$i<6;$i++){
            $start = ($maxprice/7)*$i;
            $end = ($maxprice/7)*($i+1)-0.01;
            $price[]=number_format($start,2,'.',',').'-'.number_format($end,2,'.',',');
        }
        $price[]=number_format($end+0.01,2,'.',',').'以上';
        return $price;
    }
    /** 获取价格*/
    public function getPrice(){
        //品牌id
        $brand_id = input('param.brand_id',0,'intval');
        $goods = model('Goods');
        $where = [
            'goods_up' => 1,
            'brand_id' => $brand_id,
        ];
        $max_price = $goods->where($where)->order('goods_selfprice','desc')->value('goods_selfprice');
        if(!empty($max_price)){
            $price = $this->getPriceSection($max_price);
            echo json_encode($price);
        }else{
            $this->error('此品牌下无商品展示');
        }
    }
    /** 搜索*/
    public function productSearch(){
        $p = input('post.p',1,'intval');
        $brand_id = input('post.brand_id','');
        //$price = input('param.price');
        $price = str_replace(',','',input('post.price'));
        //echo $price;die;
        $flag = input('post.flag',1,'intval');
        $order = input('post.order','desc');
        $cate_id = cookie('cate_id');
        //删选条件
        $where = [];
        if(!empty($cate_id)){
            $where['cate_id'] = ['in',$cate_id];
        }
        if(!empty($brand_id)){
            $where['brand_id'] = $brand_id;
        }
        if(!empty($price)){
            if(substr_count($price,'-')>0){
                $arr = explode('-',$price);
                $where['goods_selfprice'] = ['between',$arr];
            }else{
                $arr1 = substr($price,0,strpos($price,'以'));
                $where['goods_selfprice'] = ['>=',$arr1];
                // dump($where);die;
            }
        }
        //处理排序条件
        $field = "goods_score";

        if($flag==2){
            $field="goods_score";
        }else if($flag==3){
            $field="goods_selfprice";
        }else if($flag==4){
            $where['goods_new']=1;
        }
        //查询商品
        $goods = model('Goods');
        $page_num = 8;
        //查询分页数据
        $goodsInfo = $goods
            ->where($where)
            ->order($field,$order)
            ->page($p,$page_num)->select();
        //调用分类  获取页码
        $count = $goods->where($where)->count();
        $page_str = AjaxPage::ajaxpager($p,$count,$page_num,url('Product/productsearch'),'show');

        $this->assign('goods',$goodsInfo);
        $this->assign('page_str',$page_str);
        $this->view->engine->layout(false);

        $detail = $this->fetch('detail');
        $info = ['detail'=>$detail,'count'=>$count];
        echo json_encode($info);

    }
    /** 获取浏览记录 --数据库--*/
    public function getHistoryDb(){
        $where = ['user_id' => $this->getUserId()];
        $history = model('History');
        $goods_id = $history->where($where)->order('ctime','desc')->column('goods_id');
        if(!empty($goods_id)){
            $goods_id = array_slice(array_unique($goods_id),0,5);
            //根据去除后的商品id 查询相对应的商品数据
            $goodsInfo = $this->getHistory($goods_id);
            return $goodsInfo;
        }else{
            return [];
        }
    }
     /** 获取浏览记录 --COOKIE--*/
    public function getHistoryCookie(){
        $history_str = cookie('history');
        $historyInfo = unserialize(base64_decode($history_str));
        if(!empty($historyInfo)){
            $historyInfo = array_reverse($historyInfo);
            foreach($historyInfo as $k=>$v){
                $goods_id[] = $v['goods_id'];
            }
            $goods_id = array_slice(array_unique($goods_id),0,5);
            //根据去除后的商品id 查询相对应的商品数据
            $goodsInfo = $this->getHistory($goods_id);
            return $goodsInfo;
        }else{
            return [];
        }
    }
}
