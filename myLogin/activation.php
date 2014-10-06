<?php 
session_start();
header('Content-type:text/html;charset=utf-8');
include_once 'conn/conn.php';
require_once 'init.inc.php';

$smarty->assign("Template_Dir",Template_Dir);
$smarty->assign("ROOT_URL",ROOT_URL);

$nowTime = time();

$table = "user";

if(!empty($_GET['name']) && !is_null($_GET['name']) && !empty($_GET['k']) && !is_null($_GET['k'])){
					
	if(get_magic_quotes_gpc()){
	
		$getname = stripslashes(urldecode($_GET['name']));
		$k = stripslashes(urldecode($_GET['k']));
	}else{
	
		$getname = urldecode($_GET['name']);
		$k = urldecode($_GET['k']);
	}

	//urldecode反转url中的中文编码
	$sql = "select * from ".$table." where uname='".$getname."' and activekey='".$k."'";

	$num = $conne->getRowsNum($sql);

	if($num>0){
		
		$rs = $conne->getRowsRst($sql);	

		//注册时间
		$rsRegdate = $rs['regdate'];
		
		//有效期2分钟
		if($nowTime > $rsRegdate+120){
		
			//超过有效期
			$upnum = $conne->uidRst("update ".$table." set lockurl = 1 where uname = '".$getname."' and activekey = '".$k."'");

			if($upnum>0){

				//提示激活失败并跳转至reactivation.php
				$smarty->assign("n",urlencode($getname));
				$smarty->assign("k",$k);

				$smarty->display("overtimeNotice.html");

			}else{
			
				//提示激活失败并跳转至register.php
				$smarty->display("email_wrong.html");
			}
		}else{
		
			$upnum = $conne->uidRst("update ".$table." set active = 1 where uname = '".$getname."' and activekey = '".$k."'");

			if($upnum>0){
			
				$_SESSION['name'] = urldecode($getname);

				//成功激活提示并跳转至main.php
				$smarty->display("active_success.html");
			}else{
			
				//已经激活过了的提示并跳转至main.php
				$smarty->display("actived.html");
			}
		}			
	}else{
		
		//提示激活失败并跳转至register.php
		$smarty->display("active_wrong.html");
	}
}
?>