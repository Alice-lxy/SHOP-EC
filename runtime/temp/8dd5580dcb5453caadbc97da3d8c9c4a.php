<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpStudy\WWW\month11\shop\public/../application/index\view\login\register.html";i:1543486473;}*/ ?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title>注册</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />

	<link rel="stylesheet" href="__STATIC__/index/login/amazeui.css" />
	<link href="__STATIC__/index/login/dlstyle.css" rel="stylesheet" type="text/css">
	<link href="__STATIC__/layui/css/layui.css" rel="stylesheet" type="text/css">

	<script src="__STATIC__/layui/layui.js"></script>
	<script src="__STATIC__/index/login/jquery-3.2.1.min.js"></script>
	<script src="__STATIC__/index/login/amazeui.min.js"></script>
</head>

<body>
	
	<div class="login-boxtitle">
		<a href="home/demo.html"><img alt="" src="__STATIC__/index/login/logobig.png" /></a>
	</div>

	<div class="res-banner">
		<div class="res-main">
			<div class="login-banner-bg"><span></span><img src="__STATIC__/index/login/big.jpg" /></div>
			<div class="login-box">

					<div class="am-tabs" id="doc-my-tabs">
						<ul class="am-tabs-nav am-nav am-nav-tabs am-nav-justify">
							<li class="am-active"><a href="">邮箱注册</a></li>
							<li><a href="">手机号注册</a></li>
						</ul>

						<div class="am-tabs-bd">
							<!--邮箱注册-->
							<div class="am-tab-panel am-active">
								<form method="post" class="layui-form">

									<div class="user-email">
										<label for="user_email"><i class="am-icon-envelope-o"></i></label>
										<input type="email" name="user_email"  lay-verify="required|email"  id="user_email" placeholder="请输入邮箱账号"> <!----> 
									</div>
									<div class="verification">
										<label for="email_code"><i class="am-icon-code-fork"></i></label>
										<input type="text" name="user_code" id="email_code"  lay-verify="required" placeholder="请输入验证码"><!--  -->
										<a class="btn" href="javascript:void(0);"  id="sendEmailCode">
											<span class="dyButton" id="span_email">获取</span>
										</a>
									</div>
									<div class="user-pass">
										<label for="email_pwd"><i class="am-icon-lock"></i></label>
										<input type="password" name="user_pwd" id="email_pwd"  placeholder="设置密码"><!-- lay-verify="required|checkpwd1" -->
									</div>
									<div class="user-pass">
										<label for="email_pwd1"><i class="am-icon-lock"></i></label>
										<input type="password" name="user_pwd1" id="email_pwd1"  placeholder="确认密码"><!--  lay-verify="required|checkpwd2" -->
									</div>
									<div class="am-cf">
										<input type="button" lay-submit lay-filter="EmailDemo" value="注册" class="am-btn am-btn-primary am-btn-sm am-fl">
									</div>
								</form>
							</div>
							<!--手机号注册-->
							<div class="am-tab-panel">
								<form method="post" class="layui-form">
									<div class="user-phone">
										<label for="tel"><i class="am-icon-mobile-phone am-icon-md"></i></label>
										<input type="tel" name="user_tel" lay-verify="required|phone"  id="user_tel" placeholder="请输入手机号">
									</div>
									<div class="verification">
										<label for="tel_code"><i class="am-icon-code-fork"></i></label>
										<input type="tel" name="user_code" lay-verify="required" id="tel_code" placeholder="请输入验证码">
										<a class="btn" href="javascript:void(0);" id="sendTelCode">
											<span class="dyButton" id="span_tel">获取</span>
										</a>
									</div>
									<div class="user-pass">
										<label for="tel_pwd"><i class="am-icon-lock"></i></label>
										<input type="password" name="user_pwd" lay-verify="required|checkPwd1" id="tel_pwd" placeholder="设置密码">
									</div>
									<div class="user-pass">
										<label for="tel_pwd1"><i class="am-icon-lock"></i></label>
										<input type="password" name="user_pwd1"  lay-verify="required|checkPwd2" id="tel_pwd1" placeholder="确认密码">
									</div>
									<div class="am-cf">
										<input type="button" lay-submit lay-filter="telDemo" value="注册" class="am-btn am-btn-primary am-btn-sm am-fl">
									</div>
								</form>
							</div>
							<script>
								$(function() {
								    $('#doc-my-tabs').tabs();
								  })
							</script>
						</div>
					</div>

			</div>
		</div>
		
		<div class="footer ">
			<div class="footer-hd ">
				<p>
					<a href="# ">恒望科技</a>
					<b>|</b>
					<a href="# ">商城首页</a>
					<b>|</b>
					<a href="# ">支付宝</a>
					<b>|</b>
					<a href="# ">物流</a>
				</p>
			</div>
			<div class="footer-bd ">
				<p>
					<a href="# ">关于恒望</a>
					<a href="# ">合作伙伴</a>
					<a href="# ">联系我们</a>
					<a href="# ">网站地图</a>
					<em>© 2015-2025 Hengwang.com 版权所有. 更多模板 <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></em>
				</p>
			</div>
		</div>
	</div>
