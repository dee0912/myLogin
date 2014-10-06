$(function(){

/*********************正确参数**************************/
//栏目填写正确时则把相应参数设置为true
var nameval,emailval,pwdval,rpwdval,yzmval,fuwuval = 0;

/*********************说明文字**************************/

	//显示提示信息,参数showMsg表示添加文字的元素,noticeMsg表示文字内容
	function notice(showMsg,noticeMsg){
			
		showMsg.html(noticeMsg).attr("class","notice");
	}

	//显示错误信息
	function error(showMsg,errorMsg){
	
		showMsg.html(errorMsg).attr("class","error");
	}
	
	//显示正确信息
	function success(showMsg,successMsg){
	
		showMsg.html(successMsg).css("height","20px").attr("class","success");
	}

/******************************************************/

	//计算字符长度
	function countLen(value){
	
		var len = 0; 
		for (var i = 0; i < value.length; i++) { 

		/*  [^\x00-\xff] 匹配双字节字符(包括汉字在内),
		**  可以用来计算字符串的长度,
		**  一个双字节字符长度计2，ASCII字符计1
		*/
		if (value[i].match(/[^\x00-\xff]/ig) != null) 
			len += 2; 
		else 
			len += 1; 
		} 

		return len;
	}

/************************用户名*******************************/


	//检测用户名长度
	function unameLen(value){
	
		var showMsg = $("#unamechk");

		/* (strlen($str)+mb_strlen($str))/2 可得出限制字符长度的上限,
		*  例如:$str为7个汉字:"博客园记录生活",利用上面的语句可得出14,
		*  同样,14个英文,利用上面的语句同样能得出字符长度为14
		*/
		if(countLen(value) > 14){
						
			var errorMsg = '用户名长度不能超过14个英文或7个汉字';
			error(showMsg,errorMsg);		
		}else if(countLen(value) == 0){
		
			var noticeMsg = '用户名不能为空';
			notice(showMsg,noticeMsg);
		}else{

			var successMsg = '长度符合要求';
			success(showMsg,successMsg);
		}

		return countLen(value);
	}

	//用户名
	unameLen($("#uname").val());
	
	$("#uname").focus(function(){
	
					var noticeMsg = '中英文均可，最长为14个英文或7个汉字';
					notice($("#unamechk"),noticeMsg);
				})
			   .click(function(){
					
					var noticeMsg = '中英文均可，最长为14个英文或7个汉字';
					notice($("#unamechk"),noticeMsg);
				})
			   .keyup(function(){
	
					unameLen(this.value);
				}).keydown(function(){
				
					//把焦点移至邮箱栏目
					if(event.keyCode == 13){
						
						$("#uemail").focus();
					}
				})
				.blur(function(){
				
					if($("#uname").val()!="" && unameLen(this.value)<=14 && unameLen(this.value)>0){
						//检测中
						$("#unamechk").html("检测中...").attr("class","loading");
						//ajax查询用户名是否被注册
						$.post("./../chkname.php",{
						
							//要传递的数据
							uname : $("#uname").val()
						},function(data,textStatus){
							
							if(data == 0){
							
								var successMsg = '恭喜，该用户名可以注册';
								$("#unamechk").html(successMsg).attr("class","success");

								//设置参数
								nameval = true;
							}else if(data == 1){
							
								var errorMsg = '该用户名已被注册';
								error($("#unamechk"),errorMsg);
							}else{
							
								var errorMsg = '查询出错,请联系网站管理员';
								error($("#unamechk"),errorMsg);
							}
						});
					}else if(unameLen(this.value)>14){
					
						var errorMsg = '用户名长度不能超过14个英文或7个汉字';
						error($("#unamechk"),errorMsg);
					}else{
					
						var errorMsg = '用户名不能为空';
						error($("#unamechk"),errorMsg);
					}
				});

	//加载后即获得焦点
	$("#uname").focus();

/*************************邮箱*******************************/
		
	//邮箱下拉js单独引用emailup.js
	$("#uemail").focus(function(){
	
					var noticeMsg = '用来登陆网站，接收到激活邮件才能完成注册';
					notice($("#uemailchk"),noticeMsg);
				})
				.click(function(){
	
					var noticeMsg = '用来登陆网站，接收到激活邮件才能完成注册';
					notice($("#uemailchk"),noticeMsg);
				})
				.blur(function(){
				
					if(this.value!="" && this.value.match(/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/)!=null){
					
						//检测是否被注册
						$("#uemailchk").html("检测中...").attr("class","loading");
						//ajax查询用户名是否被注册
						$.post("./../chkemail.php",{
						
							//要传递的数据
							uemail : $("#uemail").val()
						},function(data,textStatus){
							
							if(data == 0){
							
								var successMsg = '恭喜，该邮箱可以注册';
								$("#uemailchk").html(successMsg).attr("class","success");

								emailval = true;
							}else if(data == 1){
							
								var errorMsg = '该邮箱已被注册';
								error($("#uemailchk"),errorMsg);
							}else{
							
								var errorMsg = '查询出错,请联系网站管理员';
								error($("#uemailchk"),errorMsg);
							}
						});
					}else if(this.value == ""){
					
						var errorMsg = '邮箱不能为空';
						error($("#uemailchk"),errorMsg);
					}else{
					
						var errorMsg = '请填写正确的邮箱地址';
						$("#uemailchk").html(errorMsg).attr("class","error");
					}
				});

				
/***************************密码*****************************/

	function noticeEasy(){
	
		//密码全部为相同字符或者为123456,用于keyup时的notice
		var noticeMsg = '密码太简单，请尝试数字、字母和下划线的组合';
		return notice($("#upwdchk"),noticeMsg);
	}

	function errorEasy(){
	
		//密码全部为相同字符或者为123456,用于blur时的error
		var errorMsg = '密码太简单，请尝试数字、字母和下划线的组合';
		return error($("#upwdchk"),errorMsg);
	}
	
	//检测密码长度函数
	//检测密码长度
	function upwdLen(value,func){
	
		var showMsg = $("#upwdchk");

		if(countLen(value) > 16){
						
			var errorMsg = '密码不能超过16个字符';
			error(showMsg,errorMsg);
			
			$("#pictie").hide();
		}else if(countLen(value) < 6){
		
			//使用notice更加友好
			var noticeMsg = '密码不能少于6个字符';
			notice(showMsg,noticeMsg);

			$("#pictie").hide();
		}else if(countLen(value) == 0){
		
			//使用notice更加友好
			var noticeMsg = '密码不能为空';
			notice(showMsg,noticeMsg);

			$("#pictie").hide();
		}else{
		
			upwdStrong(value,func);//如果长度不成问题,则调用检测密码强弱
		}

		return countLen(value);//返回字符长度
	}

	//检测密码强弱
	function upwdStrong(value,func){
	
		var showMsg = $("#upwdchk");

		if(value.match(/^(.)\1*$/)!=null || value.match(/^123456$/)){
		
			//密码全部为相同字符或者为123456，调用函数noticeEasy或errorEasy
			func;
		}else if(value.match(/^[A-Za-z]+$/)!=null || value.match(/^\d+$/)!=null || value.match(/^[^A-Za-z0-9]+$/)!=null){

			//全部为相同类型的字符为弱
			var successMsg = '弱：试试字母、数字、符号混搭';
			success(showMsg,successMsg);

			//插入强弱条
			$("#pictie").show().attr("src","templates/images/weak.jpg");

			pwdval = true;

		}else if(value.match(/^[^A-Za-z]+$/)!=null || value.match(/^[^0-9]+$/)!=null || value.match(/^[a-zA-Z0-9]+$/)!=null){
		
			//任意两种不同类型字符组合为中强( 数字+符号,字母+符号,数字+字母 )
			var successMsg = '中强：试试字母、数字、符号混搭';
			success(showMsg,successMsg);

			$("#pictie").show().attr("src","templates/images/normal.jpg");

			pwdval = true;
		}else{
		
			//数字、字母和符号混合
			var successMsg = '强：请牢记您的密码';
			success(showMsg,successMsg);

			$("#pictie").show().attr("src","templates/images/strong.jpg");

			pwdval = true;
		}
	}
	
	$upper = $("<div id=\"upper\">大写锁定已打开</div>");
	
	$("#upwd").focus(function(){
	
					var noticeMsg = '6到16个字符，区分大小写';
					notice($("#upwdchk"),noticeMsg);

					$("#pictie").hide();
			})
			 .click(function(){
			
					var noticeMsg = '6到16个字符，区分大小写';
					notice($("#upwdchk"),noticeMsg);

					$("#pictie").hide();
			}).keydown(function(){
			
					//把焦点移至邮箱栏目
					if(event.keyCode == 13){
						
						$("#rupwd").focus();
					}
			})
			 .keyup(function(){
			 
					//判断大写是否开启
					//输入密码的长度
					var len = this.value.length;					
					if(len!=0){

						//当输入的最新以为含有大写字母时说明开启了大写锁定
						if(this.value[len-1].match(/[A-Z]/)!=null){
						
							//给出提示
							$upper.insertAfter($(".upwdpic"));
						}else{
						
							//移除提示
							$upper.remove();
						}
					}else{
					
						//当密码框为空时移除提示
						if($upper){
						
							$upper.remove();
						}
					}//判断大写开启结束
			
					//判断长度及强弱
					upwdLen(this.value,noticeEasy());	
			 })
			 //keyup事件结束
			   .blur(function(){
			   
					upwdLen(this.value,errorEasy());
					//upwdLen函数中部分提示使用notice是为了keyup事件中不出现红色提示,而blur事件中则需使用error标红
					if(this.value == ""){
					
						var errorMsg = '密码不能为空';
						error($("#upwdchk"),errorMsg);

						$("#pictie").hide();
					}else if(countLen(this.value)<6){
					
						var errorMsg = '密码不能少于6个字符';
						error($("#upwdchk"),errorMsg);

						$("#pictie").hide();
					}
			 });

/***************************重复密码*****************************/
	
	$("#rupwd").focus(function(){
	
					var noticeMsg = '再次输入你设置的密码';
					notice($("#rupwdchk"),noticeMsg);
			})
			   .click(function(){
			
					var noticeMsg = '再次输入你设置的密码';
					notice($("#rupwdchk"),noticeMsg);
			}).keydown(function(){
			
					//把焦点移至邮箱栏目
					if(event.keyCode == 13){
						
						$("#yzm").focus();
					}
			})
				.blur(function(){
			
					if(this.value == $("#upwd").val() && this.value!=""){
					
						success($("#rupwdchk"),"");

						rpwdval = true;
					}else if(this.value == ""){
					
						$("#rupwdchk").html("");
					}else{
					
						var errorMsg = '两次输入的密码不一致';
						error($("#rupwdchk"),errorMsg);
					}
			});

/******************************验证码********************************/
		
		//验证码按钮
		$("#refpic").hover(function(){
		
			$(this).attr("src","templates/images/refhover.jpg");
		},function(){
		
			$(this).attr("src","templates/images/ref.jpg");
		}).mousedown(function(){
		
			$(this).attr("src","templates/images/refclick.jpg");
		}).mouseup(function(){
		
			$(this).attr("src","templates/images/ref.jpg");
		});
		

		//刷新验证码
		function postyzm(){
		
			$.post("./../refresh.php",function(data,textStatus){
			
				$('#yzmpic').attr("src","valcode.php?num="+data);
			})
		}

		$('#yzmpic').click(function(){
		
			postyzm();
		});

		 $('#changea').click(function(){
		
			postyzm();
		});

		//验证码检验
		function yzmchk(){
				
			$.post("./../chkyzm.php",{
						
				//要传递的数据
				yzm : $("#yzm").val()
			},function(data,textStatus){
				
				if(data == 0){
				
					success($("#yzmchk"),"");
					yzmval = true;
				}else if(data == 1){
				
					var noticeMsg = '验证码不能为空';
					notice($("#yzmchk"),noticeMsg);
				}else{
				
					var errorMsg = '请输入正确的验证码';
					error($("#yzmchk"),errorMsg);
				}
			});
			
		}

		//验证码的blur事件
		$("#yzm").focus(function(){
		
			var noticeMsg = '不区分大小写';
			notice($("#yzmchk"),noticeMsg);
		}).click(function(){
		
			var noticeMsg = '不区分大小写';
			notice($("yzmdchk"),noticeMsg);
		}).keydown(function(){
			
			if(event.keyCode == 13){				
				
				//检验
				yzmchk();
			}
		}).keyup(function(){
		
			if(event.keyCode == 13){				
				
				//提交
				formsub();
			}
		}).blur(function(){
		
			yzmchk();
		});
/**********************服务条款****************************/
	if($("#agree").prop("checked") == true){
	
		fuwuval = true;
	}

	$("#agree").click(function(){
	
		if($("#agree").prop("checked") == true){

			fuwuval = true;
			$("#sub").css("background","#69b3f2");
		}else{
		
			$("#sub").css({"background":"#f2f2f2","cursor":"default"});
		}	
	});

/**********************提交按钮****************************/
	
	function formsub(){
	
		if(nameval != true || emailval!=true || pwdval!=true || rpwdval!=true || yzmval!=true || fuwuval!=true){
		
			//当邮箱有下拉菜单时点击提交按钮时不会自动收回菜单，因为下面的return false，所以在return false之前判断下拉菜单是否弹出
			if(nameval != true && $("#unamechk").val()!=""){
			
				var errorMsg = '请输入用户名';
				error($("#namechk"),errorMsg);
			}

			if($(".autoul").show()){
			
				$(".autoul").hide();
			}

			//以下是不会自动获得焦点的栏目如果为空时，点击注册按钮给出错误提示
			if($("#uemail").val() == ""){
			
				var errorMsg = '邮箱不能为空';
				error($("#uemailchk"),errorMsg);		
			}

			if($("#upwd").val() == ""){
			
				var errorMsg = '密码不能为空';
				error($("#upwdchk"),errorMsg);		
			}

			if($("#rupwd").val() == ""){
			
				var errorMsg = '请再次输入你的密码';
				error($("#rupwdchk"),errorMsg);		
			}

			if($("#yzm").val() == ""){
			
				var errorMsg = '验证码不能为空';
				error($("#yzmchk"),errorMsg);		
			}

		}else{
		
			$("#register-form").submit();
		}
	}

	$("#sub").click(function(){
		
		formsub();
	});

/*$(function)结束*/
});



