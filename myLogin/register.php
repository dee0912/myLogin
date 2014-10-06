<?php

session_start();

require_once 'init.inc.php';

//设置模版目录，用于模版页头部引用CSS、JS、Images
$smarty->assign("Template_Dir",Template_Dir);

$smarty->display('register.html');