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
									<div class="panel panel-default no-padding">\
										<div class="panel-body" style="min-height:120px">\
											<div class = "col-md-2 col-xs-4">\
												<div class="col-md-12 thumbnail no-margin-bottom">\
													<img src="photos/test2.jpg" class="img-rounded">\
												</div>\
												<div class="col-md-12 text-center">'+item.name+'\
												</div>\
											</div>\
											<div class = "col-md-10 col-xs-8">\
												<div class= "col-md-11">'+item.content+'</div>\
												<div class ="col-md-6" style="margin-top:50px;">'+item.time+'&nbsp;&nbsp;&nbsp;<a href="" >评论</a></div>\
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