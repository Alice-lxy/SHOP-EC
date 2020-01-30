<?php
	namespace app\index\controller;

	class Cart extends Common{
		/** 加入购物车*/
		public function cartAdd(){
			$goods_id = input('post.goods_id',0,'intval');
			$buy_number = input('post.buy_number',0,'intval');
			if(empty($goods_id)){
				$this->error('请输入商品');
			}
			if(empty($buy_number)){
				$this->error('请输入要购买的数量');
			}
			$goods = model('Goods');
			$where = [
				'goods_id' =>$goods_id,
			];
			$goodsInfo = $goods->where($where)->find();
			if(empty($goodsInfo)){
				$this->error('请选择正确的商品');
			}

			if($this->checkUserLogin()){
				//数据库
				$res = $this->addCartDb($goodsInfo,$buy_number);
			}else{
				//cookie
				$res = $this->addCartCookie($goodsInfo,$buy_number);
			}
			if($res){
				successfly('成功加入购物车,进入列表页面');
			}else{
				fail('加入购物车失败');
			}
		}
		/** 将购物品放入cookie中*/
		public function addCartCookie($goodsInfo,$buy_number){
			$goods_id = $goodsInfo['goods_id'];
			$now = time();
			//取出cookie信息
			$cartInfo = $this->getCartCookie();
//			print_r($cartInfo);die;
			if(!empty($cartInfo[$goods_id])){
				//将数据做累加
				$cartInfo[$goods_id]['buy_number'] = $cartInfo[$goods_id]['buy_number']+$buy_number;
				$cartInfo[$goods_id]['utime'] = $now;
				//查库存
				$this->checkNumber($goodsInfo,$cartInfo[$goods_id]['buy_number']);
				$cart = base64_encode(serialize($cartInfo));
				$second = 60*60*24;
				cookie('cart',$cart,$second);
				return true;
			}else{
				//存储cookie信息
				$cartInfo[$goods_id] = [
					'goods_id' => $goods_id,
					'buy_number' => $buy_number,
					'ctime' => $now,
					'utime' => $now,
				];
//				print_r($cartInfo[$goods_id]);exit;
				//检测库存
				$this->checkNumber($goodsInfo,$buy_number);
				$cart = base64_encode(serialize($cartInfo));
				$second = 60*60*24;
				cookie('cart',$cart,$second);
				return true;
			}

		}
		/** 取cookie*/
		public function getCartCookie(){
			$cart = cookie('cart');
			$cateInfo = [];
			if(empty($cart)){
				return $cateInfo;
			}else{
				$cartInfo = unserialize(base64_decode($cart));
				return $cartInfo;
			}
		}
		/** 将购物品放入数据库中*/
		public function addCartDb($goodsInfo,$buy_number){
			$goods_id = $goodsInfo['goods_id'];
			//根据商品id查询购物车列表
			$cart = model('Cart');
			$cartWhere = [
				'goods_id' => $goods_id,
				'user_id' => $this->getUserId()
			];
			$cartInfo = $cart->where($cartWhere)->find();
			if($cartInfo){
				//累加
				$update = [
					'buy_number' => $cartInfo['buy_number']+$buy_number,
					'static' => 1,
					'utime' => time(),
				];
				//检查库存
				$this->checkNumber($goodsInfo,$buy_number);
				$res = $cart->where($cartWhere)->update($update);
				if($res){
					return true;
				}else{
					return false;
				}
			}else{
				//添加
				$insert = [
					'goods_id' => $goods_id,
					'goods_selfprice' =>$goodsInfo['goods_selfprice'],
					'buy_number' => $buy_number,
					'user_id' => $this->getUserId()
				];
				//检查库存
				$this->checkNumber($goodsInfo,$buy_number);
				$res = $cart->save($insert);
				if($res){
					return true;
				}else{
					return false;
				}
			}
		}

		/** 购物车列表展示*/
		public function cartlist()
		{
			//查询首页左侧分类数据
			$this->getIndexCateInfo();
			/*$user_id = $this->getUserId();
			if ($user_id) {
				$goods_id = model('cart')->where(['user_id' => $this->getUserId()])->order('ctime', 'desc')->column('goods_id');
			} else {
				$cart_str = cookie('cart');
				$cartInfo = unserialize(base64_decode($cart_str));
				if (!empty($cartInfo)) {
					$cartInfo = array_reverse($cartInfo);
					foreach ($cartInfo as $k => $v) {
						$goods_id[] = $v['goods_id'];
					}
				}else{
					$goods_id = [];
				}
			}
			$cartInfo = $this->getHistory($goods_id);
			//dump($cartInfo);die;
			$this->assign('cartInfo',$cartInfo);*/
			if($this->checkUserLogin()){
				$cartInfo = $this->getCartInfoDb();
				$login = 1;
			}else{
				$cartInfo = $this->getCartInfoCookie();
				$login = 2;
			}
			if(!empty($cartInfo)){
				$this->assign('cartInfo',$cartInfo);
			}else{
				$this->assign('cartInfo',null);
			}
			$this->assign('login',$login);
			return view();
		}

		/** 改变数据库或cookie的值*/
		public function cartUpd(){
			$buy_number = input('post.buy_number','','intval');
			if(empty($buy_number)){
				$this->error('请输入购买数量');
			}
			if($this->checkUserLogin()){
				$id = input('post.id','','intval');
				if(empty($id)){
					$this->error('请选择要修改的商品');
				}
				$res = $this->updNumDb($id,$buy_number);
			}else{
				$goods_id = input('post.goods_id','','intval');
				if(empty($goods_id)){
					$this->error('请选择要修改的商品');
				}
				//echo 111;die;
				$res = $this->updNumCookie($goods_id,$buy_number);
			}
			if($res){
				successfly('');
			}else{
				fail('修改失败');
			}
		}
		//数据库
		public function updNumDb($id,$buy_number){
			$cart = model('cart');
			$res = $cart->where(['id'=>$id])->update(['buy_number'=>$buy_number]);
			return $res;
		}
		//cookie
		public function updNumCookie($goods_id,$buy_number){
			$cart_str = cookie('cart');
			$cartInfo = unserialize(base64_decode($cart_str));
			$cartInfo[$goods_id]['buy_number'] = $buy_number;

			$cart = base64_encode(serialize($cartInfo));
			/*$qq = unserialize(base64_decode($cart));
			print_r($qq);die*/;
			$second = 60*60*24;
			cookie('cart',$cart,$second);
			return true;
		}

		//删除
		public function cartDel(){
			if($this->checkUserLogin()){
				$id = input('post.id','','intval');
				if(empty($id)){
					$this->error('请正确选择要删除的商品');
				}
				$where = ['id' => $id,];
				$data = ['static' => 2, 'buy_number' => 0];

				$cart = model('Cart');
				$res = $cart->where($where)->update($data);
				if($res){
					successfly('删除成功');
				}else{
					fail('删除失败');
				}
			}else{
				$goods_id = input('post.goods_id','','intval');
				if(empty($goods_id)){
					$this->error('请正确选择要删除的商品');
				}
				$cookie_str = cookie('cart');
				$cartInfo = unserialize(base64_decode($cookie_str));
				unset($cartInfo[$goods_id]);
				$cart = base64_encode(serialize($cartInfo));
				cookie('cart',$cart);
				successfly('删除成功');
			}
		}

		//加入收藏
		public function addCollection(){
			if(!checkRequest()){
				fail('请按正确流程收藏商品');
			}
			if(!$this->checkUserLogin()){
				fail('请先登录');
			}
			$goods_id = input('post.goods_id','');
			if(empty($goods_id)){
				fail('请选择正确的商品');
			}
			$type = input('post.type',0);
			$user_id = $this->getUserId();
			$collection = model('Collection');
			if($type==1){
				$data = [
					'user_id' => $user_id,
					'goods_id' => $goods_id
				];
				$count = $collection->where($data)->count();
				if($count>0){
					fail('此商品已收藏');
				}
				$res = $collection->save($data);
				if($res){
					successfly('收藏成功');
				}else{
					fail('收藏失败');
				}
			}else{
				$goods_id = explode(',',$goods_id);
				$num = 0;
				foreach($goods_id as $k=>$v){
					$data = ['user_id'=>$user_id,'goods_id'=>$v];
					$count = $collection->where($data)->count();
					if($count==0){
						$res = $collection->insert($data);
					}else{
						$num+=1;
					}
				}
				if(!empty($res)){
					if($num>0){
						successfly("您有".$num."件商品已收藏");
					}
					successfly('收藏成功');
				}else{
					fail('所有商品已收藏');
				}

			}
		}

		//清空购物车
		public function clearCart(){
			if($this->checkUserLogin()){
				$user_id = $this->getUserId();
				$cart = model('Cart');
				$res = $cart->where(['user_id'=>$user_id])->update(['static'=>2,'buy_number'=>0]);
				if($res){
					successfly('清空成功');
				}else{
					fail('清空失败');
				}
			}else{
				cookie('cart',null);
				successfly('清空成功');
			}

		}
	}
?>