<!doctype html>
<html>
	<?php include_once("./static/head.php") ?>
	<?php include_once("./static/header.php") ?>
	<form method="POST" action="signup.php">
		<div id="container1">
			<h1 class="title">Sign up</h1>
				<hr>
				<input class="input-form" type="email" placeholder="Enter E-mail" name="e-mail" required>
				<input class="input-form" type="text" placeholder="Enter Login" name="login" required>
				<input class="input-form" type="password" placeholder="Enter Password" name="passwd" required>
				<input class="input-form" type="password" placeholder="Confirm Password" name="c_passwd" required>
				<hr>
				<button type="submit" class="registerbtn">Sign up</button>
				<p><a onMouseOver='this.style.textDecoration="underline"' onMouseOut='this.style.textDecoration="none"' href="signin.php">Already an account?</a></p>
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
	if (isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["c_passwd"]) && isset($_POST["e-mail"]))
	{
		$stat = new_user($_POST["login"], $_POST["passwd"], $_POST["c_passwd"], $_POST["e-mail"], $db);
		$_SESSION["status"] = $stat["status"];
		$_SESSION["message"] = $stat["message"];
		if ($stat["status"] == true)
			header("Location: http://localhost:8080/camagru_ok/public/index.php");
		else
			header("Location: http://localhost:8080/camagru_ok/public/signup.php");
		die();
	}

//    if (function_exists($_GET["f"]))
//    {
//        echo "enter in function". PHP_EOL;
//        $_GET["f"]($_GET["username"], $_GET["token"], $db);
//        echo "end function" . PHP_EOL;
//    }
	?>
</html>
