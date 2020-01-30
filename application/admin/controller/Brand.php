<?php
	namespace app\admin\controller;
	//use think\Controller;
	class Brand extends Common{
		/** 品牌添加 */
		public function brandAdd(){
			if(checkRequest()){
				$data = input('post.');

				//使用验证器
				$validate = validate('Brand');
				if(!$validate->check($data)){
					fail($validate->getError());
				}


				$res = model('Brand')->allowField(true)->save($data);
				if($res){
					successfly('添加成功');
				}else{
					fail('添加失败');
				}
			}else{
				return view();
			}
		}
		/** 品牌名称的唯一性验证 */
		public function checkName(){
			$brand_name = input('post.brand_name');
			$type = input('post.type');
			if($type==1){
				$where = ['brand_name' => $brand_name];
			}else{
				$old_name = input('param.old_name');
				$where = "brand_name != '$old_name' and brand_name = '$brand_name'";
			}

			$res = model('Brand')->where($where)->find();
			if($res){
				return 'no';
			}else{
				return 'ok';
			}
		}
		/** 上传图片 */
		public function brandLogo(){
			$file = request()->file('file');
			$info = $file->move(ROOT_PATH . 'public' . DS . 'brandlogo');
			if($info){
				$arr = [
					'code' => 1,
					'msg' => '上传成功',
					'src' => $info->getSaveName(),
				];
				echo json_encode($arr);
			}/*else{
				// 上传失败获取错误信息
				echo $file->getError();
			}*/
		}

		/** 品牌列表展示 */
		public function brandList(){
			return view();
		}
		/** 获取数据 */
		public function getBrandInfo(){
			$page = input('get.page');
			$limit = input('get.limit');
			$res = model('Brand')->page($page,$limit)->select();
			$count = model('Brand')->count();
			$info = ['code'=>'0','msg'=>'','count'=>$count,'data'=>$res];
			echo json_encode($info);
		}
		/** 即点即改 */
		public function brandUpd(){
			$field = input('post.field');
			$brand_id = input('post.brand_id');
			$value = input('post.value');
			
			//设置数据
			$info = [
				$field=>$value,
			];
			$res = model('Brand')->where('brand_id',$brand_id)->update($info);
			if($res){
				successfly('修改成功');
			}else{
				fail('修改失败');
			}
		}
		/** 删除 */
		public function brandDel(){
			$brand_id = input('post.brand_id');
			$where = [
				'brand_id' => $brand_id,
			];
			$res = model('Brand')->where($where)->delete();
			if($res){
				successfly('删除成功');
			}else{
				fail('删除失败');
			}
		}
		/** 修改 */
		public function brandUpdate(){
			if(checkRequest()){
				$data = input('post.');
		          //验证器
				$validate = validate('brand');
				if(!$result=$validate->check($data)){
					fail($validate->getError());
				}

				$where = [
					'brand_id'=>$data['brand_id'],
				];

				$res = model('brand')->save($data,$where);
				//echo model('admin')->getLastSql();exit;
				if($res===false){
					fail('修改失败');
				}else{
					successfly('修改成功');
				}
				
			}else{
				$brand_id = input('get.brand_id');
				// dump($brand_id);
				$where = [
					'brand_id' => $brand_id,
				];
				$data = model('Brand')->where($where)->find();
				$this->assign('data',$data);
				return view();
			}

			
		}
	}
?>