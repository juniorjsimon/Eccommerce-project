<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/88riot/system/init.php';
unset($_SESSION['DBUser']);
header('Location: login.php');

?>
