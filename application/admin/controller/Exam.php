<?php
	namespace app\admin\controller;
	use think\Controller;

	class Exam extends Controller{
		public function examAdd(){
			return view();
		}
		public function examInsert(){
			/*$data = input('post.');
			// dump($data);
			for($i=0;$i<count($data['username']);$i++){//i下标
				// echo $i;
				foreach($data as $k=>$v){
					$a[$k] = $v[$i];
					// print_r($v[$i]);
				}
				// print_r($a);
				$info[]=$a;
			}
			model('Exam')->saveAll($info);*/
			$str = rtrim(input('post.str'),',|');
			// echo $str;
			$res = explode('|',$str);
			// print_r($res);
			foreach($res as $k=>$v){
				$v = rtrim($v,',');
				$arr = explode(',',$v);
				// print_r($arr);exit;
				foreach($arr as $key=>$value){
					$a[substr($value,0,strpos($value,':'))]=substr($value,strpos($value,':')+1);

				}//print_r($a);
				$info[]=$a;
			}
			model('Exam')->saveAll($info);
		}
	
	}
?>