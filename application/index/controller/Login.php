<?php
	namespace app\index\controller;
	use think\Controller;
	class Login extends Common{
		/** 注册 */
		public function register(){
			if(checkRequest()){
				$data = input('post.');

				//验证器
				$validate = validate('User');
				if(empty($data['user_email'])){
					$res = $validate->scene('registerTel')->check($data);
				}else{
					$res = $validate->scene('register')->check($data);
				}
				if(!$res){
					fail($validate->getError());
				}
				//入库
				$model = model('User');
				$res = $model->allowField(true)->save($data);
				if($res){
					//存储session
					if(empty($data['user_email'])){
						$account = $data['user_tel'];
					}else{
						$account = $data['user_email'];
					}
					$userInfo = [
						'user_id' => $model->user_id,
						'account' => $account,
					];
					session('userInfo',$userInfo);

					successfly('注册成功');
				}else{
					fail('注册失败');
				}
				
			}else{
				$this->view->engine->layout(false); 
				return view();
			}	
		}

		/** 邮箱  短信 发送 */
		public function sendEmail(){
			$user_email = input('post.user_email');
			$user_tel = input('post.user_tel');
			$code = createCode();
			// echo $code;die;
			if(substr_count($user_email,'@')){
				$res = sendEmail($user_email,$code);
				// dump($res);exit;
			
				if($res){

					$where = [
						'user_email' => $user_email,
					];
					$data = model('User')->where($where)->find();
					if(!empty($data)){
						fail('此账号已存在');
					}
					$emailInfo = [
						'user_email' => $user_email,
						'code' => $code,
						'time' => time(),
					];
					session('emailInfo',$emailInfo);
					successfly('发送成功');
				}else{
					fail('发送失败');
				}
			}else{
				$res = sendSms($user_tel,$code);
				if($res->Message=='OK'){
					$where = [
						'user_tel' => $user_tel,
					];
					$data = model('User')->where($where)->find();
					if(!empty($data)){
						fail('此账号已存在');
					}
					$telInfo = [
						'user_tel' => $user_tel,
						'code' => $code,
						'time' => time(),
					];
					session('emailInfo',$telInfo);
					successfly('发送成功');
				}else{
					fail('发送失败');
				}
			}	
		}
		
		/** 登录 */
		public function login(){
			if(checkRequest()){
				$account = input('post.account');
				$user_pwd = input('post.user_pwd');
				$remember_me = input('post.remember_me');
				if(empty($account)){
					fail('账号必填');
				}
				if(empty($user_pwd)){
					fail('密码必填');
				}
				//处理条件
				if(substr_count($account,'@')){
					$where = [
						'user_email' => $account,
					];
				}else{
					$where = [
						'user_tel' => $account,
					];
				}
				$model = model('User');
				$info = $model->where($where)->find();
				if(!empty($info)){
					$time = time();
					$last_error_time = $info['last_error_time'];
					$error_num = $info['error_num'];
					$where = [
							'user_id' => $info['user_id'],
					];
					$user = model('User');
					if(md5($user_pwd)==$info['user_pwd']){
						//错误次数大于5次，&& 时间在一小时内
						if($error_num>=5&&$time-$last_error_time<3600){
							$second = 60-ceil(($time-$last_error_time)/60);
							fail('此账号已被锁定，'.$second.'分钟后方可登录');
						}
						//错误次数改为0 时间改为null
						$updateInfo = [
								'error_num' => 0,
								'last_error_time' => null,
						];
						$user->save($updateInfo,$where);

						//将用户信息存到session中
						$userInfo = [
							'user_id' => $info['user_id'],
							'account' => $account,
						];
						session('userInfo',$userInfo);

						//10天免登陆
						if($remember_me=='true'){
							$day = 60*60*24*10;
							cookie('account',$account,$day);
							cookie('user_pwd',$user_pwd,$day);
						}
						//同步将浏览记录到数据库中
						$this->asyncHistory();
						//同步数据库
						$this->asyncCart();
						successfly('登录成功');
					}else{
						if($time-$last_error_time>3600){
							$updateInfo = [
								'error_num' => 1,
								'last_error_time' => $time,
							];
							//改
							$res = $user->save($updateInfo,$where);
							if($res){
								fail('账号或密码有误，您还有4次机会');
							}
						}else{
							if($error_num>=5){
								$second = 60-ceil(($time-$last_error_time)/60);
								fail('此账号已被锁定，'.$second.'分钟后方可登录');
							}else{
								$num = $error_num+1;
								$updateInfo = [
									'error_num' => $num,
									'last_error_time' => $time,
								];
								//改
								$res = $user->save($updateInfo,$where);
								if($res){
									if($num==5){
										fail('此账号已被锁定，一小时后方可登录');
									}else{
										fail('账号或密码有误，您还有'.(5-$num).'次机会');
									}
								}
							}
						}
					}
				}else{
					fail("此账号不存在，请注册后再行登录");
				}

			}else{
				/*$cart = cookie('cart');
				$cartInfo = unserialize(base64_decode($cart));
				print_r($cartInfo);die;*/
				$this->view->engine->layout(false);
				return view();
			}
		}
		/** 退出 */
		public function quit(){
        	session('userInfo', null);
        	cookie('user_pwd',null);
        	cookie('account',null);
        	$this->redirect('login/login');
    	}
	}
?>