<!doctype html>
<html>
<script async src="js/index.js"></script>
<?php include_once("./static/head.php"); ?>
<?php include_once("./static/header.php"); ?>
<?php
if(!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION["status"])) {
	if ($_SESSION["status"] == true)
		include_once("notif-t.php");
	else
		include_once("notif-f.php");
	$_SESSION["status"] = null;
	$_SESSION["message"] = null;
}
if (isset($_POST["new_comment"]) && isset($_POST["post_id"])) {
	if (isset($_SESSION["id_user"]))
	{
		if ($_POST["new_comment"] === "")
		{
			$_SESSION["status"] = false;
			$_SESSION["message"] = "You have to write something.";
			header("Location: http://localhost:8080/camagru_ok/public/index.php");
			die();
		}
		else
		{
			db_add("coms", array("post_id" => $_POST["post_id"], "user_id" => $_SESSION["id_user"], "message" => filter_var($_POST["new_comment"], FILTER_SANITIZE_STRING)), $db);
			$_SESSION["status"] = true;
			$_SESSION["message"] = "Your comment has been posted.";
            $user_id = db_get("posts", "id", $_POST['post_id'], 'user_id',$db);
            $isNotif = db_check("users", "notif", 1, $db);
            $_SESSION["status"] = true;
            $query = $db->prepare("SELECT * FROM db_camagru.users WHERE notif = 1 AND id = " . $user_id);
            $query->execute();
            $isNotif = $query->rowCount();
            if ($isNotif)
            {
                $res = $query->fetch(PDO::FETCH_OBJ);
                $email = $res->email;
                $user_name = db_get("users", "id", $_SESSION['id_user'], 'username',$db);
                send_comment_notif($email, $user_name, $_POST['id']);
            }
			header("Location: http://localhost:8080/camagru_ok/public/index.php");
			die();
		}
	}
	else
	{
		$_SESSION["status"] = false;
		$_SESSION["message"] = "You have to login before post something.";
		header("Location: http://localhost:8080/camagru_ok/public/index.php");
		die();
	}
}
if (isset($_POST["post_id"]) && $_POST["like"] === "like") {
    $_SESSION["status"] = true;
    $_SESSION["message"] = "You liked a post.";
    if (!isset($_SESSION["id_user"])) {
        $_SESSION["status"] = false;
        $_SESSION["message"] = "You need to login to like a post.";
        header("Location: http://localhost:8080/camagru_ok/public/index.php");
        die();
    }
    $likes = db_array("likes", $db);
    foreach($likes as $like)
    {
        if ($like["post_id"] === $_POST["post_id"] && $like["user_id"] === $_SESSION["id_user"]) {
            delete_like($like["post_id"], $like["user_id"], $db);
            $_SESSION["status"] = true;
            $_SESSION["message"] = "You unliked a post.";
            header("Location: http://localhost:8080/camagru_ok/public/index.php");
            die();
        }
    }
    db_add("likes", array("post_id" => $_POST["post_id"], "user_id" => $_SESSION["id_user"]), $db);
    $user_id = db_get("posts", "id", $_POST['post_id'], 'user_id',$db);
    $isNotif = db_check("users", "notif", 1, $db);
    $_SESSION["status"] = true;
    $query = $db->prepare("SELECT * FROM db_camagru.users WHERE notif = 1 AND id = " . $user_id);
    $query->execute();
    $isNotif = $query->rowCount();
    if ($isNotif)
    {
        $res = $query->fetch(PDO::FETCH_OBJ);
        $email = $res->email;
        $user_name = db_get("users", "id", $_SESSION['id_user'], 'username',$db);
        send_like_notif($email, $user_name, $_POST['id']);
    }
    header("Location: http://localhost:8080/camagru_ok/public/index.php");
    die();
}
?>
	<div id="new-news">
		<form action="camera.php">
			<button type="submit" class="button-news">Do you want to tell your life ?</button>
		</form>
	</div>
	<div id="news">
		<?php
$posts = array_reverse(db_array("posts", $db));
foreach ($posts as $post)
{
	$img = $post["path_img"];
	$date = $post["creation_date"];
	$from_user = db_get("users", "id", $post["user_id"], "username", $db);
	$coms = db_get("coms", "post_id", $post["id"], null, $db);
	$likes = count(db_get("likes", "post_id", $post["id"], null, $db));
?>
		<div class="news-cont">
			<div class="date"><?= $date ?></div>
			<div class="likes"><?= $likes ?> Likes</div>
				<form method="POST" action="#">
				<div class="likes-t">
					<input type="hidden" name="post_id" value="<?= $post["id"] ?>">
					<button type="submit" class="but-like" name="like" value="like"><?php
	$likes = db_array("likes", $db);
	$is_like = 0;
	foreach($likes as $like)
	{
		if ($like["post_id"] === $post["id"] && $like["user_id"] === $_SESSION["id_user"])
			$is_like = 1;
	}
	if ($is_like == 0)
		echo "LIKE";
	else
		echo "UNLIKE";
?></button>
				</div>
				</form>
			<?php
			if (file_exists($img))
			{
			?>
				<img class="img" src="<?= $img ?>" width="400" height="400" />
			<?php }
			else {?>
				<img class="img" src="./img/no_img.png" width="400" height="400" />
			<?php } ?>
			<div class="news-data">
			<div class="news-data-user">
				<span><?= $from_user ?></span>
			</div>
			<div class="news-data-coms">
<?php
	foreach ($coms as $com)
	{
		$user = db_get("users", "id", $com["user_id"], "username", $db);
		echo '<p><b>'.$user.':</b> '.$com["message"].'</p>';
	}
?>	
			</div>
			<div class="news-data-post">
				<form method="POST" action="#">
					<input class="data-form "type="hidden" name="post_id" value="<?= $post["id"] ?>">
					<input class="data-form" type="text" name="new_comment" placeholder="write something?">
					<button type="submit" class="button" >submit</button>
				</form>
			</div>
		</div>
		</div>
		<?php } ?>
	</div>
	<?php include_once("./static/footer.php"); ?>
</html>
