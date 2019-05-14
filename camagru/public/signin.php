<!doctype html>
<html>
	<?php include_once("./static/head.php") ?>
	<?php include_once("./static/header.php") ?>
	<form method="POST" action="signin.php">
		<div id="container1">
			<h1 class="title">Sign in</h1>
				<hr>
				<input class="input-form" type="text" placeholder="Enter Login" name="login" required>
				<input class="input-form" type="password" placeholder="Enter Password" name="passwd" required>
				<hr>
				<button type="submit" class="registerbtn">Sign in</button>
				<p><a onMouseOver='this.style.textDecoration="underline"' onMouseOut='this.style.textDecoration="none"' href="signup.php">Create an account here</a></p>
				<p><a onMouseOver='this.style.textDecoration="underline"' onMouseOut='this.style.textDecoration="none"' href="forgotpassword.php">Forgotten password?</a></p>
		</div>
	</form>
	<?php include_once("./static/footer.php") ?>
<?php
if (isset($_SESSION["status"])) {
	if ($_SESSION["status"] == true)
		include_once("notif-t.php");
	else
		include_once("notif-f.php");	
	$_SESSION["status"] = null;
	$_SESSION["message"] = null;
}
if (isset($_POST["login"]) && isset($_POST["passwd"]))
{
	$ret = login_user($_POST["login"], $_POST["passwd"], $db);
	if ($ret["status"] == true)
	{
		$_SESSION["id_user"] = db_get("users", "username", $_POST["login"], "id", $db);
		$_SESSION["status"] = $ret["status"];
		$_SESSION["message"] = $ret["message"];
		header("Location: http://localhost:8080/camagru_ok/public/index.php");
	}
	else {
		$_SESSION["status"] = $ret["status"];
		$_SESSION["message"] = $ret["message"];
		header("Location: http://localhost:8080/camagru_ok/public/signin.php");
	}
	die();
}
?>
</html>
