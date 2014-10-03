<?php 

function postmail($auth,$port,$envelope,$password,$smtp,$postuemail,$subject,$mailbody){

	//$smtp smtp邮件服务器地址
	//$postuemail 用户注册邮件
	//$subject 邮件主题
	//$mailbody 邮件内容
 
	$config = array(
		
		'auth'=>$auth,//发件人
		'port' =>$port,//端口
		'username'=>$envelope,//发件邮箱
		'password'=>$password //发件邮箱密码
		);
	
	//实例化验证的对象,使用gmail smtp服务器
	$transport = new Zend_Mail_Transport_Smtp($smtp,$config);
	$mail = new Zend_Mail('utf-8');
	
	$mail->addTo($postuemail,'获取用户注册激活链接');
	$mail->setFrom($envelope,$auth);
	$mail->setSubject($subject);
	$mail->setBodyHtml($mailbody);
	$mail->send($transport);
}