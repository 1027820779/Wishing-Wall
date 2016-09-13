<?php 
class Image{
	// 添加水印图
	public function water($img,$logo_img,$pos=9,$new_img=true){
		// 打开目标图片
		$img_type=$this->type_img($img);
		$img_fn="imagecreatefrom{$img_type}";
		$dst_img=$img_fn($img);
		// 获取目标图宽高
		$dst_w=imagesx($dst_img);
		$dst_h=imagesy($dst_img);

		// 打开资源图
		$simg_type=$this->type_img($logo_img);
		$src_fn="imagecreatefrom{$simg_type}";
		$src_img=$src_fn($logo_img);

		// 获取原图宽高
		$src_w=imagesx($src_img);
		$src_h=imagesy($src_img);

		// 算出logo位置
		switch ($pos) {
			case 1:
				$dst_x=20;
				$dst_y=20;
				break;
			case 2:
				$dst_x=($dst_w-$src_w)/2;
				$dst_y=20;
				break;
			case 3:
				$dst_x=$dst_w-$src_w-20;
				$dst_y=20;
				break;
			case 4:
				$dst_x=20;
				$dst_y=($dst_h-$src_h)/2;
				break;
			case 5:
				$dst_x=($dst_w-$src_w)/2;
				$dst_y=($dst_h-$src_h)/2;
				break;
			case 6:
				$dst_x=$dst_w-$src_w-20;
				$dst_y=($dst_h-$src_h)/2;
				break;
			case 7:
				$dst_x=20;
				$dst_y=$dst_h-$src_h-20;
				break;
			case 8:
				$dst_x=($dst_w-$src_w)/2;
				$dst_y=$dst_h-$src_h-20;
				break;
			case 9:
				$dst_x=$dst_w-$src_w-20;
				$dst_y=$dst_h-$src_h-20;
				break;																														
			default:
				$dst_x=mt_rand(0,$dst_w-$src_w);
				$dst_y=mt_rand(0,$dst_h-$src_h);
				break;
		}
		// 加盖水印
		imagecopy($dst_img,$src_img, $dst_x, $dst_y,0, 0, $src_w, $src_h);
		// 保存
		$w_type=$this->type_img($img);
		$fn="image{$w_type}";
		// 判断加上原图上还是重新创建一个图片
		if($new_img=="true"){
			$fn($dst_img,$img);
		}else{
			$fn($dst_img,$new_img);
		}

		// 销毁资源
		imagedestroy($dst_img);
		imagedestroy($src_img);
	}

	// 生成缩略图
	public function thumb($img,$width,$height,$new_thumb=true){
		// 创建画布
		$dst_img=imagecreatetruecolor($width,$height);
		// 打开目标图片
		$img_type=$this->type_img($img);
		$img_fn="imagecreatefrom{$img_type}";
		$src_img=$img_fn($img);
		// 获取目标图宽高
		$src_w=imagesx($src_img);
		$src_h=imagesy($src_img);

		imagecopyresized($dst_img,$src_img, 0, 0, 0, 0, $width, $height, $src_w,$src_h);
		// 保存
		$w_type=$this->type_img($img);
		$fn="image{$w_type}";
		// 判断重新创建一个图片还是原来的覆盖掉
		if($new_thumb=="true"){
			$fn($dst_img,$img);
		}else{
			$fn($dst_img,$new_thumb);
		}

		// 销毁资源
		imagedestroy($src_img);
		imagedestroy($dst_img);

	}

	// 返回类型
	private function type_img($img){
		// 目标图处理
		$img_type=ltrim(strrchr($img,"."),".");
		// 然后都统一改小写
		$img_type=strtolower($img_type);
		// 返回图片格式
		if($img_type=="jpg") $img_type="jpeg";
		return $img_type;
	}


}
$img=new Image;
// 水印,返回加完水印后的地址
// 参数1 目标图
// 参数2 资源图
// 参数3 资源图九个图位置
// 1 2 3
// 4 5 6
// 7 8 9
// 参数4 添加水印后另存一个图，不传印到原图上
// $img->water("./tax.jpg","./tar.png",9);

// 缩略图
// 参数1 目标图
// 参数2 宽度
// 参数3 高度
// 参数4 新的图片名称 
$img->thumb("./tax.jpg",240,430,"./bai.png");






 ?>