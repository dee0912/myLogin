<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>注册页面</title>
<link href="templets/css/common.css"  rel="stylesheet" type="text/css">
<style>
#container{ 

	background-color:#fff;
	width:990px;
	height:547px;
	margin-top:50px;
	margin-bottom:20px;
	overflow:hidden;
}
#mailChk{ width:530px; margin:100px auto auto auto; position:relative;}

.mailfonts{ margin-left:20px;}
.mailpic{ float:left;}
.mailfonts{ float:left;}
.hfonts{ font-size:22px; }
.ftit{ 
	
	position:relative; 
	top:-70px; 
	left:-180px; 
	border-bottom:1px solid #eee;
	width:870px;
	padding-bottom:10px;
	font-size: 20px;
	font-weight: normal;
	font-family: "Microsoft YaHei",\5fae\8f6f\96c5\9ed1,arial,\5b8b\4f53;
	color: #323232;
}
.ftit2{

	height:1px;
	top:50px; 
	left:-180px; 
}
.sfonts{ line-height:48px; color:#666;}
.orange{ color:#ee8c18;}
#maillogin{

	display: block;
	width: 390px;
	height: 50px;
	line-height: 50px;
	border: 0;
	overflow: hidden;
	text-align: center;
	background: #69b3f2;
	font-family: "Microsoft YaHei",\5fae\8f6f\96c5\9ed1,arial,\5b8b\4f53;
	font-size: 26px;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	border-radius: 2px;
	margin:100px auto 0 85px;
	cursor:pointer;
}

#maillogin:hover{ background: #7cbdf5;}
#maillogin,#maillogin:hover{ color:#fff;}
#maillogin a{ color:#fff;}

.notice{ 
	
	position:relative;
	bottom:-70px;
	left:-180px;
}
#notice{

	width:300px;
	height:200px;
	position:fixed;
	top:50%;
	left:50%;
	margin:-100px 0 0 -150px;
	background:#eee;
	text-align:center;
	line-height:180px;
	display:none;
}
.notit{ font-size:14px; color:#949494; font-weight:bold; font-family:arial;}
.noul{ color:#949494; margin-left:-40px;}
</style>
<script src="templets/js/jquery-1.8.3.min.js"></script>
<script src="templets/js/maillogin.js"></script>
</head>

<body>

<!--顶部长条-->
<div id="header-nav">
	<div id="header-nav-fonts">
		<span class="top-tie-big"><a href="#">Dee's BLOG</a></span> 
		<span class="top-tie"> | </span>
		<span class="top-tie-big">注册</span>
		<span class="top-tie-small">已有帐号？马上<a href="#">登录</a></span>
		<div class="cls"></div>
	</div>
</div>

<!-- 内容区 -->
<div id="container">

	<div id="mailChk">
		<?php 
	
			if(isset($_GET['m']) && $_GET['m']!=""){
			
				$m = $_GET['m'];
			}else{
			
				echo "<div class=\"hfonts ftit\">操作有误，<a href=\"templets/register.html\">请重新注册</div>";
				exit();
			}

			//接收用户名和key
			if(!empty($_GET['n']) && !is_null($_GET['n']) && !empty($_GET['k']) && !is_null($_GET['k'])){
					
				if(get_magic_quotes_gpc()){
	
					$n = stripslashes(urldecode($_GET['n']));
					$k = stripslashes(urldecode($_GET['k']));
				}else{
	
					$n = urldecode($_GET['n']);
					$k = urldecode($_GET['k']);
				}
			}

			require_once 'mail.class.php';
		?>
		<div class="hfonts ftit">邮箱验证</div>
		<img class="mailpic" src="templets/images/mail.jpg">
		<div class="mailfonts">
			<div class="hfonts">验证邮件已发出，请48小时内登陆邮箱验证</div>
			<div class="sfonts">登录邮箱 <a id="mailaddr" class="orange"><?php echo $m;?></a> ,并按邮件提示操作即可</div>
			<input id="n" type="hidden" value="<?php echo $n;?>"/>
			<input id="k" type="hidden" value="<?php echo $k;?>"/>
		</div>
		<button type="button" id="maillogin"><a href="">立即登录邮箱验证</a></button>
		<div class="ftit ftit2"></div>
		<div class="cls"></div>
		<div class="notice">
			<h3 class="notit">还没有收到验证邮件呢？</h3>
			<ul class="noul">
				<li>1.尝试到广告邮件、垃圾邮件目录里找找看</li>
				<li>2.<a id="re" class="blue" href="#">再次发送验证邮件</a></li>
				<li>3.如果重发注册验证邮件仍然没有收到，请更换<a class="blue" href="register.php">另一个邮件地址</a></li>
			</ul>
		</div>
	</div>
	
</div>
</body>
<script>

	$(function(){

		$("#re").click(function(){
		
			$.post("remailajax.php",{
                         
             //要传递的数据
             n : $("#n").val(),
			 k : $("#k").val(),
			 m : $("#mailaddr").text()
			},function(data,textStatus){

				if(data == 0){
			
					success();
				}else{
			
					alert("重新发送邮件失败");
				}
			});

			return false;
		});

		
		$notice = $("<div id=\"notice\">邮件已经发送，请到邮箱中查看...</div>");
		function success(){
			
			$notice.insertAfter($("#mailChk"));

			$notice.show(300);
		}					

		function hide(){
		
			if($notice){
			
				$notice.hide(300);
			}
		}

		//显示4秒
		setInterval(hide,4000);
	});
</script>
</html>