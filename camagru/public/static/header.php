<?php
if (!isset($_SESSION)) {
	session_start();
}
$notlogged = '<body>
	<div id="header">
		<a href="index.php">
			<div id="logo">
				<img src="./img/logo.png">
				<h1>CAMAGRICK</h1>
			</div>
		</a>
		<div id="buttons">
			<div class="button1"><a href="signin.php"><span>sign in</span></a></div>
			<div class="button2"><a href="signup.php"><span>sign up</span></a></div>
		</div>
	</div>';
$logged = '<body>
	<div id="header">
		<a href="index.php">
			<div id="logo">
				<img src="./img/logo.png">
				<h1>CAMAGRICK</h1>
			</div>
		</a>
		<div id="buttons">
			<div class="button1"><a href="profile.php"><span>profile</span></a></div>
			<div class="button1"><a href="signout.php"><span>sign out</span></a></div>
		</div>
	</div>';
include_once("verif.php");
if (isset($_SESSION["id_user"]))
	echo $logged;
else
	echo $notlogged;
?>
