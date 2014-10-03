$(function(){
	
	//邮箱地址
	function mailaddr(mail){
					
		if(!mail.split("@")[1]){
		
			alert("参数错误");
			return false;
		}

		var mail = mail.split("@");
		
		mail = mail[1].toLowerCase();
		
		//与常用邮箱进行对比
		if(mail == "qq.com" || mail == "vip.qq.com" || mail == "foxmail.com"){
		
			return  'mail.qq.com';
		}else if(mail == '163.com'){

            return 'mail.163.com';
		}else if(mail == 'vip.163.com'){
			
            return 'vip.163.com';
		}else if(mail == '126.com'){

            return'mail.126.com';
		}else if(mail == 'gmail.com'){

            return'mail.google.com';
		}else if(mail == 'sohu.com'){

            return'mail.sohu.com';
		}else if(mail == 'tom.com'){

            return'mail.tom.com';
		}else if(mail == 'vip.sina.com'){

            return'vip.sina.com';
		}else if(mail == 'sina.com.cn' || mail == 'sina.com'){

            return'mail.sina.com.cn';
		}else if(mail == 'tom.com'){

            return'mail.tom.com';
		}else if(mail == 'yahoo.com.cn' || mail == 'yahoo.cn'){

            return'mail.cn.yahoo.com';
		}else if(mail == 'tom.com'){

            return'mail.tom.com';
		}else if(mail == 'yeah.net'){

            return'www.yeah.net';
		}else if(mail == '21cn.com'){

            return'mail.21cn.com';
		}else if(mail == 'hotmail.com'){

            return'www.hotmail.com';
		}else if(mail == 'sogou.com'){

            return'mail.sogou.com';
		}else if(mail == '188.com'){

            return'www.188.com';
		}else if(mail == '139.com'){

            return'mail.10086.cn';
		}else if(mail == '189.cn'){

            return'webmail15.189.cn/webmail';
		}else if(mail == 'wo.com.cn'){

            return'mail.wo.com.cn/smsmail';
		}else if(mail == '139.com'){

            return'mail.10086.cn';
        }else{
            
			return'';
        }		
	}

	var uemailaddr = $("#mailaddr").text();
	
	if(mailaddr(uemailaddr) == ""){
	
		$("#maillogin").remove();
		//控制样式
		$(".ftit2").css("top","110px");
		$(".notice").css("bottom","-120px");
		$("#mailaddr").click(function(){
		
			return false;
		});
	}else{
	
		$("#mailaddr").attr("href","http://"+mailaddr(uemailaddr));
		$("#maillogin a").attr("href","http://"+mailaddr(uemailaddr));
	}
})