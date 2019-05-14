<?php
include_once("../utils/db_utils.php");
if (db_check('users', 'id', $_SESSION["id_user"], $db) == false) {
	$_SESSION["id_user"] = null;
}
?>
