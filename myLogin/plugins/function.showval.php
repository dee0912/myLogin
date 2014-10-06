<?php

//生成验证码
function smarty_function_showval($params,$smarty){

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

	$mdnum = md5($num);
	$_SESSION['num'] = $num;
	$_SESSION['mdnum'] = $mdnum;

	//写在session之后
	return $mdnum;
}

<?php

//生成验证码
function smarty_function_showval($params,$smarty){

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

	$mdnum = md5($num);
	$_SESSION['num'] = $num;
	$_SESSION['mdnum'] = $mdnum;

	//写在session之后
	return $mdnum;
}

$_SESSION['num'] = smarty_function_showval($params,$smarty);
$_SESSION['mdnum'] = md5(smarty_function_showval($params,$smarty));