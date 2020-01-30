<?php
	namespace app\admin\validate;
	use think\Validate;
	class Admin extends Validate{
		protected $rule = [
			'admin_name' => 'require|checkName',//|unique:admin
			'admin_pwd' => 'require|checkPwd',
			'admin_email' => 'require|email',
			'admin_tel' => 'require|checkTel',
		];
		protected $message = [
			'admin_name.require'=>'名称必填',
			'admin_name.unique'=>'名称已存在',
			'admin_pwd.require'=>'密码必填',
			'admin_email.require'=>'邮箱必填',
			'admin_email.email'=>'请输入正确格式的邮箱',
			'admin_tel.require'=>'手机号必填',
		];
		protected $scene = [
			'add' => ['admin_name','admin_pwd','admin_email','admin_tel'],
			'edit' => ['admin_name','admin_email','admin_tel'],
		];
		/*验证用户名*/
		public function checkName($value,$rule,$data){
			$reg = '/^[a-z_]\w{3,11}$/i';
			if(!preg_match($reg, $value)){
				return "名称由数字，字母，下划线组成且不以数字开头4-12位";
			}else{
				$model = model('admin');
				if(empty($data['admin_id'])){
					$where = [
						'admin_name'=>$value,
					];
				}else{
					$where = [
						'admin_id' => ['neq',$data['admin_id']],
						'admin_name' => $value,
					];
				}
				$arr = $model->where($where)->find();
				if($arr){
					return '账号已存在';
				}else{
					return true;
				}
			}
		}
		/*验证密码*/
		public function checkPwd($value,$rule,$data){
			$reg = '/^.{6,12}$/';
			if(!preg_match($reg, $value)){
				return "密码由6-12位组成";
			}else{
				return true;
			}
		}
		/*验证手机号*/
		public function checkTel($value,$rule,$data){
			$reg = '/^1[3-8]\d{9}$/';
			if(!preg_match($reg, $value)){
				return "请输入正确格式的手机号";
			}else{
				return true;
			}
		}
	}
?>