</body>
</html>

<script>
$(function(){
	layui.use(['layer','form'],function(){
		var layer = layui.layer;
		var form = layui.form;
		//点击获取  发送邮件
		$('#span_email').click(function(){
			var user_email = $('#user_email').val();
			var reg = /^\w+@\w+\.com$/;
			if(user_email==''){
				layer.msg('邮箱必填',{icon:3});
			}else if(!reg.test(user_email)){
				layer.msg('请输入正确格式的邮箱',{icon:3});
			}else{
				//倒计时
				$('#span_email').text("30s");
				_time = setInterval(emailTime,1000);

				$.post(
					"<?php echo url('Login/sendEmail'); ?>",
					{user_email:user_email},
					function(msg){
						layer.msg(msg.font,{icon:msg.code});
					}
					,'json'
				);
			}
		});	
		//邮件倒计时
		function emailTime(){
			var second = parseInt($('#span_email').text());
			if(second==0){
				$('#span_email').text("获取");
				clearInterval(_time);	
				$('#span_email').css('pointer-events','auto');
			}else{
				second = second-1;
				$('#span_email').text(second+'s');
				$('#span_email').css('pointer-events','none');
			}
		}
		//验证
		form.verify({
			checkpwd1:function(value,item){
				var reg=/^.{6,}$/;
				if(value==''){
					return '密码必填';
				}else if(!reg.test(value)){
					return '密码至少由六位组成';
				}
			},
			checkpwd2:function(value,item){
				var email_pwd = $('#email_pwd').val();
				if(value==''){
					return '确认密码必填';
				}else if(value!=email_pwd){
					return '确认密码必须与密码保持一致';
				}
			},
		});
		//表单提交
		form.on('submit(EmailDemo)',function(data){
			$.post(
				"<?php echo url('Login/register'); ?>",
				data.field,
				function(result){
					// console.log(result);
					layer.msg(result.font,{icon:result.code});
					if(result.code==1){
						location.href="<?php echo url('Index/index'); ?>";
					}
				}
				,'json'
			);
			return false;
		});

		//点击获取 发送短信
		$('#span_tel').click(function(){
			var user_tel = $('#user_tel').val();
			var reg = /^1[3-8]\d{9}$/;
			if(user_tel==''){
				layer.msg('手机号必填',{icon:0});
			}else if(!reg.test(user_tel)){
				layer.msg('请输入正确手机号格式',{icon:2});
			}else{
				

				$.post(
					"<?php echo url('Login/sendEmail'); ?>",
					{user_tel:user_tel},
					function(result){
						layer.msg(result.font,{icon:result.code});
						if(result.code==1){
							//倒计时
							$('#span_tel').text("30s");
							_time = setInterval(telTime,1000);
						}
					}
					,'json'
				);
			}
		})
		//发送短信倒计时
		function telTime(){
			var second = parseInt($('#span_tel').text());
			if(second==0){
				$('#span_tel').text('获取');
				clearInterval(_time);
				$('#span_tel').css('pointer-events','auto');
			}else{
				second=second-1;
				$('#span_tel').text(second+'s');
				$('#span_tel').css('pointer-events','none');
			}
		}
		//验证
		form.verify({
			checkpwd1:function(value,item){
				var reg=/^.{6,}$/;
				if(value==''){
					return '密码必填';
				}else if(!reg.test(value)){
					return '密码至少由六位组成';
				}
			},
			checkpwd2:function(value,item){
				var tel_pwd = $('#tel_pwd').val();
				if(value==''){
					return '确认密码必填';
				}else if(value!=tel_pwd){
					return '确认密码必须与密码保持一致';
				}
			},
		});
		//表单提交
		form.on('submit(telDemo)',function(data){
			$.post(
				"<?php echo url('Login/register'); ?>",
				data.field,
				function(result){
					layer.msg(result.font,{icon:result.code});
					if(result.code==1){
						location.href="<?php echo url('Index/index'); ?>";
					}
				}
				,'json'
			);
			return false;
		})
	});	
})
</script>
