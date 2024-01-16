<?php
include "../classes/User.php";

//create an obj
$user = new User;

//call the method
//$user(料理人)に、実際に使う材料とstoreするための手順(User > store)を渡して実行してもらいます。
 //store: サインイン時に入力された情報をデータベースに保存。そして index.phpへの方法（手順）
 //また、実際に使う材料は$_POSTです。
$user->store($_POST);
// $_POST holds all the data from the form views > register.php


/*
$user->store(
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
)

ちなみに・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・・

$_POST 

= 

$first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

=

$request

*/


?>