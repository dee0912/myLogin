<?php 

	header("charst=utf-8");
	include_once 'conn/conn.php';
	include_once 'Zend/Mail/Transport/Smtp.php';
	include_once 'Zend/Mail.php';
	include_once 'mail.class.php';
	
	//激活key,生成的随机数
	$key = md5(rand());
	
	//先写入数据库，再发邮件
	//写入数据库
	//判断是否开启magic_quotes_gpc
	if(get_magic_quotes_gpc()){
	
		$postuname = trim($_POST['uname']);
		$postupwd = trim($_POST['upwd']);
		$postuemail = trim($_POST['uemail']);
	}else{
		
		$postuname = addslashes(trim($_POST['uname']));
		$postupwd = addslashes(trim($_POST['upwd']));
		$postuemail = addslashes(trim($_POST['uemail']));
	}
//file_put_contents("D:/mylog.log",$postuname."  *********\r\n",FILE_APPEND);
	function check_input($value){
	
		// 如果不是数字则加引号
		if (!is_numeric($value)){
		
			$value = mysql_real_escape_string($value);
		}
		return $value;
	}
	
	$postuname = check_input($postuname);
	$postupwd = check_input($postupwd);
	$postuemail = check_input($postuemail);
//file_put_contents("D:/mylog.log",$postuname."  *********\r\n",FILE_APPEND);
	$sql = "insert into user(uname,upwd,uemail,activekey,regdate)values('".$postuname."','".md5($postupwd)."','".$postuemail."','".$key."','".time()."')";
//file_put_contents("D:/mylog.log",$sql."  *********\r\n",FILE_APPEND);
	$num = $conne->uidRst($sql);
	if($num == 1){
		
		//插入成功时发送邮件
		//用户激活链接
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/activation.php';
		//urlencode函数转换url中的中文编码
		//带反斜杠
		$url.= '?name='.urlencode($postuname).'&k='.$key;
//file_put_contents("D:/mylog.log",$url."  *********\r\n",FILE_APPEND);
		//定义登录使用的邮箱
		$envelope = 'dee1566@126.com';
		$password = '密码';
		$port = 25;
		$auth = 'login';
		$smtp = 'smtp.126.com';
		
		//激活邮件的主题和正文
		$subject = '激活您的帐号';
		$mailbody = '注册成功，<a href="'.$url.'" target="_blank">请点击此处激活帐号</a>';
		
		postmail($auth,$port,$envelope,$password,$smtp,$postuemail,$subject,$mailbody);

		echo "<script>self.location=\"maillogin.php?m=".$postuemail."&n=".urlencode($postuname)."&k=".$key."\";</script>";

	}else{
	
		//提示激活失败并跳转
		echo "<div id=\"textBox\">激活失败，请重新注册，<span id=\"second\"></span>  秒钟后跳转至重新激活页...</div>";
		echo "<script src=\"templets/js/showTime.js\"></script>";			
		echo "<script>var href='register.php';showTime(href);</script>";
	}
?>