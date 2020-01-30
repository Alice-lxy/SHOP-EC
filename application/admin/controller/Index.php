<?php
namespace app\admin\controller;
// use think\Controller;

class Index extends Common
{
    /** 后台首页 */
    public function index()
    {	
    	$session = session('adminInfo');
    	$admin_name = $session['admin_name'];
    	$this->assign('admin_name',$admin_name);
    	return view();
    }
}
?>
