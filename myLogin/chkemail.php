<?php

	header("charset=utf-8");
	require_once("conn/conn.php");

	if(isset($_POST['uemail']) && $_POST['uemail']!=""){
	
		//存在数据库中是被转义过的字符
		$uemail = trim(addslashes($_POST['uemail']));
	}

	$sql = "select uemail from user where uemail='".$uemail."'";
	
	if($conne->getRowsNum($sql) == 1){
	
		$state = 1;
	}else if($conne->getRowsNum($sql) == 0){
	
		$state = 0;
	}else{

		echo $conne->msg_error();
	}

	echo $state;
?>