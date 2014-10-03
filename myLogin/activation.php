<?php 
session_start();
header('Content-type:text/html;charset=utf-8');
include_once 'conn/conn.php';

$nowTime = time();

$table = "user";
file_put_contents("D:/mylog.log",$_GET['name']."   ---\r\n",FILE_APPEND);
file_put_contents("D:/mylog.log",urldecode($_GET['name'])."   ---\r\n",FILE_APPEND);
if(!empty($_GET['name']) && !is_null($_GET['name']) && !empty($_GET['k']) && !is_null($_GET['k'])){
					
	if(get_magic_quotes_gpc()){
	
		$getname = stripslashes(urldecode($_GET['name']));
		$k = stripslashes(urldecode($_GET['k']));
	}else{
	
		$getname = urldecode($_GET['name']);
		$k = urldecode($_GET['k']);
	}
file_put_contents("D:/mylog.log",$getname."   ---\r\n",FILE_APPEND);
	//urldecode反转url中的中文编码
	$sql = "select * from ".$table." where uname='".$getname."' and activekey='".$k."'";
file_put_contents("D:/mylog.log",$sql."   ---\r\n",FILE_APPEND);
	$num = $conne->getRowsNum($sql);

	if($num>0){
		
		$rs = $conne->getRowsRst($sql);	

		//注册时间
		$rsRegdate = $rs['regdate'];
		
		//有效期2分钟
		if($nowTime > $rsRegdate+120){
		
			//超过有效期
			$upnum = $conne->uidRst("update ".$table." set lockurl = 1 where uname = '".$getname."' and activekey = '".$k."'");
file_put_contents("D:/mylog.log","update ".$table." set lockurl = 1 where uname = '".$getname."' and activekey = '".$k."'   ---\r\n",FILE_APPEND);
			if($upnum>0){

				//提示激活失败并跳转
				echo "<div id=\"textBox\">超过激活有效期，激活失败，<span id=\"second\"></span>  秒钟后跳转至重新激活页...</div>";
				echo "<script src=\"templets/js/showTime.js\"></script>";
				echo "<script>var href='reactivation.php?n=".urlencode($getname)."&k=".$k."';showTime(href);</script>";
file_put_contents("D:/mylog.log","href='reactivation.php?n=".urlencode($getname)."      ---\r\n",FILE_APPEND);
			}else{
			
				//提示激活失败并跳转
				echo "<div id=\"textBox\">激活失败，请重新注册，<span id=\"second\"></span>  秒钟后跳转至重新激活页...</div>";
				echo "<script src=\"templets/js/showTime.js\"></script>";			
				echo "<script>var href='register.php';showTime(href);</script>";
			}
		}else{
		
			$upnum = $conne->uidRst("update ".$table." set active = 1 where uname = '".$getname."' and activekey = '".$k."'");

			if($upnum>0){
			
				$_SESSION['name'] = urldecode($getname);
				echo "<script>alert('您已成功激活');window.location.href='main.php';</script>";
			}else{
			
				echo "<script>alert('您已经激活过了');window.location.href='main.php';</script>";
			}
		}			
	}else{
		
		//提示激活失败并跳转
		echo "激活链接已失效,请重新发送激活链接或重新注册";
		echo "<script>window.setTimeout(\"self.location='register.php'\",3000);</script>";
	}
}
?>