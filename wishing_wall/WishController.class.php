<?php 


class WishController{

    // 许愿
    public function wish(){
        $data=include "./con_data.php";
        include "./tpl/wish.html";
    }
}



 ?>