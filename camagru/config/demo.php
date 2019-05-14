<?php

include_once("../utils/db_utils.php");

echo "-=-=-=-=-     LAUNCHING demo.php     -=-=-=-=-\n\n";


try {

	$users = array(
		"Rick",
		"Morty",
		"Jerry",
		"Beth",
		"Summer",
		"Jessica",
		"Mr. Goldenfold",
		"Gene Vagin",
		"Condorman",
		"Squanchy",
		"Evil Morty"
	);
	foreach ($users as $user) {
		db_add("users", array("username" => $user, "password" => hash("whirlpool", "demo"), "email" => $user."@camagrick.fr", "verified" => TRUE), $db);
	}
	echo "+++ FAKE USERS HAVE BEEN CREATED +++\n";

	for ($i = 1; $i <= 11; $i++) {
		db_add("posts", array("user_id" => rand(2, 12), "path_img" => "./img/demo/".$i.".jpg"), $db);
	}
	echo "+++ FAKE POSTS HAVE BEEN CREATED +++\n";

	$coms = "BELGIQUEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE";
	for ($i = 2; $i <= 12; $i++) {
		for ($j = 1; $j <= 11; $j++) {
			$num = rand(0, 80000000);
			db_add("coms", array("post_id" => $j, "user_id" => $i, "message" => $coms.$num), $db);
		}
	}
	echo "+++ FAKE COMS HAVE BEEN CREATED +++\n";

	for ($i = 2; $i <= 12; $i++) {
		for ($j = 1; $j <= 11; $j++) {
			$num = rand(0, 1);
			if ($num ==1)
				db_add("likes", array("post_id" => $j, "user_id" => $i), $db);
		}
	}

	echo "+++ FAKE LIKES HAVE BEEN CREATED +++\n";

	echo "\n-=-=-=-=- demo.php has been executed -=-=-=-=-\n\n\n";
}
catch (Exception $e)
{
	echo "--- demo.php FAILED ---\n\n";
	die('ERROR : ' . $e->getMessage());
}
?>
