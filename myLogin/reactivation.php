<?php

require_once 'init.inc.php';

$smarty->assign("Template_Dir",Template_Dir);

if(isset($_GET['n']) && $_GET['n']!="" && isset($_GET['k']) && $_GET['k']!=""){

	//过滤处理
	if(get_magic_quotes_gpc()){
	
		$n = stripslashes(urldecode($_GET['n']));
		$k = stripslashes(urldecode($_GET['k']));
	}else{

		$n = $_GET['n'];
		$k = $_GET['k'];
	}

	
	$smarty->assign("n",urlencode($n));
	$smarty->assign("k",urlencode($k));

	$smarty->display("reactivation_right.html");
}else{

	$smarty->display("reactivation_wrong.html");
}

