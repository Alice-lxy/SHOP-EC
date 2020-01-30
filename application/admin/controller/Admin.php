<?php
namespace app\admin\controller;

class Admin extends Common
{
    /** 后台首页 */
    public function adminAdd(){
      	if(checkRequest()){
        		$data = input('post.');
        		//验证器
        		$validate = validate('admin');
        		if(!$validate->scene('add')->check($data)){
              fail($validate->getError());
        		}
            //入库
            $model = model('Admin');
            $result = $model->save($data);
            if($result){
              successfly('添加成功');
            }else{
              fail('添加失败');
            }
      	}else{
      		return view();
      	}
    }
    /*验证管理员姓名 唯一性验证*/
    public function checkName(){
      $admin_name = input('post.admin_name');
    	$type = input('post.type');
   		$admin = model('admin');
      if($type==1){
          $where = ['admin_name' =>$admin_name,];
      }else{
         $old_name = input('post.old_name');
         $where = "admin_name != '$old_name' and admin_name = '$admin_name'";
      }
   		
   		$arr = $admin->where($where)->find();
   		if($arr){
   			return 'no';
   		}else{
   			return 'ok';
   		}
    }
    /** 修改密码 */
    public function updatePwd(){
      if(checkRequest()){
        $old_pwd = input('post.old_pwd');
        $new_pwd1 = input('post.new_pwd1');
        $new_pwd2 = input('post.new_pwd2');
          //验证 旧密码
          if(empty($old_pwd)){
            fail('原密码必填');
          }else{
            $admin_id = session('adminInfo.admin_id');
            // echo $admin_id;exit; 
            $where=[
              'admin_id' => $admin_id,
            ];
            $res = model('Admin')->where($where)->find();//获取所在id的所有的值
            $admin_pwd = createPwd($old_pwd,$res['salt']);
            // echo $admin_pwd;exit;
            if($admin_pwd!=$res['admin_pwd']){
              fail('原密码错误');
            }
          }
          //新密码
          if(empty($new_pwd1)){
            fail('新密码必填');
          }else if(strlen($new_pwd1)<6){
            fail('新密码必须大于六位');
          }
          //确认密码
          if($new_pwd1!=$new_pwd2){
            fail('新密码必须与确认密码保持一致');
          }

          $dataInfo = [
            'admin_pwd' => createPwd($new_pwd1,$res['salt'])
          ];
          $arr = model('Admin')->where($where)->update($dataInfo);
          if($arr===false){
            fail('修改失败');
            
          }else{
            successfly('修改成功');
          }

      }else{
        return view();
      }
      
    }
    /*管理员列表展示*/
    public function adminList(){
      return view();
    }
    /*获取管理员数据*/
    public function getAdminInfo(){
      $page = input('get.page');
      $limit = input('get.limit');

        $model = model('Admin');
        $data = $model->page($page,$limit)->select();
        $count = $model->count();
        //dump($data);

        $info = ['code'=>0,'msg'=>'','count'=>$count,'data'=>$data];
        echo json_encode($info);
    }

    /*管理员 邮箱..电话 即点即改*/
    public function adminUpdate(){
      $data = input('post.');
      //拼接条件
      $where = [
        'admin_id'=>$data['admin_id']
      ];
      //设置数据
      $info=[
        $data['field']=>$data['value']
      ];
      //修改
      $res = model('Admin')->where($where)->update($info);
      if($res){
        successfly('修改成功'); 
      }else{
        fail('修改失败');
      }
    }
    /*管理员删除*/
    public function adminDel(){
      $admin_id = input('post.admin_id');
      $where = [
        'admin_id' => $admin_id,
      ];
      $res = model('Admin')->where($where)->delete();
      if($res){
        successfly('删除成功'); 
      }else{
        fail('删除失败');
      }
    }
    /*管理员修改*/
    public function adminUpd(){
      if(checkRequest()){
          $data = input('post.');
          //验证器
          $validate = validate('Admin');
            if(!$result=$validate->scene('edit')->check($data)){
              fail($validate->getError());
            }

          $where = [
            'admin_id'=>$data['admin_id'],
          ];

          $res = model('admin')->save($data,$where);
          //echo model('admin')->getLastSql();exit;
          if($res===false){
              fail('修改失败');
          }else{
              successfly('修改成功');
          }
      }else{
          $admin_id = input('get.admin_id');
          $where = [
            'admin_id' => $admin_id,
          ];
          $admin = model('Admin');
          $data = $admin->where($where)->find();
          $this->assign('data',$data);
          return view();
      }
    }

    /** 编辑角色*/
    public function giveRole(){
        if(checkRequest()){
            $data = input('post.');

            $insertDate = [];
            foreach($data['role_id'] as $k=>$v){
                $insertDate[]=[
                    'admin_id'=>$data['admin_id'],
                    'role_id'=>$v
                ];
            }
            $admin_role = model('AdminRole');
            $res = $admin_role->saveAll($insertDate);
            if($res){
                successfly('操作成功');
            }else{
                fail('操作失败');
            }
        }else{
            $admin_id = input('get.admin_id','');
            //查询所有角色信息
            $role = model('Role');
            $roleInfo = $role->select();

            //根据当前管理员所选角色id
            $admin_role = model('AdminRole');
            $where = [
                'admin_id'=>$admin_id,
            ];
            $adminInfo = $admin_role->where($where)->column('role_id');


            $this->assign('roleInfo',$roleInfo);
            $this->assign('admin_id',$admin_id);
            $this->assign('adminInfo',$adminInfo);
            return view();
        }
    }
}
?>
