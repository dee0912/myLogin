<?php 

session_start();

//生成验证码
function showval(){

	$num = "";
	for($i=0;$i<4;$i++){

		$tmp = rand(1,15);
		if ($tmp > 9) {
			switch ($tmp) {
				case(10):
					$num .= 'a';
					break;
				case(11):
					$num .= 'b';
					break;
				case(12):
					$num .= 'c';
					break;
				case(13):
					$num .= 'd';
					break;
				case(14):
					$num .= 'e';
					break;
				case(15):
					$num .= 'f';
					break;
			}
		} else {
			$num .= $tmp;
		}	
	}
	return $num;
}

$_SESSION['num'] = showval();
$_SESSION['mdnum'] = md5(showval());