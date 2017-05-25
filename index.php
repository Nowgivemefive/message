<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>留言板</title>

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
		include_once("php/dbcon.php");
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
          <a class="navbar-brand" href="#">留言板</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
			<?php
				if(!isset($_SESSION['name'])){
					echo "<li><a href=\"login.html\">登录</a></li>";
					echo "<li><a href=\"register.html\">注册<span class=\"sr-only\">(current)</span></a></li>";
				}else{
					echo "<li><a href=\"#\">欢迎, ".$_SESSION['name']."</a></li>";
					echo "<li><a href=\"register.html\">个人中心<span class=\"sr-only\">(current)</span></a></li>";
					echo "<li><a href=\"php/logout.php\">退出<span class=\"sr-only\">(current)</span></a></li>";
				}
			?>
            
          </ul>
        </div>
      </div>
    </nav>
	<div class="container">
		<div class="row">
			<!--遍历留言-->
			<div class="col-md-6 col-md-offset-1">
				<div class="col-md-12" id = "showmessage">
				<!--此处显示留言-->
				</div>
				<div class="col-md-12 center" id = "showpagebtn">
				<!--此处显示翻页按钮-->
				</div>
			</div>
			<!--发布留言-->
			<div class = "col-md-5"> 
				<form class="form">
				  <div class="form-group">
					<label for="subject_mess">主题</label>
					<input type="text" name = "subject" class="form-control" id="subject_mess" placeholder="主题">
				  </div>
				  <div class="form-group">
				  <label for="mcontent">内容</label>
				  <textarea id = "content_mess"name = "content" class="form-control" rows="3" placeholder= "内容"></textarea>
				  </div>
				  <div class="form-group">
					<?php if(isset($_SESSION['name'])){ ?>
					<a class="btn btn-lg btn-success btn-block" id = "send_mess">发布留言</a>
					<?php }else{ ?>
					<a  class="btn btn-lg btn-success btn-block" id = "send_mess">匿名发布</a>
					<?php } ?>
				  </div>
				   <div class="form-group text-center">
						<p class="bg-success">留言成功</p>
				  </div>
				</form>
			</div>
			
			
		</div>
		
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script>
		/*
		*	function 
		*/
		
		/*
		*	获取JSON数据，并显示留言
		*/
		function getMessData(select_num){
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
									<div class="panel panel-default">\
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
											<div class= \"col-md-11 col-md-offset-1\">'+item.content+'</div>\
									  </div>\
									</div>\
								') //end of append
							} //end of if 
					}) //end of each 
					$("#showpagebtn").append(btn_html);	
			});	//end of ajax post
		} //end of function getMessData
		
		/*
		*	初始
		*/
		$(document).ready(initLoad());		
		function initLoad(){
			getMessData(1);
		}
		/*
		*	翻页
		*/
		$("#showpagebtn").on("click",".pagebtn",function(){
			var page_num = $(this).html();
			$("#showmessage").empty();
			$("#showpagebtn").empty();
			getMessData(page_num);
		})//end of pagebtn
		
		
		/*
		*	发布留言
		*/
		$("#send_mess").click(function(){
			var subject = $("#subject_mess").val();
			var content = $("#content_mess").val();
			var mess = {
				 subject_mess:subject,
				 content_mess:content
				 };
			 $.post("php/insert_message.php",{
				 message:mess
				 },
			  function(data){
				console.log("Send message success\n"+data);
			  },
			  "text");//这里返回的类型有：json,html,xml,text
			}
		)

		
		
		
		
		
		
		
		
		
		
	</script>
  </body>
</html>