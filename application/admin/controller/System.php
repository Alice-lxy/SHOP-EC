<?php
	namespace app\admin\controller;
	// use think\Controller;

	class System extends Common{
		public function system(){
			if(checkRequest()){
				$data = input('post.');
				// print_r($data);exit;
				foreach($data as $k=>$v){
					$info[] = ['name'=>$k,'value'=>$v];
				}
				/*$info = [
					['name'=>'WEB_NAME','value'=>'A'],
					['name'=>'WEB_URL','value'=>'S'],
					['name'=>'WEB_COPYRIGHT','value'=>'D'],
					['name'=>'WEB_RECODE','value'=>'F'],
				];*/
				// print_r($info);exit;
				model('Config')->query("delete from shop_config");
				$res = model('Config')->saveAll($info);
				if($res){
					successfly('保存成功');
				}else{
					fail('保存失败');
				}
			}else{
				//$res = collection(model('Config')->select())->toArray();//二维
				$res = model('Config')->select();
				if(!empty($res)){
					foreach($res as $k=>$v){
						$info[$v['name']] = $v['value'];
					}
					$this->assign('info',$info);
				}
				/*$info = [
					'WEB_NAME'=>'a',
					'WEB_URL' => 's',
					'WEB_COPYRIGHT' => 'd',
					'WEB_RECORD' => 'f',
				];	*/			
				return view();
			}	
		}
	}
?>