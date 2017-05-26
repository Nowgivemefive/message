﻿<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>用户中心</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<?php
		session_start();
	?>
	<nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">留言板</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
			<?php
			echo "<li><a href=\"#\">欢迎, ".$_SESSION['name']."</a></li>"
			?>
			<li><a >个人中心<span class="sr-only">(current)</span></a></li>
			<li><a href="php/logout.php">退出<span class="sr-only">(current)</span></a></li>
            
          </ul>
        </div>
      </div>
    </nav>
	<div class="container-fluid">
		<div class="row">
				<div class = "col-md-3 sidebar">
					<ul class="nav nav-sidebar">
						<li ><a href="#" class="active menu"func = "1">留言管理 </a></li>
						<li><a href="#" class= "menu" func = "2">用户管理</a></li>
						<li><a href="#" class = "menu" func = "3">我的留言</a></li>
						<li class="active" class = "menu"><a href="#" func="4">数据统计</a></li>
					  </ul>
				</div>
				<div class = "col-md-8 col-md-offset-1">
					<div class="col-md-12" id = "showmessage">
					<!--此处显示-->
					</div>
					<div class="col-md-12 " id = "showpagebtn">
					<!--此处显示翻页按钮-->
					</div>
				</div>
		
		</div>
		
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script>
		var current_func;
		function getMessData(select_num){
			$("#showmessage").empty();
			$("#showpagebtn").empty();
			$.post("php/page.php",{
				select_num:select_num
				},function(data){
					var data = eval(data);
					var page_num = data[0].page_num;
					var li_html = '';
					for( var i = 1; i <= page_num; i++){
						li_html += '<li><a class = "pagebtn" >'+i+'</a></li>';
					}
					var btn_html ='<nav aria-label="Page navigation">\
									  <ul class="pagination">\
										<li>\
										  <a href="#" aria-label="Previous">\
											<span aria-hidden="true">&laquo;</span>\
										  </a>\
										</li>'+li_html+'<li>\
										  <a href="#" aria-label="Next">\
											<span aria-hidden="true">&raquo;</span>\
										  </a>\
										</li>\
									  </ul>\
									</nav>'
							
					$.each(data,function(i,item){
							/*
							*	遍历留言内容
							*/
							if(i > 0){
								$("#showmessage").append('\
									<div class="panel panel-default amessage">\
									  <div class="panel-heading">\
										<h3 class="panel-title">\
											<div class ="row">\
												<div class ="col-md-6">'+i+'. 主题:'+item.subject+'</div>\
												<div class ="col-md-5 col-md-offset-1">时间:'+item.time+'</div>\
											</div>\
										</h3>\
									  </div>\
									  <div class="panel-body">\
											By '+item.name+': <br/>\
											<div class= \"col-md-11 col-md-offset-1\">'+item.content+'\
											<div class ="col-md-1 pull-right" >\
												<button type="button" class="btn btn-danger del_btn" mid='+item.mid+'>删除</button>\
											</div>\
											</div>\
									  </div>\
									</div>\
								') //end of append
							} //end of if 
					}) //end of each 
					$("#showpagebtn").append(btn_html);	
			});	//end of ajax post
		} //end of function getMessData
		/*
		*	翻页
		*/
		$("#showpagebtn").on("click",".pagebtn",function(){
			var page_num = $(this).html();
			$("#showmessage").empty();
			$("#showpagebtn").empty();
			if(current_func == 1){
				getMessData(page_num);
			}else if(current_func == 2){
				printUser(page_num);
			}
		})//end of pagebtn
		/*
		*	初始
		*/
		$(document).ready(initLoad());		
		function initLoad(){
			getMessData(1);
		}
		/*
		*	删除留言
		*/
		$("#showmessage").on("click",".del_btn",function(){
			var mid = $(this).attr("mid");
			$.post("php/delete.php",{
				mid:mid
			},function(data){
				console.log(data);
			})
			$(this).parents(".amessage").remove();
		})//end of pagebtn
		/*
		*	显示用户
		*/
		function printUser(select){
			$("#showmessage").empty();
			$("#showpagebtn").empty();
			$.post("php/userMana.php",{
				select_num:select
			},function(data){
				console.log(data);
				var data = eval(data); 
				console.log(data);
				var page_num = data[0].page_num;
					var li_html = '';
					for( var i = 1; i <= page_num; i++){
						li_html += '<li><a class = "pagebtn" >'+i+'</a></li>';
					}
					var btn_html ='<nav aria-label="Page navigation">\
									  <ul class="pagination">\
										<li>\
										  <a href="#" aria-label="Previous">\
											<span aria-hidden="true">&laquo;</span>\
										  </a>\
										</li>'+li_html+'<li>\
										  <a href="#" aria-label="Next">\
											<span aria-hidden="true">&raquo;</span>\
										  </a>\
										</li>\
									  </ul>\
									</nav>';
				var td_html = '';	
				$.each(data,function(i,item){
					if(i > 0){
						td_html += '<tr>\
									  <th scope="row">'+item.uid+'</th>\
									  <td>'+item.name+'</td>\
									  <td>'+item.authority+'</td>\
									  <td>'+item.sex+'</td>\
									  <td>'+item.create_time+'</td>\
									</tr>';
					}
				}) //end of each
				$("#showpagebtn").append(btn_html);
				var user_html = '<table class="table table-hover">\
								  <thead>\
									<tr>\
									  <th>Uid</th>\
									  <th>姓名</th>\
									  <th>权限</th>\
									  <th>sex</th>\
									  <th>创建时间</th>\
									</tr>\
								  </thead>\
								  <tbody>';
				user_html += td_html;
				user_html += ' </tbody></table>'
				$('#showmessage').append(user_html);
			})
		}
		/*
		*	菜单选项
		*/
		$(".menu").click(function(){
			var func = $(this).attr("func");
			if(func == 1){
				getMessData(1);
				current_func = 1;
			}else if(func == 2){
				printUser(1);
				current_func = 2;
			}
		})
		/*
		*	删除用户
		*/
		
	</script>
  </body>
</html>