<?php
	namespace app\admin\controller;
	class Goods extends Common{
		/** 添加 */
		public function goodsAdd(){
			if(checkRequest()){
				$data = input('post.');
				//入库
				$res = model('Goods')->allowField(true)->save($data);
				if($res){
					successfly('添加成功');
				}else{
					fail('添加失败');
				}

			}else{
				//获取分类数据
				$cateInfo = $this->getCateInfo();	
				//获取品牌数据
				/*$where = [
					'brand_show' => 1,
				];
				$brandInfo = model('Brand')->where($where)->select();*/
				$brandInfo = model('Brand')->select();

				$this->assign('cateInfo',$cateInfo);
				$this->assign('brandInfo',$brandInfo);
				return view();
			}
		}
		/** 获取分类的数据 */
    	public function getCateInfo(){
	    	$data = model('Category')->select();
	    	$info = getCateInfo($data);
	    	return $info;
   		}
   		/** 上传图片 */
		public function goodsUpload(){
			$file = request()->file('file');
			$type = input('get.type');
			$dir = $type==1?'goodsimg':'goodsimgs';
			$info = $file->move(ROOT_PATH . 'public' . DS . $dir);
			if($info){
				$arr = [
					'code' => 1,
					'msg' => '上传成功',
					'src' => $info->getSaveName(),
				];
				echo json_encode($arr);
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
		/** 唯一性验证 */
		public function checkName(){
			$goods_name = input('post.goods_name');
			$type = input('post.type');
			if($type==1){
				$where = ['goods_name' => $goods_name, ];
			}else{
				$old_name = input('post.old_name');
				$where = "goods_name != '$old_name' and goods_name = '$goods_name'";
			}
			
			$res = model('Goods')->where($where)->find();
			if($res){
				return 'no';
			}else{
				return 'ok';
			}
		}
		/** 富文本编辑器的图片上传*/
		public function goodseditimgs(){
			$file = request()->file('file');
			$info = $file->move(ROOT_PATH . 'public' . DS . 'goodseditimgs');
			if($info){
				$arr = [
						'code' => 0,
						'font' => '',
					    'data' => [
							'src' => "http://www.shop.com/public/goodseditimgs/".$info->getSaveName(),
							'title' => 'ok',
						],

				];
				echo json_encode($arr);
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}
		}
		/** 数据 */
		public function getInfo(){
			$page = input('get.page');
			// echo $page;
			$limit = input('get.limit');
			$goods_name = input('get.goods_name');
			$cate_name = input('get.cate_name');
			$brand_name = input('get.brand_name');

			$where = [];
			if(!empty($goods_name)){
				$where['goods_name'] = ['like',"%$goods_name%"];
			}
			if(!empty($cate_name)){
				$where['cate_name'] = $cate_name; 
			}
			if(!empty($brand_name)){
				$where['brand_name'] = $brand_name;
			}

			$count = model('Goods')->getGoodsCount($where);
			/*$last_count = ceil($count/$limit);
			if($page>$last_count){
				$page = $page-1;
			}*/
			$res = model('Goods')->getGoodsInfo($page,$limit,$where);
			$info = [
				'code' => 0,
				'msg' => '',
				'count' => $count,
				'data' => $res,
			];
			echo json_encode($info);
		}
		/** 列表展示 */
		public function goodsList(){
			//商品分类
			$cateInfo = $this->getCateInfo();
			//商品品牌
			$brandInfo = model('Brand')->select();

			$this->assign('cate',$cateInfo);
			$this->assign('brand',$brandInfo);

			return view();
		}
		/** 删除 */
		public function goodsDel(){
			$goods_id = input('post.goods_id');
			$model = model('Goods');
			$where = [
				'goods_id' => $goods_id,
			];
			$res = $model->where($where)->delete();
			if($res){
				successfly('删除成功');
			}else{
				fail('删除失败');
			}
		}
		/** 即点即改 */
		public function goodsUpd(){
			$goods_id = input('post.goods_id');//id
			$value = input('post.value');//状态 值
			$field = input('post.field');//字段
			$where = [
				'goods_id' => $goods_id,
			];
			$data = [
				$field => $value,
			];
			$res = model('Goods')->save($data,$where);
			if($res===false){
				fail('修改失败');
			}else{
				successfly('修改成功');
			}
		}
		/** 编辑 */
		public function goodsUpdate(){
			if(checkRequest()){
				$data = input('post.');
				$where = [
					'goods_id' => $data['goods_id'],
				];
				$res = model('Goods')->allowField(true)->save($data,$where);
				if($res===false){
					fail('修改失败');
				}else{
					successfly('修改成功');
				}
			}else{
				$goods_id = input('get.goods_id');
				$where = [
					'goods_id' => $goods_id,
				];
				$data = model('Goods')->where($where)->find();

				//获取分类数据
				$cateInfo = $this->getCateInfo();
				//获取品牌数据
				$brandInfo = model('Brand')->select();

				$this->assign('cateInfo',$cateInfo);
				$this->assign('brandInfo',$brandInfo);
				$this->assign('data',$data);
				return view();
				//return $this->fetch('goodsupdate',[],['__PUBLIC__'=>'/public/goodsimg/']);
			}
		}
	}
?>