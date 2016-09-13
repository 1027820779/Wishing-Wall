<?php 
// 文本控制器
class ArcController{
	private $db;
	public function __construct(){
		$this->db=include "./con_data.php";
	}
	// 添加(异步请求)
	public function add(){
        $_POST["time"]=date("Y-m-d H:i:s");
		$this->db[]=$_POST;
		$php_code="<?php return " .var_export($this->db,true)."?>";
		file_put_contents("./con_data.php",$php_code);
		echo json_encode($_POST);
	}
}

 ?>