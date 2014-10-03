<?php
header("charst=utf-8");
include_once 'conn/conn.php';
include_once 'Zend/Mail/Transport/Smtp.php';
include_once 'Zend/Mail.php';
include_once 'mail.class.php';

if(isset($_GET['n']) && $_GET['n']!="" && isset($_GET['k']) && $_GET['k']!=""){

	//过滤处理
	if(get_magic_quotes_gpc()){
	
		$n = stripslashes(urldecode($_GET['n']));
		$k = stripslashes(urldecode($_GET['k']));
	}else{

		$n = $_GET['n'];
		$k = $_GET['k'];
	}

	$table = "user";
	//先查询记录
	//addslashes($n) 因为使用了mysql_real_escape_string,所以存储在数据库中的是带转义的字符串
	$sql = "select * from ".$table." where uname='".$n."' and activekey='".$k."'";
	$rs = $conne->getRowsRst($sql);	
	$rsuemail = $rs['uemail'];

	$num = $conne->getRowsNum($sql);
	if($num == 1){
	
		$key = md5(rand());
		//更新注册时间
		$nowTime = time();
		//update activekey和lockurl
		$upnum = $conne->uidRst("update ".$table." set activekey = '".$key."' , lockurl=0,regdate = '".$nowTime."' where uname = '".$n."' and activekey = '".$k."'");

		if($upnum == 1){
		
			//插入成功时发送邮件
			//用户激活链接
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/activation.php';
			//urlencode函数转换url中的中文编码
			//带反斜杠
			$url.= '?name='.urlencode((trim($n))).'&k='.$key;

			//定义登录使用的邮箱
			$envelope = 'dee1566@126.com';
			$password = '密码';
			$port = 25;
			$auth = 'login';
			$smtp = 'smtp.126.com';
			
			//激活邮件的主题和正文
			$subject = '激活您的帐号';
			$mailbody = '注册成功，<a href="'.$url.'" target="_blank">请点击此处激活帐号</a>';
			postmail($auth,$port,$envelope,$password,$smtp,$rsuemail,$subject,$mailbody);

			echo "<script>self.location=\"maillogin.php?m=".$rsuemail."&n=".urlencode($n)."&k=".$key."\";</script>";
		}else{
		
			//提示激活失败并跳转
			echo "<div id=\"textBox\">22激活失败，<span id=\"second\"></span>  秒钟后跳转至注册页...</div>";
			echo "<script src=\"templets/js/showTime.js\"></script>";			
			echo "<script>var href='register.php';showTime(href);</script>";
		}
		

	}else{
	
		//提示激活失败并跳转
		echo "<div id=\"textBox\">12激活失败，<span id=\"second\"></span>  秒钟后跳转至注册页...</div>";
		echo "<script src=\"templets/js/showTime.js\"></script>";			
		echo "<script>var href='register.php';showTime(href);</script>";
	}
}else{

	echo "<div id=\"textBox\">参数错误，请重新注册，<span id=\"second\"></span>  秒钟后跳转至注册页...</div>";
	echo "<script src=\"templets/js/showTime.js\"></script>";			
	echo "<script>var href='register.php';showTime(href);</script>";

}
?>
