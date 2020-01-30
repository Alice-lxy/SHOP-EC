<?php
namespace app\index\controller;

class Index extends Common
{
	//前台首页
    public function index(){
        //
        $this->getWebConfig();
        
    	//查询首页左侧分类数据
    	$this->getIndexCateInfo();

        //获取楼层数据
        $cate_id = 1;
        $info = $this->getFloorInfo($cate_id);
        $this->assign('info',$info);
        // exit;
		return view();
    }
    /** 获取楼层数据 */
    public function getFloorInfo($cate_id){
        /**
         * 1、顶级分类信息
         * 2、二级分类信息
         * 3、商品信息 获取所有商品信息[1 3 4  11 12] select * from goods where cate_id in (1,10,11,12,13...);
         */
        //顶级分类信息
        $cate = model('Category');
        $topWhere = [
            'cate_id' => $cate_id,
            'cate_show' => 1,
        ];
        $info['topData'] = $cate->field('cate_id,cate_name')->where($topWhere)->find();
        // echo $cate->getlastsql();die;
        //print_r($info['topData']);die;
        //二级分类信息
        $cateWhere = [
            'pid' => $cate_id,
            'cate_show' => 1,
        ];
        $info['cateData'] = $cate->field('cate_id,cate_name')->where($cateWhere)->select();
        
        //商品信息
        $cateInfo = $cate->where('cate_show',1)->select();
        // print_r($cateInfo);die;
        $cateId = getCateId($cateInfo,$cate_id);
        $cateId = implode(',',$cateId);
        $goods = model('Goods');
        $goodsWhere = [
            'cate_id' => ['in',$cateId],
            'goods_up' => 1,
        ];
        $info['goodsData'] = $goods->where($goodsWhere)->select();
        return $info;
    }
    /** 获取更多楼层数据 */
    public function getMoreFloor(){
        $cate_id = input('post.cate_id');
        $floor_num = input('post.floor_num');
        $floor_num=$floor_num+1;

        //获取下一楼层的分类id
        $cate = model('Category');
        $where = [
            'cate_id' => ['>',$cate_id],
            'pid' => 0,
            'cate_show'=>1
        ];
        $arr = $cate->field('cate_id')->where($where)->order('cate_id','asc')->find();
        //echo $cate->getlastsql();
        $cate_id = $arr['cate_id'];
        if(!empty($cate_id)){
            $info = $this->getFloorInfo($cate_id);
            $this->view->engine->layout(false);
            $this->assign('info',$info);
            $this->assign('floor_num',$floor_num);
            echo $this->fetch('div');
        }
    }
}