<?php

	header("charset=utf-8");

	require_once("conn/conn.php");

	if(isset($_POST['uname']) && $_POST['uname']!=""){
	
		//存在数据库中是被转义过的字符
		$uname = trim(addslashes($_POST['uname']));
	}

	//用户名区分大小写
	$sql = "select uname from user where binary uname='".$uname."'";
	
	if($conne->getRowsNum($sql) == 1){
	
		$state = 1;
	}else if($conne->getRowsNum($sql) == 0){
	
		$state = 0;
	}else{

		echo $conne->msg_error();
	}

	echo $state;

	//file_put_contents("D:/practise/php/myLogin/tmp/log.log",$state." \r\n",FILE_APPEND);

?>