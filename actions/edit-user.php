<?php
include "../classes/User.php";

$user = new User;

//update() is form "User.php"
$user->update($_POST, $_FILES);
/*
    $_POST here =
    $_POST['first_name'];
    $_POST['last_name'];
    $_POST['username'];
    = $request
 */
// $_FILES is a 2D Associative Array that holds the info of the file such as name and the actual file.
// $_FILES[''][''];
// $_FILES = $files


?>