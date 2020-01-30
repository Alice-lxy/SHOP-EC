<?php
namespace app\admin\controller;
use think\Controller;
class Node extends Controller
{
    /** 节点添加 */
    public function nodeAdd(){
        if(checkRequest()){
            $data = input('post.');
            $node = model('Node');
            $res = $node->save($data);
            if($res){
                successfly('添加成功');
            }else{
                fail('添加失败');
            }
        }else{
            //处理决定节点数据
            $nodeInfo = $this->getNodeInfo();
            $this->assign('nodeInfo',$nodeInfo);
            return view();
        }
    }
    /** 获取节点的数据 */
    public function getNodeInfo(){
        $data = model('Node')->select();
        $info = getNodeInfo($data);
        return $info;
    }

    /** 节点展示*/
    public function nodeList(){
        $info = $this->getNodeInfo();
        $this->assign('info',$info);
        return view();

    }

    /** 节点删除*/
    public function nodeDel(){
        $node_id = input('post.node_id','');
        //查询此下是否有子类
        $nodeWhere = [
            'pid' => $node_id,
        ];
        $node = model('Node');
        $count = $node->where($nodeWhere)->count();
        if($count>0){
            fail("此分类下有子类或商品信息，不可删除");
        }
        $res = model('Node')->where('node_id',$node_id)->delete();
        if($res){
            successfly('删除成功');
        }else{
            fail('删除失败');
        }

    }

    /*即点即改*/
    public function nodeUpdateField(){
        $value = input('post.value');
        $node_id = input('post.node_id');
        $field = input('post.field');

        $where = [
            'node_id' => $node_id,
        ];
        $data = [
            $field => $value,
        ];
        $res = model('Node')->save($data,$where);
        if($res===false){
            fail('修改失败');
        }else{
            successfly('修改成功');
        }
    }

    /** 节点修改*/
    public function nodeUpdate(){
        if(checkRequest()){
            $data = input('post.');
            //控制器
            /*$validate = validate('Category');
            if(!$validate->check($data)){
                fail($validate->getError());
            }*/
            $where = [
                'node_id' => $data['node_id'],
            ];

            $res = model('Node')->save($data,$where);
            if($res===false){
                fail('修改失败');
            }else{
                successfly('修改成功');
            }
        }else{
            $node_id = input('get.node_id');
            //根据id查要修改的数据
            $where = [
                'node_id' => $node_id,
            ];
            $data = model('Node')->where($where)->find();

            //查询所有下拉信息
            $info = $this->getNodeInfo();
            $this->assign('info',$info);
            $this->assign('data',$data);
            return view();
        }
    }
}
?>
