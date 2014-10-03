<?php

header("charset=utf-8");
include_once 'Zend/Mail/Transport/Smtp.php';
include_once 'Zend/Mail.php';
require_once 'mail.class.php';

if(isset($_POST['n']) && $_POST['n']!="" && isset($_POST['k']) && $_POST['k']!="" && isset($_POST['m']) && $_POST['m']!=""){

	if(get_magic_quotes_gpc()){
	
		$n = stripslashes(urldecode($_POST['n']));
		$k = stripslashes(urldecode($_POST['k']));
		$m = stripslashes(urldecode($_POST['m']));
	}else{

		$n = $_POST['n'];
		$k = $_POST['k'];
		$m = $_POST['m'];
	}
	
	$url = 'http://'.$_SERVER['HTTP_HOST'].'/activation.php';
	//urlencode函数转换url中的中文编码
	//带反斜杠
	$url.= '?name='.urlencode($n).'&k='.$k;

	//定义登录使用的邮箱
	$envelope = 'dee1566@126.com';
	$password = '密码';
	$port = 25;
	$auth = 'login';
	$smtp = 'smtp.126.com';
	
	//激活邮件的主题和正文
	$subject = '激活您的帐号';
	$mailbody = '注册成功，<a href="'.$url.'" target="_blank">请点击此处激活帐号</a>';
	//file_put_contents("D:/mylog.log",$url."  ~~~~~~".$m."~~~~~\r\n",FILE_APPEND);	
	postmail($auth,$port,$envelope,$password,$smtp,$m,$subject,$mailbody);

	echo 0;
}
