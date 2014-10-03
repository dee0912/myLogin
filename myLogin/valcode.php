<?php 

	session_start();
	header("content-type:image/png");

	//session中保存生成的4位随机数和经过ms5加密的随机数
	if(isset($_SESSION['mdnum']) && $_SESSION['mdnum']!=""){
	
		$mdnum = $_SESSION['mdnum'];
		
		if(isset($_GET['num']) && $_GET['num']!=""){
	
			//当注册页传递过来的num和session中经过加密的随机数相等时
			if($_GET['num'] == $mdnum){
			
				if(isset($_SESSION['num']) && $_SESSION['num']!="")

					//把session中保存的4位随机数赋给$num
					$num = $_SESSION['num'];
			}
		}
	}

	$imagewidth = 150;
	$imageheight = 54;
	
	//创建图像
	$numimage = imagecreate($imagewidth, $imageheight);
	
	//为图像分配颜色
	imagecolorallocate($numimage, 240,240,240); 

	//字体大小
	$font_size = 33;
	
	//字体名称
	$fontname = 'arial.ttf';
	
	//循环生成图片文字
	for($i = 0;$i<strlen($num);$i++){
		
		//获取文字左上角x坐标
		$x = mt_rand(20,20) + $imagewidth*$i/5;
		
		//获取文字左上角y坐标
		$y = mt_rand(40, $imageheight);
		
		//为文字分配颜色
		$color = imagecolorallocate($numimage, mt_rand(0,150),  mt_rand(0,150),  mt_rand(0,150));
		
		//写入文字
		imagettftext($numimage,$font_size,0,$x,$y,$color,$fontname,$num[$i]);
	}
	
	//生成干扰码
	for($i = 0;$i<2200;$i++){
		$randcolor = imagecolorallocate($numimage, rand(200,255), rand(200,255), rand(200,255));
		imagesetpixel($numimage, rand()%180, rand()%90, $randcolor);
	}
	
	//输出图片
	imagepng($numimage);
	imagedestroy($numimage);

?>