<?php
	namespace app\index\model;
	use think\Model;

	class Address extends Model{
		protected $updateTime = false;
		protected $table = 'shop_address';

		protected $insert = ['user_id'];
		public function setUserIdAttr(){
			return session('userInfo.user_id');
		}
		/** 收取所有收货地址*/
		public function getAddressInfo($where){
			$addressInfo = $this->where($where)->select();
			$area = model('Area');
			foreach($addressInfo as $k=>$v){
				// $addressInfo[$k]['province']=$area->where(['id'=>$v['provice']])->value('name');
				$areaWhere = [
					'id' =>['in',[$v['province'],$v['city'],$v['area']]],
				];
				$field = $area->where($areaWhere)->column('name');
//				print_r($field);exit;
				$addressInfo[$k]['address']=implode('',$field);
			}
			return $addressInfo;
		}
	}
?>