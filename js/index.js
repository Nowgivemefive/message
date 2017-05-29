		/*
		*	function 
		*/
		
		/*
		*	获取JSON数据，并显示留言
		*/
		function getMessData(select_func,select_num){
			$.post("php/page.php",{
				select_num:select_num,
				select_func:1
				},function(data){
					var data = eval(data);
					var page_num = data[0].page_num;
					var li_html = '';
					for( var i = 1; i <= page_num; i++){
						li_html += '<li><a class = "pagebtn" >'+i+'</a></li>';
					}
					var btn_html ='<nav aria-label="Page navigation">\
									  <ul class="pagination">'+li_html+'</ul>\
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
												<div class ="col-md-6">'+item.name+'</div>\
											</div>\
										</h3>\
									  </div>\
									  <div class="panel-body" style="height:120px">\
											<div class= "col-md-11 col-md-offset-1">'+item.content+'\
											</div>\
									  </div>\
									  <div class="panel-footer">'+item.time+'\
									  <div class="col-md-4 pull-right">\
											<a class= "praiseBtn"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>(66) </a>\
											<a href="" >查看评论(12)</a>\
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
		*	初始
		*/
		$(document).ready(initLoad());		
		function initLoad(){
			getMessData(1,1);
		}
		/*
		*	翻页
		*/
		$("#showpagebtn").on("click",".pagebtn",function(){
			var page_num = $(this).html();
			$("#showmessage").empty();
			$("#showpagebtn").empty();
			getMessData(1,page_num);
		})//end of pagebtn
		
		/*
		*	点赞 praise
		*/
		var num = 0;
		$(".showmessage").on("click",".praiseBtn",function(){
			alert("OK");
			comsole.log(num++);
		});
		/*
		*	发布留言
		*/
		$("#send_mess").click(function(){
			var temp = 1;
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
				$(".messInfo").fadeIn(1500);
				$(".messInfo").fadeOut(1500);
				$("#showmessage").empty();
				$("#showpagebtn").empty();
				$("#subject_mess").val("");
				$("#content_mess").val("");
				getMessData(1,1);
			  },
			  "text");
			}
		)