<?php 

class Code{
	// 保存画布的资源
	private $img;

	// 画布宽度
	private $width;

	// 画布高度
	private $height;

	// 画布背景颜色
	private $bg_color;

	// 验证码长度
	private $code_len;

	// 字体大小
	private $font_size;

	//是否创建干扰元素
	private $dis;

    // 字体文件
    private $font;

	// 自动加载函数
	public function __construct($width=200,$height=80,$bg_color="#333",$code_len=4,$font_size=20,$dis=true,$font="./file/font.ttf"){
		$this->width=$width;
		$this->height=$height;
		$this->bg_color=$bg_color;
		$this->code_len=$code_len;
		$this->font_size=$font_size;
		$this->dis=$dis;
        $this->font=$font;
	}

	// 提供给外部调用的显示
	public function show(){
		// 1.发送头部
		header("Content-type:image/png");
		// 2.创建画布，调色并且填充颜色
		$this->createBg();
		// 3.写字
		$this->write();
		// 4.创建干扰
		($this->dis)?$this->makeTrouble():false;
		
		// 5.输出图像
		imagepng($this->img);
		// 6.销毁图像
		imagedestroy($this->img);
	}

	// 2.创建画布，调色并且填充颜色
	private function createBg(){
		$this->img=imagecreatetruecolor($this->width,$this->height);
		imagefill($this->img,0,0,hexdec($this->bg_color));
	}

	// 3.写字
	private function write(){
		$strs="1234567890qwertyuiopasdfghjklzxcvbnm";
		$str="";
		// 验证码长度
		for ($i=0; $i < $this->code_len; $i++) { 
			// y坐标
			$y=($this->height+$this->font_size)/2;
			// x坐标
			$x=($this->width/$this->code_len)*$i+5;
			// 要写验证码
			$text=$strs[mt_rand(0,strlen($strs)-1)];
			$str.=$text;
			$color=imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagettftext($this->img,$this->font_size, mt_rand(-30,30), $x, $y, $color,$this->font, $text);
			file_put_contents("./code_data.php","<?php return '" .$str. "' ?>");
		}
		// 转为小写写入session
		$_SESSION["code"]=strtolower($str);
	}

	// 4.创建干扰
	private function makeTrouble(){
		// 线
		for ($i=0; $i <5; $i++) { 
			$color=imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imageline($this->img,mt_rand(0,200),mt_rand(0,80),mt_rand(0,200),mt_rand(0,80),$color);
		}
		// 圆
		for ($i=0; $i <10 ; $i++) { 
			$wh=mt_rand(0,20);
			$color=imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imageellipse($this->img,mt_rand(0,200),mt_rand(0,80),$wh,$wh,$color);

		}
		// 点
		for ($i=0; $i <100;$i++) { 
			$color=imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($this->img, mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
			
		}

	}


}



 ?>