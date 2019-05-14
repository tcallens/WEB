<!doctype html>
<html>
	<?php include_once("./static/head.php"); ?>
	<?php include_once("./static/header.php"); ?>
		<div id="redirect">
			<?php
			$status = $_GET["err"];
			$codes = array(
				400 => array("400 bad request", "The request cannot be fulfilled due to bad syntax."),
				403 => array("403 forbidden", "The server has refused to fulfil your request."),
				404 => array("404 not found", "The page you requested was not found on this server."),
				405 => array("405 method not allowed", "The method specified in the request is not allowed for the specified resource."),
				408 => array("408 request timeout", "Your browser failed to send a request in the time allowed by the server."),
				500 => array("500 internal server error", "The request was unsuccessful due to an unexpected condition encountered by the server."),
				502 => array("502 bad gateway", "The server received an invalid response while trying to carry out the request."),
				504 => array("504 gateway timeout", "The upstream server failed to send a request in the time allowed by the server."),
			);
			$title = $codes[$status][0];
			$message = $codes[$status][1];
			if (empty($title) || strlen($status) !== 3) {
				$message = "Please supply a valid HTTP status code.";
			echo "<p>".$message."</p>";
			}
			else
				echo "<h1>oops, ".$title." encountered</h1><p>".$message."</p>";
			?>
		</div>
	<?php include_once("./static/footer.php"); ?>
</html>

