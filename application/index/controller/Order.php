<?php
	namespace app\index\controller;

	class Order extends Common{
		/** 确认结算*/
		public function confirmSettlement(){
			//查询左侧分类信息
			$this->getIndexCateInfo();
			//检测是否登录
			if(!$this->checkUserLogin()){
				$this->error('请先登录',url('login/login'));
			}
			//接受购物车id
			$id = input('get.id','');
			if(empty($id)){
				$this->error('请选择购物车数据进行结算',url('cart/cartlist'));
			}
			//根据购物车的id 查询商品信息
			$user_id = $this->getUserId();
			$cartWhere = [
				'user_id'=> $user_id,
				'id' => ['in',$id],
				'static' => 1
			];
			$cart = model('Cart');
			$cartInfo = $cart
					->alias('c')
					->join('shop_goods g','c.goods_id = g.goods_id')
					->where($cartWhere)
					->select();
			//循环检测每个商品的库存
			foreach($cartInfo as $k=>$v){
				if($v['buy_number']>=$v['goods_num']){
					unset($cartInfo[$k]);
				}
			}

			if(empty($cartInfo)){
				$this->error('购物车无数据，无法进行结算',url('index/index'));
			}
			//获取当前用户的收货地址
			$where = [
				'user_id' => $user_id
			];
			$addressInfo = $this->getAddressInfo($where);

			$this->assign('addressInfo',$addressInfo);
			$this->assign('cartInfo',$cartInfo);
			return view();
		}
		/** 确认订单*/
		public function confirmOrder(){
			if(!$this->checkUserLogin()){
				$this->error('请先登录',url('login/login'));
			}
			$id = input('post.id','');
			if(empty($id)){
				$this->error('此购物车无数据',url('cart/cartlist'));
			}
			//根据购物车的id 查询商品信息
			$user_id = $this->getUserId();
			$cartWhere = [
					'user_id'=> $user_id,
					'id' => ['in',$id],
					'static' => 1
			];
			$cart = model('Cart');
			$cartInfo = $cart
					->alias('c')
					->join('shop_goods g','c.goods_id = g.goods_id')
					->where($cartWhere)
					->select();
			if(empty($cartInfo)){
				$this->error('购物车无数据，无法进行结算',url('index/index'));
			}

			$order_model = model('Order');
			$order_model->startTrans();//开启事务
			try{
				$pay_type = input('post.pay_type','');
				$order_message = input('post.order_message','');
				//订单数据写入
				$order = [];
				$order_number = $this->getOrderNumber();
				$order['order_number'] = $order_number;
				$order['user_id'] = $user_id;
				$order_amount=0;
				$order_score=0;
				foreach($cartInfo as $k=>$v){
					$order_amount+=$v['buy_number']*$v['goods_selfprice'];
					$order_score+=$v['buy_number']*$v['goods_fen'];
				}
				$order['order_amount'] = $order_amount;
				$order['order_score'] = $order_score;
				$order['pay_type'] = $pay_type;
				$order['order_message'] = $order_message;
				if($pay_type==2){
					$order['order_status']=4;
				}
				$res1 = $order_model->save($order);
				if(empty($res1)){
					$order_model->rollback();
					throw new \Exception('下单失败');
				}
				$order_id = $order_model->order_id;

				//订单详情表 数据写入
				$order_detail = [];
				foreach($cartInfo as $k=>$v){
					$order_detail[] = [
						'user_id' => $user_id,
						'order_id' => $order_id,
						'goods_id' => $v['goods_id'],
						'goods_name' => $v['goods_name'],
						'goods_selfprice' => $v['goods_selfprice'],
						'goods_img' => $v['goods_img'],
						'buy_number' => $v['buy_number'],
					];
				}
//				print_r($order_detail);
				$orderdetail = model('OrderDetail');
				$res2 = $orderdetail->saveAll($order_detail);
				if(empty($res2)){
					$order_model->rollback();
					throw new \Exception('下单失败');
				}
				//收货地址表 数据写入
				$add_id = input('post.add_id');
				$order_address = [];
				$order_address_where=[
					'user_id' => $user_id,
				];
				$addressInfo = $this->getAddressInfo($order_address_where,$add_id);
				$order_address['user_id'] = $user_id;
				$order_address['order_id'] = $order_id;
				$order_address['province'] = $addressInfo['province_name'];
				$order_address['city'] = $addressInfo['city_name'];
				$order_address['area'] = $addressInfo['area_name'];
				$order_address['add_name'] = $addressInfo['add_name'];
				$order_address['add_tel'] = $addressInfo['add_tel'];
				$order_address['add_ress'] = $addressInfo['add_ress'];
				$order_address_model = model('OrderAddress');
				$res3 = $order_address_model->save($order_address);
				if(empty($res3)){
					$order_model->rollback();
					throw new \Exception('下单失败');
				}

				//购物车表  数据清空
				$id = input('post.id','');
				$cart = model('Cart');
				$cartWhere = [
					'user_id' =>$user_id,
					'id' => ['in',$id],
				];
				$res4 = $cart->where($cartWhere)->update(['static'=>2,'buy_number' => 0]);

				//商品表 修改库存
				$goods = model('Goods');
				foreach($cartInfo as $k=>$v){
					$goodsWhere = [
						'goods_id' => $v['goods_id'],
					];
					$goodsDate = [
						'goods_num' => $v['goods_num']-$v['buy_number'],
					];
					$res4 = $goods->where($goodsWhere)->update($goodsDate);
					if(empty($res4)){
						$order_model->rollback();
						throw new \Exception('下单失败');
					}
				}
				$order_model->commit();
				echo json_encode(['font'=>'下单成功','code'=>1,'order_id'=>$order_id]);
			}catch (\Exception $e){
				fail($e->getMessage());
			}

		}
		/** 获取订单号*/
		public function getOrderNumber(){
			//标志+日期+用户ID+随机4位数字
			$date = date('ymd');
			$user_id = $this->getUserId();
			$user_id = str_repeat(0,4-strlen($user_id)).$user_id;
			$order_number = '6'.$date.$user_id.rand(1000,9999);
			return $order_number;
		}

		/** 下单成功*/
		public function orderSuccess(){
			//查询左侧分类信息
			$this->getIndexCateInfo();
			//获取订单id
			$order_id = input('get.order_id','','intval');
			try{
				if(empty($order_id)){
					new \Exception('无此订单信息');
				}
				$order_model = model('Order');
				$orderWhere = [
					'order_id' => $order_id,
				];
				$orderInfo = $order_model->where($orderWhere)->find();
				if(empty($orderInfo)){
					new \Exception('无此订单信息');
				}
				$this->assign('orderInfo',$orderInfo);
				return view();
			}catch (\Exception $e){
				echo $e->getMessage();
			}
		}

		/** 使用支付宝支付*/
		public function txypay(){
			//获取订单号
			$order_number = input('get.order_number','');
			//echo $order_number;die;
			//查询订单号信息
			$orderWhere = [
					'order_number' => $order_number,
			];
			//dump($order_number);die;
			$orderInfo = $this->getOrderInfo($orderWhere);
			//dump($orderInfo);die;
			if(empty($orderInfo)){
				$this->error('此订单不存在',url('index/index'));
			}

			//支付宝支付
			$config = config('txypay');
			require_once EXTEND_PATH.'/txypay/pagepay/service/AlipayTradeService.php';
			require_once EXTEND_PATH.'/txypay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

			//商户订单号，商户网站订单系统中唯一订单号，必填
			$out_trade_no = $orderInfo['order_number'];

			//订单名称，必填
			$subject = '电子商城--支付';

			//付款金额，必填
			$total_amount = $orderInfo['order_amount'];

			//商品描述，可空
			$body = '';

			//构造参数
			$payRequestBuilder = new \AlipayTradePagePayContentBuilder();
			$payRequestBuilder->setBody($body);
			$payRequestBuilder->setSubject($subject);
			$payRequestBuilder->setTotalAmount($total_amount);
			$payRequestBuilder->setOutTradeNo($out_trade_no);

			$aop = new \AlipayTradeService($config);

			$response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

			//输出表单
			var_dump($response);
		}
		/** 同步支付成功通知地址*/
		public function paySuccess()
		{
			$param = input('get.');
			//dump($param);die;
			//验证订单号
			$orderWhere = [
					'order_number' => $param['out_trade_no'],
			];
			$orderInfo = $this->getOrderInfo($orderWhere);
			if(empty($orderInfo)){
				$this->error('此订单不存在',url('index/index'));
			}
			//验证订单金额
			if($orderInfo['order_amount']!=$param['total_amount']){
				$this->error('支付金额有误',url('index/index'));
			}
			//验证签名
			$config = config('txypay');
			require_once EXTEND_PATH.'/txypay/pagepay/service/AlipayTradeService.php';

			$alipaySevice = new \AlipayTradeService($config);
			$result = $alipaySevice->check($param);
			//dump($result);die; //bool型
			if($result) {
				//查询左侧分类信息
				$this->getIndexCateInfo();
				//验证成功
				$this->assign('orderInfo',$orderInfo);
				return view();
			}
			else {
				//验证失败
				echo "验证失败";
			}
		}
		/** 异步支付通知地址*/
		public function notify(){
//			echo '异步';die;
			$param = input('post.');
			$filename='/data/wwwroot/default/shop/notify.log';
			file_put_contents(
				$filename,
				print_r($param,true),
				FILE_APPEND
			);
			//验证订单是否正确
			$order_number = $param['out_trade_no'];
			$orderWhere = [
					'order_number' => $order_number,
			];
			$orderInfo = $this->getOrderInfo($orderWhere);
			if(empty($orderInfo)){
				file_put_contents(
					$filename,
					'order_number is not found',
					FILE_APPEND
				);
				echo 'order_number error';exit;
			}
			//验证订单金额
			if($orderInfo['order_amount']!=$param['total_amount']){
				file_put_contents(
					$filename,
					'order_amount is not found',
					FILE_APPEND
				);
				echo 'order_amount error';exit;
			}
			//验证签名
			$config = config('txypay');
			require_once EXTEND_PATH.'txypay/pagepay/service/AlipayTradeService.php';

			$alipaySevice = new \AlipayTradeService($config);
			$result = $alipaySevice->check($param);
			if(empty($result)){
				file_put_contents(
					$filename,
					'sign error',
					FILE_APPEND
				);
				echo 'sign error';exit;
			}
			//验证应用id
			if($config['app_id']!=$param['app_id']){
				file_put_contents(
					$filename,
					'app_id is not found',
					FILE_APPEND
				);
				echo 'app_id error';exit;
			}
			//验证支付状态是否为已支付 success
			if($orderInfo['pay_status']==2){
				file_put_contents(
					$filename,
					'pay_status pass',
					FILE_APPEND
				);
				echo 'pay_status success';exit;
			}
			//修改支付状态 支付时间 success fail
			if($orderInfo['pay_status']==1){
				$data = [
					'pay_status' =>2,
					'order_status'=>3,
					'pay_time' =>time(),
					'utime' => time()
				];
				$where = [
					'order_number' => $order_number,
				];
				$order_model = model('Order');
				$res = $order_model->where($where)->update($data);
				if($res){
					file_put_contents(
						$filename,
						'pay_status pass',
						FILE_APPEND
					);
					echo 'success';
				}else{
					file_put_contents(
						$filename,
						'pay_status fail',
						FILE_APPEND
					);
					echo 'fail';
				}
			}
		}
	}
?>