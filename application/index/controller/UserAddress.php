<?php
	namespace app\index\controller;

	class UserAddress extends Common{
		/**	收货地址*/
		public function address(){
			if(checkRequest()){
				$data = input('post.',0);
				$address = model('Address');

				//判断是否为默认的收货地址
				if($data['is_default']==1){
					$where = [
						'user_id' => session('userInfo.user_id'),
					];
					$res1 = $address->where($where)->update(['is_default'=>2]);
				}
				//入库
				$res = $address->save($data);
				if($res){
					successfly('添加成功');
				}else{
					fail('添加失败');
				}
			}else{
				//验证非法登录
				if(!$this->checkUserLogin()){
					$this->error('请先登录',url('login/login'));exit;
				}
				$address = model('Address');
				//查询当前用户所有的收货地址
				$where = [
					'user_id' => session('userInfo.user_id'),
				];
				$addressInfo = $address->getAddressInfo($where);
				//print_r($addressInfo);exit;

				//获取所有下拉菜单的省市的值
				$provinceInfo = $this->getAreaInfo(0);
				$this->assign('provice',$provinceInfo);
				$this->assign('address',$addressInfo);
				return view();
			}
		}
		/**	三级联动获取*/
		public function getArea(){
			$id = input('post.id');
			$info = $this->getAreaInfo($id);
			echo json_encode($info);
		}
		/**	获取区域信息*/
		public function getAreaInfo($id){
			$area = model('Area');
			$where = [
					'pid'=>$id,
			];
			$info = $area->where($where)->select();
			return $info;
		}
		/** 删除*/
		public function addressDel(){
			$id = input('post.id',0,'intval');

			if(empty($id)){
				fail('非法操作此页面');
			}
			$address = model('Address');
			$where = [
				'add_id' => $id
			];
			$res = $address->destroy($where);
			if($res){
				successfly('删除成功');
			}else{
				fail('删除失败');
			}
		}
		/** 默认点击*/
		public function addressmr(){
			$id = input('post.id');
			$address = model('Address');
			$where = [
				'user_id' => session('userInfo.user_id'),
			];
			$arr = $address->where($where)->update(['is_default'=>2]);

			$usreWhere = [
				'add_id' => $id,
			];
			$arr1 = $address->where($usreWhere)->update(['is_default'=>1]);
			if($arr1){
				successfly('设置成功');
			}else{
				fail('设置失败');
			}
		}
		/** 编辑*/
		public function addressUpdate(){
			if(checkRequest()){
				$data = input('post.','');

				$address = model('Address');
				//判断是否为默认的收货地址
				if($data['is_default']==1){
					$where = [
						'user_id' => session('userInfo.user_id'),
					];
					$res = $address->where($where)->update(['is_default'=>2]);
				}
				$arr = $address->where('add_id',$data['add_id'])->update($data);
				if($arr===false){
					fail('修改失败');
				}else{
					successfly('修改成功');
				}
			}else{
				$id = input('get.id',0,'intval');
				if(empty($id)){
					fail('非法操作此页面！！！');
				}
				$address = model('Address');
				$where = [
						'add_id' => $id,
				];
				$addressInfo = $address->where($where)->find();

				//查询所有的省份的数据
				$provinceInfo = $this->getAreaInfo(0);
				//查询所有市的数据
				$cityInfo = $this->getAreaInfo($addressInfo['province']);
				//查询所有区的数据
				$areaInfo = $this->getAreaInfo($addressInfo['city']);

				$this->assign('provice',$provinceInfo);
				$this->assign('city',$cityInfo);
				$this->assign('area',$areaInfo);
				$this->assign('address',$addressInfo);
				return view();
			}
		}
	}
?>