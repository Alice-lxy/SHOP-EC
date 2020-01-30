<?php
	namespace app\index\controller;
	class UserOrder extends Common
	{
		public function orderList(){
			//检测是否登录
			if(!$this->checkUserLogin()){
				$this->error('请先登录!',url('login/login'));
			}

			$where = [
				'user_id' => $this->getUserId(),
			];
			$order = model('Order');
			$orderInfo = collection($order->where($where)->select())->toArray();
			$this->assign('orderInfo',$orderInfo);
			return view();
		}
		/** 订单详情*/
		public function orderdetail(){
			if(!$this->checkUserLogin()){
				$this->error('请先登录',url('login/login '));
			}
			$order_number = input('get.order_number');
			if(empty($order_number)){
				$this->error('请选择订单',url('user_order/orderlist'));
			}
//			echo $order_number;die;
			$data = $this->getExpressInfo($order_number);
		}

		public function getExpressInfo($order_number){
			//date_default_timezone_set("PRC");
			$showapi_appid = '83209';  //替换此值,在官网的"我的应用"中找到相关值
			$showapi_secret = '1ddb7534ea9c4424ba7dd3dfb91b5a59';  //替换此值,在官网的"我的应用"中找到相关值
			$paramArr = array(
					'showapi_appid'=> $showapi_appid,
					'com'=> "auto",
					'nu'=> $order_number
			//添加其他参数
			);
			//echo $order_number;die;

			//创建参数(包括签名的处理)
			function createParam ($paramArr,$showapi_secret) {
				$paraStr = "";
				$signStr = "";
				ksort($paramArr);
				foreach ($paramArr as $key => $val) {
					if ($key != '' && $val != '') {
						$signStr .= $key.$val;
						$paraStr .= $key.'='.urlencode($val).'&';
					}
				}
				$signStr .= $showapi_secret;//排好序的参数加上secret,进行md5
				$sign = strtolower(md5($signStr));
				$paraStr .= 'showapi_sign='.$sign;//将md5后的值作为参数,便于服务器的效验
				return $paraStr;
			}

			$param = createParam($paramArr,$showapi_secret);
			$url = 'http://route.showapi.com/64-19?'.$param;
			$result = file_get_contents($url);
			$result = json_decode($result,true);
			print_r($result);exit;
			$data = $result->showapi_res_body->data;
			return $data;
		}
	}
?>