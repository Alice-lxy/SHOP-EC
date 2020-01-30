<?php
	namespace app\admin\model;
	use think\Model;

	class Admin extends Model{
		protected $updateTime = false;
		protected $insert = ['salt'];
		protected $salt;

		//修改器修改密码
		public function setAdminPwdAttr($value){
			$this->salt =$salt = createSalt();
			$newPwd = createPwd($value,$salt);
			return $newPwd; 
		}
		//数据完成--盐值
		public function setSaltAttr(){
			return $this->salt;
		}
	}
?>