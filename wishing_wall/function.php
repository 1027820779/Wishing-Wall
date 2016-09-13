<?php 

header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");

// p函数
function p($arr){
	echo "<pre>";
	print_r($arr);
	echo "<pre/>";
}

//成功提示函数
// function suc($ms,$url){
// 	$str=<<<str
// <script>
// alert('{$ms}');
// location.href='{$url}';
// <script/>
// str;
// echo $str;	
// }

function suc($msg=null,$url=null){
	if($msg){
		echo "<script>alert('{$msg}');</script>";
	}
	if($url){
		echo "<script>location.href='{$url}';</script>";
	}
}





 ?>