<?php
	namespace app\index\validate;
	use think\Validate;
	class User extends Validate{
		//验证规则
		protected $rule = [
			'user_email'=>'require|email|checkEmail|unique:user',
			'user_tel'=>'require|checkTel|unique:user',
			'user_code'=>'require|checkCode',
			'user_pwd'=>'require|checkPwd',
			'user_pwd1'=>'require|confirm:user_pwd',	
		];
		//验证提示
		protected $message = [
			'user_email.require' => '邮箱必填',
			'user_email.email' => '请输入正确邮箱',
			'user_email.unique' => '邮箱已被注册 请登录',
			'user_code.require' => '验证码必填',
			'user_pwd.require' => '密码必填',
			'user_pwd1.require' => '确认密码必填',
			'user_pwd1.confirm' => '确认密码与密码保持一致',
			'user_tel.require' => '手机号必填',
			'user_tel.unique' => '手机号已被注册 请登陆',
		];
		//验证场景
		protected $scene = [
			'register'=>['user_email','user_code','user_pwd','user_pwd1'],
			'registerTel'=>['user_tel','user_code','user_pwd','user_pwd1'],
		];
		// 验证邮箱 
		public function checkEmail($value,$rule,$data){
			$email = session('emailInfo.user_email');
			if($value==$email){
				return true;
			}else{
				return '当前邮箱与发送验证码的邮箱不一致';
			}
		}
		//验证手机号
		public function checkTel($value,$rule,$data){
			$reg = '/^1[3-9]\d{9}$/';
			$tel = session('emailInfo.user_tel');
			if(!preg_match($reg, $value)){
				return '请输入正确格式的手机号';
			}else if($value==$tel){
				return true;
			}else{
				return '当前手机号与发送验证码的手机号不一致';
			}
		}
		// 验证验证码 
		public function checkCode($value,$rule,$data){
			$code = session('emailInfo.code');
			$time = session('emailInfo.time');
			if($value!=$code){
				return '验证码有误';
			}else if(time()-$time>300){
				return '验证码已失效，五分钟内输入有效';
			}else{
				return true;
			}
		}
		// 自定义验证密码
		public function checkPwd($value,$rule,$data){
			$reg = '/^.{6,}$/';
			if(!preg_match($reg,$value)){
				return '密码至少六位';
			}else{
				return true;
			}
		}
		
	}