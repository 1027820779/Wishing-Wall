<?php 
// 会员管理控制器
class MemberController{
	// 保存数据
	private $db;

	// 自动加载函数，本类实例化是这个函数最先运行
	public function __construct(){
		$this->db=include "./data.php";
	}

    public function check_name(){
        $arr=array();
        foreach ($this->db as $v) {
            $arr[]=$v["username"];
        }
        if(in_array($_POST["name"],$arr)){
            echo true;
        }else{
            echo false;
        }
    }

	// 注册
	public function reg(){
 		// 用户提交信息
 		if(!empty($_POST["username"]) && !empty($_POST["password"])){
 			// 1.先判断用户名是否存在
 			foreach ($this->db as $v) {
 				if($v["username"]==$_POST["username"]){
 					suc("用户名已存在","index.php?c=Member&a=reg");
 					return false;
 				}
 			}

 			// 2.添加数据
 			$this->db[]=array(
 				"username"=>$_POST["username"],
 				"password"=>md5($_POST["password"]),
                "email"=>$_POST["email"]
 			);
 			// 数据合法化
 			$php_code="<?php return ".var_export($this->db,true)."?>";
 			file_put_contents("./data.php",$php_code);
 			suc("注册成功","index.php?c=Member&a=login");
 		}

		// 载入模板
		include "./tpl/reg.html";
	}

	// 登录
	public function login(){
		if(!empty($_POST)){
		//比较验证码
			if(strtolower(htmlspecialchars($_POST["code"])) != $_SESSION["code"]){
				suc("验证码错误","index.php?c=Member&a=login");
			}else{
				foreach ($this->db as $user) {
				// 用户名和密码都符合
				if($user["username"]==htmlspecialchars($_POST["username"]) && $user["password"]==md5($_POST["password"])){
					// 把用户名存入session
					$_SESSION["name"]=$user["username"];
					suc("登录成功","./index.php");
				}
			}
			// 如果都不符合
			suc("用户名或者密码错误","index.php?c=Member&a=login");
			}
		}
		// 载入模板
		include "./tpl/login.html";
	}

	// 退出
	public function out(){
		unset($_SESSION["name"]);
		suc("退出成功","./index.php");
	}

	// 显示验证码
	public function code(){
		// 实例化验证码
		// 参数1 宽度
		// 参数2 高度
		// 参数3 背景颜色
		// 参数4 验证码长度
		// 参数5 字体大小
		// 参数6 是否创建干扰(true创建)(false不创建)
        // 参数7 字体文件
		$code=new Code(120,46,"#F3F5F6",4,30,true,"./file/font.ttf");
		$code->show();
	}

	public function check_code(){
		$code=htmlspecialchars($_POST["code"]);
		if($code==$_SESSION["code"]){
            echo true;
        }else{
            echo false;
        }
	}


}


 ?>