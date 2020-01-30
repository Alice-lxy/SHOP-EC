<?php
	namespace app\index\controller;

	class User extends Common{
		/** 个人中心首页*/
		public function index(){
			//验证非法登录
			if(!$this->checkUserLogin()){
				$this->error('请先登录',url('login/login'));exit;
			}
			return view();
		}
	}
?>