<!doctype html>
<html>
	<?php include_once("./static/head.php"); ?>
	<?php include_once("./static/header.php"); ?>
<?php
if (!isset($_SESSION["id_user"]) && $_SESSION["id_user"] == null) {
	include_once("redirect.php");
	die();
}
if (db_get('users', 'id', $_SESSION["id_user"], 'notif', $db) == true)
{
	$n_change = 0;
	$notif = "Disable notification by e-mail";
}
else
{
	$n_change = 1;
	$notif = "Enable notification by e-mail";
}
?>
	<div id="profil">
		<div id="cont1">
			<p id="profil-title"><?php echo db_get('users', 'id', $_SESSION['id_user'], 'username', $db); ?></p>
		</div>
		<div id="cont2">
			<form method="POST" action="profile.php">
				 <h3 class="title">Change username</h3>
				<input class="input-form" type="text" placeholder="Enter new username" name="new_user" required>
				<input class="input-form" type="password" placeholder="Enter password" name="passwd" required>
				<button type="submit" class="btn">Change username</button>
			</form>
			<form method="POST" action="profile.php">
				<h3 class="title">Change password</h3>
				<input class="input-form" type="password" placeholder="Enter old password" name="old_passwd" required>
				<input class="input-form" type="password" placeholder="Enter new password" name="new_passwd" required>
				<input class="input-form" type="password" placeholder="Confirm your new password" name="confirm" required>
				<button type="submit" class="btn">Change password</button>
			</form>
			<form method="POST" action="profile.php">
				<h3 class="title">Change e-mail</h3>
				<input class="input-form" type="text" placeholder="Enter new e-mail" name="new_email" required>
				<input class="input-form" type="password" placeholder="enter password" name="passwd" required>
				<button type="submit" class="btn">Change e-mail</button>
			</form>
		</div>
		<div id="cont3">
			<form method="POST" action="profile.php">
				<h3 class="title">Notification</h3>
				<input class="input-form" type="password" placeholder="enter password" name="passwd_notif" required>
				<button type="submit" class="btn"><?= $notif ?></button>
			</form>
		</div>
	</div>
	<?php include_once("./static/footer.php"); ?>
<?php
if (isset($_SESSION["status"])) {
	if ($_SESSION["status"] == true)
		include_once("notif-t.php");
	else
		include_once("notif-f.php");
	$_SESSION["status"] = null;
	$_SESSION["message"] = null;
}
$user = db_get('users', 'id', $_SESSION['id_user'], 'username', $db); 
if (isset($_POST["new_user"]) && isset($_POST["passwd"]))
{
	$_SESSION["status"] = "true";
	$_SESSION["message"] = "Username has been changed.";
	if (db_check("users", "username", $_POST["new_user"], $db))
	{
		$_SESSION["status"] = false;
		$_SESSION["message"] = "Username already taken.";
	}
	else if (!db_check("users", "username", $_POST["new_user"], $db) && (hash('whirlpool', $_POST["passwd"]) !== db_get('users', 'id', $_SESSION["id_user"], 'password', $db)))
	{
		$_SESSION["status"] = false;
		$_SESSION["message"] = "Incorrect password.";
	}
	else if (!db_check("users", "username", $_POST["new_user"], $db) && (hash('whirlpool', $_POST["passwd"]) === db_get('users', 'id', $_SESSION["id_user"], 'password', $db)))
	{
		db_update('users', 'id', $_SESSION["id_user"], "username", $_POST["new_user"], $db);
	}
	header("Location: http://localhost:8080/camagru_ok/public/profile.php");
	die();
}
if (isset($_POST["old_passwd"]) && isset($_POST["new_passwd"]) && isset($_POST["confirm"]))
{
	if (isset($_POST["old_passwd"]) && isset($_POST["new_passwd"]) && isset($_POST["confirm"]))
	{
		if ($_POST["new_passwd"] == $_POST["confirm"] &&
			hash('whirlpool', $_POST["old_passwd"]) === db_get("users", "id", $_SESSION["id_user"], "password", $db))
		{
			if (!is_passwd($_POST["new_passwd"]))
			{
				$_SESSION["status"] = false;
				$_SESSION["message"] = "Password is not enough safe.";
				header("Location: http://localhost:8080/camagru_ok/public/profile.php");
				die();
			}
			db_update('users', 'id', $_SESSION["id_user"], "password", hash('whirlpool', $_POST["new_passwd"]), $db);
			$_SESSION["status"] = true;
			$_SESSION["message"] = "Your password has been changed.";
		}
		else
		{
			$_SESSION["status"] = false;
			$_SESSION["message"] = "Incorrect password";
		}
	}
	header("Location: http://localhost:8080/camagru_ok/public/profile.php");
	die();
}
if (isset($_POST["new_email"]) && isset($_POST["passwd"]))
{
	$_SESSION["status"] = "true";
	$_SESSION["message"] = "E-mail has been changed.";
	if (db_check("users", "email", $_POST["new_email"], $db))
	{
		$_SESSION["status"] = false;
		$_SESSION["message"] = "E-mail already taken.";
	}
	else if (!db_check("users", "email", $_POST["new_email"], $db) && (hash('whirlpool', $_POST["passwd"]) !== db_get('users', 'id', $_SESSION["id_user"], 'password', $db)))
	{
		$_SESSION["status"] = false;
		$_SESSION["message"] = "Incorrect password.";
	}
	else if (!db_check("users", "email", $_POST["new_email"], $db) && (hash('whirlpool', $_POST["passwd"]) === db_get('users', 'id', $_SESSION["id_user"], 'password', $db)))
	{
		db_update('users', 'id', $_SESSION["id_user"], "email", $_POST["new_email"], $db);
	}
	header("Location: http://localhost:8080/camagru_ok/public/profile.php");
	die();
}
if (isset($_POST["passwd_notif"]))
{
	$_SESSION["status"] = "true";
	$_SESSION["message"] = "notification has been changed";
	if ((hash('whirlpool', $_POST["passwd_notif"]) !== db_get('users', 'id', $_SESSION["id_user"], 'password', $db)))
	{
		$_SESSION["status"] = false;
		$_SESSION["message"] = "Incorrect password.";
	}
	else if ((hash('whirlpool', $_POST["passwd_notif"]) === db_get('users', 'id', $_SESSION["id_user"], 'password', $db)))
	{
		db_update('users', 'id', $_SESSION["id_user"], "notif", $n_change, $db);
	}
	header("Location: http://localhost:8080/camagru_ok/public/profile.php");
	die();
}
?>
</html>
