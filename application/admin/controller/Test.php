<?php
	namespace app\admin\controller;
	use think\Controller;
	class Test extends Controller{
		public function testList(){
			$sql = "select *,CONCAT(path,'-',c_id) as new_path from shop_cate order by new_path asc";
			$data = model('Cate')->query($sql);
			$this->assign('data',$data);
			return view();
		}
	}
?>