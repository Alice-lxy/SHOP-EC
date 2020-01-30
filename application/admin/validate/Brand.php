<?php
	namespace app\admin\validate;
	use think\Validate;
	class Brand extends Validate{
		protected $rule = [
			'brand_name' => 'require|checkName',
			'brand_url' =>'require|url',
			'brand_describe' => 'require',
		];
		protected $message = [
			'brand_name.require' => '品牌名称必填',
			'brand_url.require' => '网址必填',
			'brand_url.url' => '请填写正确格式的网址',
			'brand_describe' => '描述必填',
		];
		/** 验证用户名 */
		public function checkName($value,$rule,$data){
			$reg = '/^[a-z_]\w{2,9}|[\x{4e00}-\x{9fa5}]{2,}$/u';
			if(!preg_match($reg, $value)){
				return "名称由3-10位的字母数字下划线或至少两位汉字组成，不能由数字开头";
			}else{
				$model = model('Brand');
				if(empty($data['brand_id'])){
					$where = [
						'brand_name'=>$value,
					];
				}else{
					$where = [
						'brand_id' => ['neq',$data['brand_id']],
						'brand_name' => $value,
					];
				}
				$arr = $model->where($where)->find();
				if($arr){
					return '账号已存在';
				}else{
					return true;
				}
			}
		}
		
	}
?>