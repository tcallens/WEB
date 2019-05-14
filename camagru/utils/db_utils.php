<?php

require_once("../config/database.php");
require_once("../public/email.php");

$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);

function db_add($table, array $entry, $db)
{
	$sql = "INSERT INTO db_camagru.".$table." (".implode(", ", array_keys($entry)).") VALUES ('".implode("', '", array_values($entry))."')";
	$query = $db->prepare($sql);
	$query->execute();
}

function new_user($username, $passwd, $c_passwd, $email, $db)
{
	if (!is_passwd($passwd))
	{
		$stat = array("status" => false, "message" => "your password is not enough safe.");
	}
	else if (!isEqual(hash("whirlpool", $passwd), hash("whirlpool", $c_passwd)))
		$stat = array("status" => false, "message" => "Your passwords are differents.");
	else
	{
		$stat = array("status" => true, "message" => "You have to validate your account.");
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$stat = ["status" => false, "message" => "The email specified is not correct."];
		if (db_check('users', 'username', $username, $db))
			$stat = ["status" => false, "message" => "Username already taken."];
		if (db_check('users', 'email', $email, $db))
			$stat = ["status" => false, "message" => "Email address already taken."];
		if ($stat["status"] == true)
		{
			$token = uniqid();
			db_add("users", array("username" => $username,
				"password" => hash("whirlpool", $passwd),
				"email" => $email,
				"verified" => 0,
				"token" => $token), $db);
			confirm_email($username, $token, $email);
		}
	}
	return $stat;
}

function login_user($username, $passwd, $db)
{
	$stat = array("status" => true, "message" => "You are log in.");
	if (!db_check("users", "username", $username, $db))
		$stat = ["status" => false,"message" => "Username doesn't exist."];
	if (db_check("users", "username", $username, $db) && (db_get('users', 'username', $username, 'password', $db) !== hash('whirlpool', $passwd)))
		$stat = ["status" => false, "message" => "The username or password is incorrect."];
	if (db_check("users", "username", $username, $db) && db_get("users", "username", $username, "verified", $db) == 0)
		$stat = ["status" => false, "message" => "You have to activate your account via email."];
		return $stat;
}

function db_check($table, $column, $value, $db)
{
	$query = $db->prepare("SELECT * FROM db_camagru.".$table." WHERE ".$column."  = ?");
	$query->execute([$value]);
	$count = $query->rowCount();
	if ($count === 1)
		return true;
	else
		return false;
}

function db_update($table, $column, $old, $tomodify, $value, $db)
{
	$sql = "UPDATE db_camagru.".$table." SET ".$tomodify." = '".$value."' WHERE ".$column." = '".$old."'";
	$query = $db->prepare($sql);
	$query->execute();
}

function db_get($table, $column, $value, $ret, $db)
{
	$query = $db->prepare("SELECT * FROM db_camagru.".$table." WHERE ".$column." = ?");
	$query->execute([$value]);
	$result = $query->fetchAll();
	return ($ret ? $result[0][$ret] : $result);
}

function db_array($table, $db)
{
	$query = $db->prepare("SELECT * FROM db_camagru.".$table);
	$query->execute();
	return ($query->fetchAll());
}


function is_passwd($passwd)
{
	if (preg_match("^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*^", $passwd))
		return true;
	else
		return false;
}

function isEqual($passwd, $c_passwd)
{
    return ($c_passwd == $passwd) ? true : false;
}

function delete_like($post_id, $user_id, $db) {
	$query = $db->prepare("DELETE FROM db_camagru.likes WHERE post_id = ? AND user_id = ?");
	$query->execute([$post_id, $user_id]);
}
?>
