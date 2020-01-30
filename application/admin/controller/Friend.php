<?php
	namespace app\admin\controller;
	class Friend extends Common{
		/** 友链添加 */
		public function friendAdd(){
			if(checkRequest()){
				$data = input('param.');
				//验证器
				
				//入库
				$res = model('Friend')->save($data);
				if($res){
					successfly('添加成功');
				}else{
					fail('添加失败');
				}
			}else{
				return view();
			}
			
		}
		/** 唯一性验证 */
		public function checkName(){
			
			$type = input('post.type');
			$friend_name = input('post.friend_name');
			if($type==1){
				$where = ['friend_name' =>$friend_name];
			}else{
				$old_name = input('post.old_name');
				$where = "friend_name != '$old_name' and friend_name = '$friend_name'";
			}
			
			$arr = model('Friend')->where($where)->find();
			if($arr){
				return 'no';
			}else{
				return 'ok';
			}
		}
		/** 即点即改 */
		public function friendUpd(){
			$value = input('param.value');
			$field = input('param.field');
			$friend_id = input('param.friend_id');
			
			$info = [
				$field => $value,
			];
			$res = model('Friend')->where('friend_id',$friend_id)->update($info);
			// echo model('Friend')->getLastSql();exit;
			if($res){
				successfly('修改成功');
			}else{
				fail('修改失败');
			}
		}
		/** 友联展示 */
		public function friendList(){
			return view();
		}
		/** 数据接口 */
		public function getFriendInfo(){
			$page = input('param.page');
			$limit = input('param.limit');
			$res = model('Friend')->page($page,$limit)->select();
			$count = model('Friend')->count();
			$info = ['code'=>'0','msg'=>'','count'=>$count,'data'=>$res];
			echo json_encode($info);
		}
		/** 删除 */
		public function friendDel(){
			$friend_id = input('post.friend_id');
			$where = [
				'friend_id' =>$friend_id
			];
			$res = model('friend')->where($where)->delete();
			//echo model('friend')->getLastSql();exit;
			if($res){
				successfly('删除成功');
			}else{
				fail('删除失败');
			}
		}
		/** 修改 */
		public function friendUpdate(){
			if(checkRequest()){
				$data = input('param.');
				$where = [
					'friend_id' => $data['friend_id'],
				];
				$res = model('friend')->save($data,$where);
				if($res===false){
					fail('修改失败');
				}else{
					successfly('修改成功');
				}
			}else{
				$friend_id = input('get.friend_id');
				$data = model('Friend')->where('friend_id',$friend_id)->find();
				$this->assign('data',$data);
				return view();
			}
		}
	}
?>