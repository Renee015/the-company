<?php
//Actions is where the functions will be called
//ここで実際に作ります。レシピ（手順やマニュアル）と実際に使う材料(ユーザーからの情報)を使って

include "../classes/User.php";

//create an obj
//Userというレシピを実際に使います。それを$user(料理人)に渡します。
$user = new User;

//call the method
//$user(料理人)に、実際に使う材料とloginするための手順(User > login)を渡して実行してもらいます。
$user->login($_POST);

/*
    $_POST['username'];
    $_POST['password'];

*/

?>