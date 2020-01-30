<?php
namespace app\admin\controller;

class Category extends Common
{
    /** 分类添加 */
    public function cateAdd()
    {
  		if(checkRequest()){
  			$data = input('post.');
  			//验证器
  			$validate = validate('Category');
        if(!$validate->check($data)){
          fail($validate->getError());
        }
  			//入库
  			$res = model('Category')->save($data);
  			if($res){
  				successfly('添加成功');
  			}else{
  				fail('添加失败');
  			}
  		}else{
  			$info = $this->getCateInfo();
  			$this->assign('info',$info);
  			return view();
		  }
    }
    /** 唯一性验证 */
   	public function checkName(){
   		$cate_name = input('post.cate_name');
      $type = input('post.type');
      if($type==1){
        $where = ['cate_name' => $cate_name,];
      }else{
        $old_name = input('post.old_name');
        $where = "cate_name != '$old_name' and cate_name = '$cate_name'";
      }
   		
   		$res =model('Category')->where($where)->find();
   		if($res){
   			return 'no';
   		}else{
   			return 'ok';
   		}
   	}
    /** 列表展示 */
    public function cateList()
    {
    	$info = $this->getCateInfo();
    	$this->assign('info',$info);
    	return view();
    }
    /** 获取分类的数据 */
    public function getCateInfo(){
    	/*$where = [
    		'cate_show' => 1,
    	];*/
    	$data = model('Category')->select();
    	$info = getCateInfo($data);
    	return $info;
    }
    /** 删除 */
   	public function cateDel(){
   		$cate_id = input('post.cate_id');
   		// echo $cate_id;
   		
   		// 查询此分类下是否由子类
   		$cateWhere = [
   			'pid' => $cate_id
   		];
   		$count = model('Category')->where($cateWhere)->count();
   		// echo $count;exit;
   		if($count>0){
   			fail("此分类下有子类或商品信息，不可删除");
   		}
   		// 查询此分类下是否有商品
   		$model = model('Goods');
   		$where = [
   			'cate_id' => $cate_id
   		];
   		$totle = $model->where($where)->count();
   		if($totle>0){
   			fail("此分类下有子类或商品信息，不可删除");
   		}
   		//删除
   		$res = model('Category')->where($where)->delete();
   		if($res){
   			successfly('删除成功');
   		}else{
   			fail('删除失败');
   		}
   	}
   	/** 即点即改 */
   	public function cateUpdateField(){
   		$value = input('post.value');
   		$cate_id = input('post.cate_id');
   		$field = input('post.field');

   		$where = [
   			'cate_id' => $cate_id,
   		];
   		$data = [
   			$field => $value,
   		];
   		$res = model('Category')->save($data,$where);
   		if($res===false){
   			fail('修改失败');
   		}else{
   			successfly('修改成功');
   		}
   	}
   	/** 修改 */
   	public function cateUpdate(){
   		if(checkRequest()){
   			$data = input('post.');
        //控制器
        $validate = validate('Category');
        if(!$validate->check($data)){
          fail($validate->getError());
        }
        
   			$where = [
   				'cate_id' => $data['cate_id'],
   			];

   			$res = model('Category')->save($data,$where);
   			// echo model('Category')->getLastSql();exit;
   			if($res===false){
	   			fail('修改失败');
	   		}else{
	   			successfly('修改成功');
	   		}
   		}else{
   			$cate_id = input('get.cate_id');
   			//根据id查要修改的数据
   			$where = [
   				'cate_id' => $cate_id,
   			];
   			$data = model('Category')->where($where)->find();

   			//查询所有下拉信息
   			$info = $this->getCateInfo();
			  $this->assign('info',$info);
			  $this->assign('data',$data);
   			return view();
   		}	
   	}

}
?>
