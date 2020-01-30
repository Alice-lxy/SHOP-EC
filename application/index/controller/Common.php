<?php
	namespace app\index\controller;
	use think\Controller;

	class Common extends Controller{
		public function __construct(){
			parent::__construct();
			//获取网站配置信息
			$this->getWebConfig();
			//获取购物车信息
			$this->getTopCartInfo();
		}
		/**检测非法登录*/
		public function checkUserLogin(){
			if(session('?userInfo')){
				$userInfo = session('userInfo');
				return $userInfo;
			}else{
				return false;
			}
		}
		/** 网址*/
		public function getWebConfig(){
			if(session('?configInfo')){
				$configInfo = session('configInfo');
				//dump($configInfo);die;
				$this->assign('config',$configInfo);
			}else{
				$config = model('Config');
				$data = $config->select();
				foreach($data as $k=>$v){
					$configInfo[$v['name']] = $v['value'];
				}
				session('configInfo',$configInfo);
				$this->assign('config',$configInfo);
			}
		}
		/** 左侧分类数据*/
		public function getIndexCateInfo(){
			//查询分类数据  即左侧分类
	    	$model = model('Category');
	    	$where = [
	    		'cate_show' => 1,
	    	];
	    	$where1 = [
	    		'cate_navshow' => 1,
	    	];
	    	// $data = collection($model->where($where)->select())->toArray();
	    	$data = $model->where($where)->select();
	    	$cateInfo = getIndexCateInfo($data);

	    	//导航分类
	    	$data1 = $model->where($where1)->select();
	    	$this->assign('data1',$data1);
	    	$this->assign('cateInfo',$cateInfo);
		}
		/**获取用户id*/
		public function getUserId(){
			return session('userInfo.user_id');
		}
		/** 检测同步将浏览记录到数据库中*/
		public function asyncHistory(){
			$history = cookie('history');
			//解开cookie
			if(!empty($history)){
				$arr = unserialize(base64_decode($history));
				$user_id = $this->getUserId();
				$model = model('History');
				foreach($arr as $k=>$v){
					$v['user_id'] = $user_id;
					$model->insert($v);
				}
				cookie('history',null);
			}
		}
		/** 检测商品的库存*/
		public function checkNumber($goodsInfo,$buy_number){
			$goods_num = $goodsInfo['goods_num'];
			if($buy_number>$goods_num){
				$this->error('此商品库存余'.$goods_num.'件,您的选择已超过库存。最多只可买'.$goods_num.'件，请酌情考虑');
			}
		}
		/** 同步数据库*/
		public function asyncCart(){
			$cart = cookie('cart');
			$cartInfo = unserialize(base64_decode($cart));
			//print_r($cartInfo);die;
			if(!empty($cartInfo)){
				//同步 循环的商品是否在购物车内
				$user_id = $this->getUserId();
				$model = model('Cart');
				$goods = model('Goods');
				foreach($cartInfo as $k=>$v){
					$goodsInfo = $goods->where(['goods_id'=>$v['goods_id']])->find();
					if(empty($goodsInfo)){
						$this->error('请重新选择心仪的商品');
					}
					if($goodsInfo['goods_up']==2){
						$this->error('此商品已下架...');
					}

					$cartWhere = [
						'goods_id' => $v['goods_id'],
						'user_id' => $user_id,
					];
					$cartData = $model->where($cartWhere)->find();
					if(!empty($cartData)){
						//改
						$update = [
							'buy_number' => $cartData['buy_number']+$v['buy_number'],
							'utime' => time()
						];
						//print_r($update);die;
						//库存
						$this->checkNumber($goodsInfo,$update['buy_number']);
						$res = $model->where($cartWhere)->update($update);
						if($res){
							cookie('cart',null);
						}
					}else{
						//增
						$v['goods_selfprice'] = $goodsInfo['goods_selfprice'];
						$v['user_id'] = $user_id;
						$this->checkNumber($goodsInfo,$v['buy_number']);
						$res = $model->insert($v);
						if($res){
							cookie('cart',null);
						}
					}
				}
			}
		}
		/** 获取面包屑的数据*/
		public function getCrumbs($cate_id){
			$category = model('Category');
			$where = [
				'cate_show' =>1,
			];
			$arr = $category->where($where)->select();
			$name = getCateName($arr,$cate_id);
//			print_r($name);die;
			$new_name = array_reverse($name);
			$str = "";
			foreach($new_name as $k=>$v){
				$str.="<a href='".url('product/productlist',['cate_id'=>$v['cate_id']])."'>".$v['cate_name']."</a>".'>';
			}
//			echo $str;die;
			$cate_str = rtrim($str,'>');
			return $cate_str;
		}
		/** 浏览记录 公共*/
		public function getHistory($goods_id){
			if(empty($goods_id)){
				return null;
			}else{
				$goods = model('Goods');
				foreach($goods_id as $k=>$v){
					$where = [
							'goods_id' => $v,
							'goods_up' =>1,
					];/**/
					$goodsInfo[] = $goods->field('goods_img,goods_name,goods_selfprice,goods_fen,goods_score')->where($where)->find();
				}
				return $goodsInfo;
			}
		}

		/** 登陆后的购物车*/
		protected function getCartInfoDb(){
			//商品id 名称 价格 购买数量 购物车表 商品表
			$where = ['user_id' => $this->getUserId(),'goods_up'=>1,'static' =>1];
			$cart = model('Cart');
			$cartInfo = $cart
					->field('id,g.goods_id,goods_name,g.goods_selfprice,goods_allprice,buy_number,goods_img,goods_fen,goods_num')
					->alias('c')
					->join('shop_goods g',"c.goods_id = g.goods_id")
					->where($where)
					->select();
			return $cartInfo;
		}
		/** 未登录的购物车*/
		protected function getCartInfoCookie(){
			$cart_str = cookie('cart');

			$cartInfo = unserialize(base64_decode($cart_str));
			if($cartInfo){

			}else{
				return $cartInfo=null;
			}
			$goods = model('Goods');
			foreach($cartInfo as $k=>$v){
				$where = [
						'goods_id' => $v['goods_id'],
						'goods_up' => 1,
				];/**/
				$goodsInfo = $goods->field('goods_id,goods_name,goods_selfprice,goods_allprice,goods_num,goods_img,goods_fen')->where($where)->find()->toArray();
				$cartData[] = array_merge($v,$goodsInfo);
			}
			return $cartData;
		}

		/** 获取头部购物车信息*/
		public function getTopCartInfo(){
			if($this->checkUserLogin()){
				$cartInfo = $this->getCartInfoDb();
			}else{
				$cartInfo = $this->getCartInfoCookie();
			}
			if(!empty($cartInfo)){
				$this->assign('cartInfo',$cartInfo);
			}else{
				$this->assign('cartInfo',null);
			}
		}

		/** 获取用户地址信息*/
		public function getAddressInfo($where,$add_id=''){
			$address = model('Address');
			$area = model('Area');
			if(empty($add_id)){
				$addressInfo = $address->where($where)->select();
				if(!empty($addressInfo)){
					$id = [];
					foreach($addressInfo as $k=>$v){
						$id[] = $v['province'];
						$id[] = $v['city'];
						$id[] = $v['area'];
					}
					$id =array_unique($id);
					$areaWhere = [
							'id' => ['in',$id],
					];
					//$area = model('Area');
					$areaInfo = collection($area->where($areaWhere)->select())->toArray();
					//print_r($areaInfo);
					$area_name = [];
					foreach($areaInfo as $k=>$v){
						$area_name[$v['id']] = $v['name'];
					}
					foreach($addressInfo as $k=>$v){
						$addressInfo[$k]['province_name'] = $area_name[$v['province']];
						$addressInfo[$k]['city_name'] = $area_name[$v['city']];
						$addressInfo[$k]['area_name'] = $area_name[$v['area']];
					}
					return $addressInfo;
				}else{
					return [];
				}

				//print_r($addressInfo);
			}else{
				$where['add_id'] = $add_id;
				$addressInfo = $address->where($where)->find()->toArray();
				if(!empty($addressInfo)){
					$id[] = $addressInfo['province'];
					$id[] = $addressInfo['city'];
					$id[] = $addressInfo['area'];

					$areaWhere = [
							'id' => ['in',$id],
					];
					$areaInfo = collection($area->where($areaWhere)->select())->toArray();
					$area_name = [];
					foreach($areaInfo as $k=>$v){
						$area_name[$v['id']] = $v['name'];
					}
					$addressInfo['province_name'] = $area_name[$addressInfo['province']];
					$addressInfo['city_name'] = $area_name[$addressInfo['city']];
					$addressInfo['area_name'] = $area_name[$addressInfo['area']];
					return $addressInfo;
				}else{
					return [];
				}
			}
		}

		/** 获取订单信息*/
		public function getOrderInfo($orderWhere){
			$order_model = model('Order');
			$orderInfo = $order_model->where($orderWhere)->find();
//			print_r($orderInfo);die;
			return $orderInfo;
		}
	}
?>