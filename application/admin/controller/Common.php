<?php
	namespace app\admin\controller;
	use think\Controller;
	class Common extends Controller{
		function __construct(){
			parent::__construct();
			if(!session('?adminInfo')){
				$this->error('请先登录','login/login');
			}
		}
	}
?>