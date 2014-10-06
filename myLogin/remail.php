<?php
header("charst=utf-8");
include_once 'conn/conn.php';
include_once 'Zend/Mail/Transport/Smtp.php';
include_once 'Zend/Mail.php';
include_once 'mail.class.php';
require_once 'init.inc.php';

$smarty->assign("Template_Dir",Template_Dir);
$smarty->assign("ROOT_URL",ROOT_URL);

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

			//成功跳转至maillogin.php
			$smarty->assign("m",$rsuemail);
			$smarty->assign("n",urlencode($n));
			$smarty->assign("k",$key);

			$smarty->display("remail_success.html");

		}else{
		
			//激活失败，返回register.php
			$smarty->display("email_wrong.html");
		}
		

	}else{
	
		//激活失败，返回register.php
		$smarty->display("email_wrong.html");
	}
}else{

	//参数错误，返回register.php
	$smarty->display("reactivation_wrong.html");

}
?>
