<!doctype html>
<html>
		<?php include_once("./static/head.php"); ?>
		<?php include_once("./static/header.php"); ?>
<?php
    session_start();
    $_SESSION['u_token'];
    if (isset($_GET['token']))
    {
        if (isset($_SESSION["status"])) {
            if ($_SESSION["status"] == true)
                include_once("notif-t.php");
            else
                include_once("notif-f.php");
            $_SESSION["status"] = null;
            $_SESSION["message"] = null;
        }
        //verif secu
        $query = $db->query('SELECT * FROM db_camagru.users WHERE token = '. $db->quote($_GET['token']));
        $count = $query->rowCount();
        if (!$count)
        {
            $_SESSION["status"] = false;
            $_SESSION["message"] = "ERROR: Access denied: Token expired";
            header("Location: http://localhost:8080/camagru_ok/public/index.php");
            die();
        }
		$_SESSION['u_token'] = $_GET['token']; ?>
			<div id="container1">
				<form method="POST" action="reset_passwd.php?token=<?=$_GET["token"]?>">
				<h3 class="title">Change password</h3>
				<input type="password"  class="input-form" placeholder="Enter new password" name="new_passwd" required>
				<input type="password" class="input-form" placeholder="Confirm your new password" name="confirm" required>
				<button type="submit" class="registerbtn">Change password</button>
			</form>
		<br/><a href="index.php">Retour a l'accueil</a>
			</div>
		<?php include_once("./static/footer.php") ?>
</html>
<?php if (isset($_POST['new_passwd']) && isset($_POST['confirm']))
        {
            if (!is_passwd($_POST['new_passwd']))
            {
                $_SESSION["status"] = false;
                $_SESSION["message"] = "Your password  is not enough safe.";
                header("Location: http://localhost:8080/camagru_ok/public/reset_passwd.php?token=" . $_GET['token']);
                die();
            }
            $n_passwd = hash("whirlpool", $_POST['new_passwd']);
            $c_passwd = hash("whirlpool", $_POST['confirm']);
            if (!isEqual($n_passwd, $c_passwd))
            {
                $_SESSION["status"] = false;
                $_SESSION["message"] = "Your passwords are differents.";
                header("Location: http://localhost:8080/camagru_ok/public/reset_passwd.php?token=" . $_GET['token']);
                die();
            }
            else
            {
                db_update("users", "token", $_SESSION['u_token'], "password", $n_passwd, $db);
                db_update("users", "token", $_SESSION['u_token'], "token", uniqid(), $db);
                $_SESSION['u_token'] = NULL;
                $_SESSION["status"] = true;
                $_SESSION["message"] = "Your password has been changed";
                header("Location: http://localhost:8080/camagru_ok/public/index.php");
                die();
            }
        }
        else
        {
            die();
        }
    }
    else
    {
        $_SESSION["status"] = false;
        $_SESSION["message"] = "ERROR: Access denied<";
        header("Location: http://localhost:8080/camagru_ok/public/index.php");
        die();
    }
?>
