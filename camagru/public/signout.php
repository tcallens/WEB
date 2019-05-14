<?php
if(!isset($_SESSION)) {
	session_start();
}
$_SESSION["status"] = true;
$_SESSION["message"] = "You log out.";
$_SESSION["id_user"] = null;
header("Location: http://localhost:8080/camagru_ok/public/index.php");
die();
?>
