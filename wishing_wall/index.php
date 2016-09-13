<?php 
// 单入口文件
session_start();
include "./function.php";

// 当实例化没有载入的类时候自动运行函数，参数是实例化的类名
function __autoload($class_name){
	// 加载从get参数里传到的类
	require "./{$class_name}.class.php";
}

// 可变控制器名称
$c=isset($_GET["c"])?$_GET["c"]:"Index";
// 实例化控制器
$name=$c."Controller";
$controller=new $name;

// 可变方法名称
$action=isset($_GET["a"])?$_GET["a"]:"index";
// 调用可变方法
$controller->$action();


 ?>