<?php

require_once("database.php");
require_once("../utils/db_utils.php");

try
{
	echo "\n\n-=-=-=-=-     LAUNCHING setup.php     -=-=-=-=-\n\n";
	sleep (1);

	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
	echo "+++ CONNECTED TO MYSQL +++\n";

	$db->exec("DROP DATABASE IF EXISTS db_camagru; CREATE DATABASE IF NOT EXISTS db_camagru;");
	echo "+++ DATABASE 'db_camagru' HAS BEEN CREATED +++\n";

	$table_users =	"id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		username TEXT,
		password TEXT,
		email TEXT,
		verified BOOLEAN NOT NULL DEFAULT FALSE,
		notif BOOLEAN NOT NULL DEFAULT TRUE,
		token TEXT";

	$table_posts =	"id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		user_id INT NOT NULL,
		path_img TEXT NOT NULL";

	$table_coms =	"post_id INT NOT NULL,
		user_id INT NOT NULL,
		creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		message TEXT";

	$table_likes = 	"post_id INT NOT NULL,
		user_id INT NOT NULL";

	$db->exec("CREATE TABLE IF NOT EXISTS db_camagru.users ($table_users) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci");
	$db->exec("CREATE TABLE IF NOT EXISTS db_camagru.posts ($table_posts) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci");
	$db->exec("CREATE TABLE IF NOT EXISTS db_camagru.coms ($table_coms) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci");
	$db->exec("CREATE TABLE IF NOT EXISTS db_camagru.likes ($table_likes) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci");

	echo "+++ TABLES HAVE BEEN CREATED +++\n";

	db_add("users", array(	"username"	=> $ADMIN_NAME,
		"password"	=> hash("whirlpool", $ADMIN_PW),
		"email"		=> $ADMIN_MAIL,
		"verified"	=> TRUE,
		"notif"		=> 0), $db);

	echo "+++ ADMIN ACCOUNT HAS BEEN CREATED +++\n";

	if (!file_exists("../public/img"))
		mkdir ("../public/img");
	if (!file_exists("../public/img/photos"))
		mkdir ("../public/img/photos");

	echo "+++ DIRECTORIES HAVE BEEN CREATED +++\n";
	echo "\n-=-=-=-=- setup.php has been executed -=-=-=-=-\n\n\n";
}
catch (Exception $e)
{
	echo "--- CONNECTION FAILED ---\n\n";
	die('ERROR : ' . $e->getMessage());
}
?>
