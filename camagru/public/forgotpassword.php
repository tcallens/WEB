<!doctype html>
<html>
	<?php include_once("./static/head.php") ?>
<!doctype html>
<html>	<form method="POST" action="forgotpassword.php">
	<?php include_once("./static/head.php") ?>		<div id="container1">
	<?php include_once("./static/header.php") ?>			<h1 class="title">New password ?</h1>
			<hr><br>
			<input type="email" placeholder="Enter E-mail" name="e-mail" required>
			<br><br><hr>
			<br><br>
			<button type="submit" class="registerbtn" name="submit" value="OK">Send recovery email</button>
		</div>
	</form>	
	<?php include_once("./static/footer.php") ?>
    <?php
        session_start();
//        include ("email.php");
        if (isset($_SESSION["status"])) {
            if ($_SESSION["status"] == true)
                include_once("notif-t.php");
            else
                include_once("notif-f.php");
            $_SESSION["status"] = null;
            $_SESSION["message"] = null;
        }
        if (isset($_POST['e-mail']))
        {
            $email = $_POST['e-mail'];
//            echo "email = $email" . PHP_EOL ;
            $db->query("USE " . $DB_NAME);
            try {
                $query = $db->query('SELECT * FROM users WHERE email = '. $db->quote($email));
            }
            catch (PDOException $e)
            {
                echo "error : " . $e->getMessage();
            }
            $count = $query->rowCount();
            $res = $query->fetch(PDO::FETCH_OBJ);
            if ($count)
            {
                reset_passwd_email($email, $res->token);
                $_SESSION["status"] = true;
                $_SESSION["message"] = "An email has been sent";
            }
            else
            {
                $_SESSION["status"] = false;
                $_SESSION["message"] = "Email can't be send";
            }
            header("Location: http://localhost:8080/camagru_ok/public/forgotpassword.php");
        }
    ?>
</html>