<?php
	namespace app\admin\model;
	use think\Model;

	class Goods extends Model{
		protected $updateTime = false;
		protected $table = "shop_goods";


		public function getGoodsInfo($page,$limit,$where){
			$data = $this
				->alias('g')//起别名
				->field("g.*,cate_name,brand_name")
				->join("shop_category c","g.cate_id=c.cate_id")
				->join("shop_brand b","g.brand_id=b.brand_id")
				->where($where)
				->page($page,$limit)
				->select();
			foreach($data as $k=>$v){
				$data[$k]['goods_up']=$v['goods_up']==1?'√':'×';
				$data[$k]['goods_new']=$v['goods_new']==1?'√':'×';
				$data[$k]['goods_best']=$v['goods_best']==1?'√':'×';
				$data[$k]['goods_hot']=$v['goods_hot']==1?'√':'×';

			}
			return $data;
		}
		//计算总条数
		public function getGoodsCount($where){
			$count = $this
				->alias('g')//起别名
				->field("g.*,cate_name,brand_name")
				->join("shop_category c","g.cate_id=c.cate_id")
				->join("shop_brand b","g.brand_id=b.brand_id")
				->count();
			return $count;
		}
	}
?>