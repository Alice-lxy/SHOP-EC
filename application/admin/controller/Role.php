<?php
namespace app\admin\controller;
use think\Exception;

class Role extends Common
{
    /** 角色添加 */
    public function roleAdd(){
        if(checkRequest()){
            $data = input('post.');
            if(empty($data['node_id'])){
                fail('至少选择一个节点');
            }
            //保存数据到角色表中
            $role = model("Role");
            $role->startTrans();
            try{
                //入角色表
                $res1 = $role->allowField(true)->save($data);
                if(empty($res1)){
                    $role->rollback();
                    throw new \Exception('角色添加失败');
                }

                $role_id = $role->role_id;
                $power = model('Power');
                foreach($data['node_id'] as $k=>$v){
                    $info[] = ['role_id' => $role_id,'node_id'=>$v];
                }
//            print_r($info);die;
                $res2 = $power->saveAll($info);
                if(empty($res2)){
                    $role->rollback();
                    throw new \Exception('角色权限添加失败');
                }
                $role->commit();
                successfly('添加成功');
            }catch (\Exception $e){
                fail($e->getMessage());
            }
        }else{
            $nodeInfo = $this->getAllNode();
            $this->assign('info',$nodeInfo);
            return view();
        }


    }

    /** 角色展示*/
    public function roleList(){
        $role = model('Role');
        $roleInfo = $role->select();
        $this->assign('roleInfo',$roleInfo);
        return view();
    }

    /** 角色修改*/
    public function roleUpdate(){
        if(checkRequest()){
            $data = input('post.');
            $where = [
                'role_id' => $data['role_id']
            ];

            $role = model('Role');
            $role->startTrans();
            try{
                //修改角色表 角色名称
                $res = $role->allowField(true)->save($data,$where);
                if($res===false){
                    $role->rollback();
                    throw new \Exception('角色修改失败');
                }
                //修改角色—节点派生表  -节点id
                $role_id = $role->role_id;
                $power = model('Power');

                $power->where('role_id',$role_id)->delete();

                foreach($data['node_id'] as $k=>$v){
                    $info[] = ['role_id' => $data['role_id'],'node_id'=>$v];
                }
                $res2 = $power->saveAll($info);
                if($res2===false){
                    $role->rollback();
                    throw new \Exception('角色修改失败');
                }
                $role->commit();
                successfly('修改成功');
            }catch (\Exception $e){
                fail($e->getMessage());
            }
        }else{
            $role_id = input('get.role_id','','intval');
            if(empty($role_id)){
                fail('请选择正确的角色');
            }
            //根据角色id查询当前角色的信息
            $role = model('Role');
            $where = [
                'role_id'=>$role_id,
            ];
            $roleInfo = $role->where($where)->find();
            //查询角色所有节点信息
            $nodeInfo = $this->getAllNode();

            //查询出当前角色选择的节点ID
            $power = model('Power');
            $info = $power->where($where)->column('node_id');

            $this->assign('roleInfo',$roleInfo);
            $this->assign('nodeInfo',$nodeInfo);
            $this->assign('info',$info);
            return view();
        }

    }

    /** 角色删除*/
    public function roleDel(){
        $role_id = input('post.role_id','','intval');

        $role = model('Role');
        $role->startTrans();
        try{
            if(empty($role_id)){
                throw new \Exception('请选择要删除的角色');
            }
            $where = [
                'role_id' => $role_id,
            ];
            $adminrole = model('AdminRole');
            $count = $adminrole->where($where)->count();
            //dump($count);exit;
            if($count>0){
                fail('此下有'.$count.'个管理员管理，不可删除');
            }
            //删除角色表信息
            $role = model('Role');
            $arr1 = $role->where($where)->delete();
            if($arr1===false){
                $role->rollback();
                throw new \Exception('删除失败');
            }
            //删除派生表信息
            $power = model('Power');
            $arr2 = $power->where($where)->delete();
            if($arr2===false){
                $power->rollback();
                throw new \Exception('删除失败');
            }

            $role->commit();
            successfly('删除成功');
        }catch (\Exception $e){
            fail($e->getMessage());
        }

    }


    /** 获取所有节点信息*/
    public function getAllNode(){
        $node = model('Node');
        $nodeInfo = $node->where(['pid'=>0])->select();
        foreach($nodeInfo as $k=>$v){
            $where = [
                'pid' => $v['node_id'],
            ];
            $nodeInfo[$k]['son'] = $node->where($where)->select();
        }
        return $nodeInfo;
    }
}
?>

