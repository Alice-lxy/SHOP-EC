<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpStudy\WWW\month11\shop\public/../application/index\view\exam\search.html";i:1543377706;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div class="search">
	    <input type="text" class="search_name" search_name = "search_name"/>
	    <button class="btn">搜索</button>
	</div>
	<ul class="hidden">
		<li>123</li>	
	</ul>
	1<a href="<?php echo url('Login/quit'); ?>">退出</a>
</body>
</html>
<script src="__STATIC__/index/login/jquery-3.2.1.min.js"></script>
<script>
	$(function(){
		//添加
		$('.btn').click(function(){
			var search_name = $('.search_name').val();
			$.post(
				"<?php echo url('exam/add'); ?>",
				{search_name:search_name},
				function(result){
					console.log(result);
				}
				,'json'
			);
		});
		var hidden = $('.hidden');

		var data = localStorage.getItem('search');
		console.log(data);
		//将数据转化为数组格式
		data = data?JSON.parse(data):[];
		//
		var search_name = $('.search_name').val();
		search_name.onkeyup = function(){
			var search_name = $('.search_name').val();
			var html='';
			for(var i=0;i<data.length;i++){
				var reg = new RegExp(txt);
				var index = data[i].search(reg);
				if(index!=-1){
					html+='<li>'+data[i]+'</li>';
				}
			}
			hidden.text('html');
			hidden.className = 'show';
		}
		$('.hidden').click(function(Index){
			var li = Index.target;

			var title = li.innerHTML;

			
		})
		


	})
</script>