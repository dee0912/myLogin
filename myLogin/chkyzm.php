<?php
session_start();
header("charset=utf-8");

if(isset($_POST['yzm']) && $_POST['yzm']!=""){

	$yzm = $_POST['yzm'];

	if(isset($_SESSION['num']) && $_SESSION['num']!=""){

		//当输入的验证码和session里保存的num一致时
		if(strtolower($yzm) == $_SESSION['num']){
		
			//输入正确
			$state = 0;
		}else{
		
			//输入错误
			$state = 2;
		}
	}
}else{	
	
	//没有输入
	$state = 1;
}
echo $state;
?>