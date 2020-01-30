<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
    /** 后台首页   登录*/
    public function login()
    {
    	if(checkRequest()){
    		$admin_name = input('post.admin_name');
    		$admin_pwd = input('post.admin_pwd');
    		$mycode = input('post.mycode');
    		if(empty($admin_name)){
    			fail('账号必填');
    		}
    		if(empty($admin_pwd)){
    			fail('密码必填');
    		}
    		if(empty($mycode)){
    			fail('验证码必填');
    		}else if(!captcha_check($mycode)){
    			fail('验证码错误');
    		};

    		$where = [
    			'admin_name' => $admin_name,
    		];
    		$res = model('Admin')->where($where)->find();
    		if(!empty($res)){
    			$salt = $res['salt'];
    			$pwd = createPwd($admin_pwd,$salt);
    			if($res['admin_pwd']==$pwd){
    				//存session用户信息
    				session('adminInfo',['admin_id'=>$res['admin_id'],'admin_name'=>$admin_name]);
    				//修改最后一次登录时间 登录IP地址
    				$updateInfo = [
    					'last_login_time' => time(),
    					'last_login_ip' => request()->ip(),
    				];
    				// dump($updateInfo);exit;
    				$updateWhere = [
    					'admin_id' => $res['admin_id'],
    				];
    				model('admin')->save($updateInfo,$updateWhere);
    				//提示登录成功
    				successfly('登录成功');
    			}else{
    				fail('账号或密码错误');
    			}
    		}else{
    			fail('账号或密码错误');
    		}


    	}else{
    		$this->view->engine->layout(false); 
	    	return view();
    	}	
    }
    /** 退出 */
    public function quit(){
        session('adminInfo', null);
        $this->redirect('login/login');
    }

}
?>
