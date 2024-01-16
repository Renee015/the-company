<?php
include "../classes/User.php"; 

$user = new User;

$user->delete();

?>

<?php
include "../classes/User.php";

$user = new User;

$user->update($_POST, $_FILES);

?>

<?php
include "../classes/User.php";

$user = new User;

$user->login($_POST);

?>

<?php
 include "../classes/User.php";

 $user = new User;

 $user->logout();

?>

<?php
include "../classes/User.php";

$user = new User;

$user->store($_POST);

?>



