<!doctype html>
<html>
	<?php include_once("./static/head.php"); ?>
	<?php include_once("./static/header.php"); ?>
<?php
	echo '<div style="margin-top:100px;">';
    $db->query("USE ". $DB_NAME);
    $query = $db->prepare('SELECT * FROM users WHERE username="?" AND token="?"');
    try {
        $ret = $query->execute(array(urldecode($_GET['username']), $_GET['token']));
    }
    catch (PDOException $e)
    {
        echo "error: query not executed: " . $e->getMessage();
        echo "<br/><a href='index.php'>Cliquez ici pour retourner a l'accueil</a>";
        die();
    }
    if ($ret)
    {
        try {
            $sql = "UPDATE " . $DB_NAME . ".users SET verified=1 WHERE username=\"". urldecode($_GET['username']) ."\" AND verified=0";
            $query = $db->prepare($sql);
            $query->execute();
        }
        catch (PDOException $e)
        {
            echo "error: 'verified' not update:" . $e->getMessage();
            echo "<br/><a href='index.php'>Cliquez ici pour retourner a l'accueil</a>";
            die();
        }
        if (!$query->rowCount())
            echo "this account already updated<br/><a href='index.php'>Cliquez ici pour retourner a l'accueil</a>";
        else
            echo "succesfull confirmation for this account<br/><a href='index.php'>Cliquez ici pour retourner a l'accueil</a>";
    }
    else
    {
        echo "error: account not found or wrong token" . PHP_EOL;
        echo "<br/><a href='index.php'>Cliquez ici pour retourner a l'accueil</a>";
        die();
	}
	echo '</div>';
?>
<?php include_once("./static/footer.php"); ?>
