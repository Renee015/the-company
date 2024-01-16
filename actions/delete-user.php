<?php
include "../classes/User.php"; // when you click the delete btn, you come this page

$user = new User;

$user->delete();

?>