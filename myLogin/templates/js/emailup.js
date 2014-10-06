$(function(){
	
	//初始化邮箱列表
    var mail = new Array("sina.com","126.com","163.com","gmail.com","qq.com","hotmail.com","sohu.com","139.com","189.cn","sina.cn");

    //把邮箱列表加入下拉
    for(var i=0;i<mail.length;i++){
    
        var $liElement = $("<li class=\"autoli\"><span class=\"ex\"></span><span class=\"at\">@</span><span class=\"step\">"+mail[i]+"</span></li>");

        $liElement.appendTo("ul.autoul");
    }

    //下拉菜单初始隐藏
    $(".autoul").hide();
	
	//在邮箱输入框输入字符
	$("#uemail").keyup(function(){
	 
		if(event.keyCode!=38 && event.keyCode!=40 && event.keyCode!=13){

            //菜单展现，需要排除空格开头和"@"开头
            if( $.trim($(this).val())!="" && $.trim(this.value).match(/^@/)==null ) {

                $(".autoul").show();
				//修改
				$(".autoul li").show();

                //同时去掉原先的高亮，把第一条提示高亮
                if($(".autoul li.lihover").hasClass("lihover")) {
                    $(".autoul li.lihover").removeClass("lihover");
                }
                $(".autoul li:visible:eq(0)").addClass("lihover");
            }else{//如果为空或者"@"开头
                $(".autoul").hide();
                $(".autoul li:eq(0)").removeClass("lihover");
            }

            //把输入的字符填充进提示，有两种情况：1.出现"@"之前，把"@"之前的字符进行填充；2.出现第一次"@"时以及"@"之后还有字符时，不填充
            //出现@之前
            if($.trim(this.value).match(/[^@]@/)==null){//输入了不含"@"的字符或者"@"开头
                if($.trim(this.value).match(/^@/)==null){

                    //不以"@"开头
					//这里要根据实际html情况进行修改
                    $(this).siblings("ul").children("li").children(".ex").text($(this).val());
                }
            }else{

                //输入字符后，第一次出现了不在首位的"@"
                //当首次出现@之后，有2种情况：1.继续输入；2.没有继续输入
                //当继续输入时
                var str = this.value;//输入的所有字符
                var strs = new Array();
                strs = str.split("@");//输入的所有字符以"@"分隔
                $(".ex").text(strs[0]);//"@"之前输入的内容
                var len = strs[0].length;//"@"之前输入内容的长度
                if(this.value.length>len+1){

                    //截取出@之后的字符串,@之前字符串的长度加@的长度,从第(len+1)位开始截取
                    var strright = str.substr(len+1);

                    //正则屏蔽匹配反斜杠"\"
                    if(strright.match(/[\\]/)!=null){
                        strright.replace(/[\\]/,"");
                        return false;
                    }
                 
					//遍历li
                    $("ul.autoul li").each(function(){

                        //遍历span
                        //$(this) li
                        $(this).children("span.step").each(function(){

                            //@之后的字符串与邮件后缀进行比较
                            //当输入的字符和下拉中邮件后缀匹配并且出现在第一位出现
                            //$(this) span.step
                            if($("ul.autoul li").children("span.step").text().match(strright)!=null && $(this).text().indexOf(strright)==0){
								
								//class showli是输入框@后的字符和邮件列表对比匹配后给匹配的邮件li加上的属性
                                $(this).parent().addClass("showli");
                                //如果输入的字符和提示菜单完全匹配，则去掉高亮和showli，同时提示隐藏
								
								if(strright.length>=$(this).text().length){
										
                                    $(this).parent().removeClass("showli").removeClass("lihover").hide();
                                }
                            }else{
                                $(this).parent().removeClass("showli");
                            }
                            if($(this).parent().hasClass("showli")){
                                $(this).parent().show();
                                $(this).parent("li").parent("ul").children("li.showli:eq(0)").addClass("lihover");
                            }else{
                                $(this).parent().hide();
                                $(this).parent().removeClass("lihover");
                            }
                        });
                    });

					//修改
					if(!$(".autoul").children("li").hasClass("showli")){

						$(".autoul").hide();
					}
                }else{
                    //"@"后没有继续输入时
                    $(".autoul").children().show();
                    $("ul.autoul li").removeClass("showli");
                    $("ul.autoul li.lihover").removeClass("lihover");
                    $("ul.autoul li:eq(0)").addClass("lihover");
                }
            }
		}//有效输入按键事件结束

		if(event.keyCode == 8 || event.keyCode == 46){
	 
		  $(this).next().children().removeClass("lihover");
		  $(this).next().children("li:visible:eq(0)").addClass("lihover");
		}//删除事件结束  
		
	   if(event.keyCode == 38){
		 //使光标始终在输入框文字右边
		  $(this).val($(this).val());
	   }//方向键↑结束
		
	   if(event.keyCode == 13){
		
			//keyup时只做菜单收起相关的动作和去掉lihover类的动作，不涉及焦点转移
			$(".autoul").hide();
			$(".autoul").children().hide();
			$(".autoul").children().removeClass("lihover");  		
	   }
	});	
	
	$("#uemail").keydown(function(){

		if(event.keyCode == 40){

            //当键盘按下↓时,如果已经有li处于被选中的状态,则去掉状态,并把样式赋给下一条(可见的)li
            if ($("ul.autoul li").is(".lihover")) {

                //如果还存在下一条(可见的)li的话
                if ($("ul.autoul li.lihover").nextAll().is("li:visible")) {

                    if ($("ul.autoul li.lihover").nextAll().hasClass("showli")) {

                        $("ul.autoul li.lihover").removeClass("lihover")
                                .nextAll(".showli:eq(0)").addClass("lihover");
                    } else {

                        $("ul.autoul li.lihover").removeClass("lihover").removeClass("showli")
                                .next("li:visible").addClass("lihover");
                        $("ul.autoul").children().show();
                    }
                } else {

                    $("ul.autoul li.lihover").removeClass("lihover");
                    $("ul.autoul li:visible:eq(0)").addClass("lihover");
                }
            } 
		}

		if(event.keyCode == 38){

            //当键盘按下↓时,如果已经有li处于被选中的状态,则去掉状态,并把样式赋给下一条(可见的)li
            if($("ul.autoul li").is(".lihover")){

                //如果还存在上一条(可见的)li的话
                if($("ul.autoul li.lihover").prevAll().is("li:visible")){


                    if($("ul.autoul li.lihover").prevAll().hasClass("showli")){

                        $("ul.autoul li.lihover").removeClass("lihover")
                                .prevAll(".showli:eq(0)").addClass("lihover");
                    }else{

                        $("ul.autoul li.lihover").removeClass("lihover").removeClass("showli")
                                .prev("li:visible").addClass("lihover");
                        $("ul.autoul").children().show();
                    }
                }else{

                    $("ul.autoul li.lihover").removeClass("lihover");
                    $("ul.autoul li:visible:eq("+($("ul.autoul li:visible").length-1)+")").addClass("lihover");
                }
            }else{

                //当键盘按下↓时,如果之前没有一条li被选中的话,则第一条(可见的)li被选中
                $("ul.autoul li:visible:eq("+($("ul.autoul li:visible").length-1)+")").addClass("lihover");
            }
		} 

		if(event.keyCode == 13){							

            //keydown时完成的两个动作 ①填充 ②判断下拉菜单是否存在，如果不存在则焦点移至密码栏目。注意下拉菜单的收起动作放在keyup事件中。即当从下拉菜单中选择邮箱的时候按回车不会触发焦点转移，而选择完毕菜单收起之后再按回车，才会触发焦点转移事件
			if($("ul.autoul li").is(".lihover")) {

                $("#uemail").val($("ul.autoul li.lihover").children(".ex").text() + "@" + $("ul.autoul li.lihover").children(".step").text());
            }

			//把焦点移至密码栏目
			if($(".autoul").attr("style") == "display: none;"){
	
				$("#upwd").focus();
			}
		}
	});

	
	//把click事件修改为mousedown,避免click事件时短暂的失去焦点而触发blur事件
	$(".autoli").mousedown(function(){
 
		$("#uemail").val($(this).children(".ex").text()+$(this).children(".at").text()+$(this).children(".step").text());
		$(".autoul").hide();
		
		//修改
		$("#uemail").focus();
	}).hover(function(){

		if($("ul.autoul li").hasClass("lihover")){

			$("ul.autoul li").removeClass("lihover");
		}
		$(this).addClass("lihover");
	});

	$("body").click(function(){

		$(".autoul").hide();
	});
});