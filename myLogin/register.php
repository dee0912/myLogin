<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>注册页面</title>
<link href="templets/css/common.css"  rel="stylesheet" type="text/css">
<link href="templets/css/register.css"  rel="stylesheet" type="text/css">

<script src="templets/js/jquery-1.8.3.min.js"></script>
<script src="templets/js/register.js"></script>
<!--邮箱下拉-->
<script src="templets/js/emailup.js"></script>
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

	<!--注册区-->
	<div id="register">

		<!-- 注册表单 -->
		<form id="register-form" action="register_chk.php" method="post">
			
			<!-- 用户名 -->		
			<!-- placeholder HTML5的属性，提供提示信息。输入字段为空时显示，并会在字段获得焦点时消失 -->
			<div class="ipt fipt">
				<input type="text" name="uname" id="uname" value="" placeholder="输入用户名"  autocomplete="off" />
				<!--提示文字-->
				<span id="unamechk"></span>
			</div>

			<!-- email -->			
			<div class="ipt">
				<input type="text" name="uemail" id="uemail" value="" placeholder="常用邮箱地址" autocomplete="off" /><span id="uemailchk"></span><ul class="autoul"></ul>
			</div>

			<!-- 密码 -->
			<div class="ipt">
				<input type="password" name="upwd" id="upwd" value="" placeholder="设置密码" /><div class="upwdpic"><span id="upwdchk"></span><img id="pictie" /></div>
			</div>
			
			<!-- 重复密码 -->
			<div class="ipt">
				<input type="password" name="rupwd" id="rupwd" value="" placeholder="确认密码" /><span id="rupwdchk"></span>
			</div>

			<?php 
			
				//生成验证码
				function showval(){

					$num = "";
					for($i=0;$i<4;$i++){

						$tmp = rand(1,15);
						if ($tmp > 9) {
							switch ($tmp) {
								case(10):
									$num .= 'a';
									break;
								case(11):
									$num .= 'b';
									break;
								case(12):
									$num .= 'c';
									break;
								case(13):
									$num .= 'd';
									break;
								case(14):
									$num .= 'e';
									break;
								case(15):
									$num .= 'f';
									break;
							}
						} else {
							$num .= $tmp;
						}	
					}
					return $num;
				}
	
				$mdnum = md5(showval());

				$_SESSION['num'] = showval();
				$_SESSION['mdnum'] = $mdnum;
			?>
			<!--验证码-->
			<div class="ipt iptend">
				<input type='text' id='yzm' name='yzm' placeholder="验证码" autocomplete="off" />
				<img id='yzmpic' src='valcode.php?num=<?php echo $mdnum;?>' style="cursor:pointer" alt="验证码" title="验证码">
				<a style="cursor:pointer" id='changea'>
					<img id="refpic" src="templets/images/ref.jpg" alt="刷新验证码">
				</a>
				<span id='yzmchk'></span>
			</div>

			<!-- 提交 -->
			<button type="button" id="sub">立即注册</button>

			<!-- 服务条款 -->
			<span class="fuwu">
				<input type="checkbox" name="agree" id="agree" checked="checked">
				<label for="agree">我同意  <a href="#">" 服务条款  "</a> 和  <a href="#">" 网络游戏用户隐私权保护和个人信息利用政策 "</a>
				</label>
			</span>

		</form>

	</div>

</div>
</body>
</html>