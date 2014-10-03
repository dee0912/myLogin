<?php
header("charst=utf-8");

if(isset($_GET['n']) && $_GET['n']!="" && isset($_GET['k']) && $_GET['k']!=""){

	//过滤处理
	if(get_magic_quotes_gpc()){
	
		$n = stripslashes(urldecode($_GET['n']));
		$k = stripslashes(urldecode($_GET['k']));
	}else{

		$n = $_GET['n'];
		$k = $_GET['k'];
	}

	echo "<a href='remail.php?n=".urlencode($n)."&k=".urlencode($k)."'>重新收取激活邮件</a>";

	echo "<a href='register.php'>返回注册页</a>";

}else{

	echo "<div id=\"textBox\">参数错误，请重新注册，<span id=\"second\"></span>  秒钟后跳转至注册页...</div>";
	echo "<script src=\"templets/js/showTime.js\"></script>";			
	echo "<script>var href='register.php';showTime(href);</script>";
}
?>
