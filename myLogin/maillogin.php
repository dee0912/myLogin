<?php

require_once 'init.inc.php';

$smarty->assign("Template_Dir",Template_Dir);
$smarty->assign("ROOT_URL",ROOT_URL);

//接收并处理get参数
if(isset($_GET['m']) && $_GET['m']!=""){
		
	$m = $_GET['m'];
}else{
		
	echo "<div class=\"hfonts ftit\">操作有误，<a href=\"register.php\">请重新注册</div>";
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

$smarty->assign("n",$n);
$smarty->assign("k",$k);
$smarty->assign("m",$m);

$smarty->display("maillogin.html");