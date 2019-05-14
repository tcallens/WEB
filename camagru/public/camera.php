<!doctype html>
<html lang="fr">

	<?php include_once("../utils/db_utils.php"); ?>
	<?php include_once("../public/static/head.php"); ?>
	<?php include_once("../public/static/header.php"); ?>
<?php
if (!isset($_SESSION["id_user"])) {
	include_once("../public/redirect.php");
	die();
}
?>
	<div class="main_cam_container">
		<div class="camera">
			<!--balise qui contiendra l'affichage video-->
			<video id="webcam" autoplay>Video stream not available</video>
			<img id="upload_image" src="" alt="image upload from computer" style="display: none"/>

			<!--emplacement reservé au filtre apres avoir cliquer sur les bouttons radio -->
			<div class="output">
				<img style="display: none" id="webcamFilter" alt="The filter will appear in this box." src="">
			</div>
		</div>

		<div class="config">
			<form id="f_upload" method="post" enctype="multipart/form-data">
				<input type="file" name="images[]" id="inputfile" multiple>
				<p style="display: none" id="error"></p>
				<input type="submit" value="Upload File" name="submit">
				<div id="fileList"></div>
			</form>

			<div class="select_filter">
				<input type="radio" id="rick_and_morty_portal"
					   name="filter" value="">
				<label for="rick_and_morty_portal"><img class="ri_btn" alt="rick and morty portal filter" src="img/filters/rick_and_morty_portal.png"/></label>

				<input type="radio" id="rickornichon"
					   name="filter" value="">
				<label for="rickornichon"><img class="ri_btn" alt="rickornichon filter" src="img/filters/rickornichon.png"/></label>

				<input type="radio" id="jerry_portal"
					   name="filter" value="">
				<label for="jerry_portal"><img  class="ri_btn" alt="jerry portal filter" src="img/filters/jerry_portal.png"/></label>

				<input type="radio" id="rick_morty_title"
					   name="filter" value="">
				<label for="rick_morty_title"><img  class="ri_btn" alt="rick and morty title filter" src="img/filters/rick_morty_title.png"/></label>

				<input type="radio" id="f_none"
					   name="filter" value="f_none">
				<label for="f_none" id="txt_none">Aucun</label>
			</div>
			<div id="takeandpost">
			<input type="button" id="takePhotoButton" value="Take photo"/>
			<button id="postPhotoButton">Post this photo</button>
			</div>
		</div>
	<!--le canvas qui va servir a stocker l'image-->
		<div class="result_photo">
			<canvas id="photo_canvas" style="display: none">
			</canvas>
	<!--            <canvas id="filter_canvas" style="display: none">-->
	<!--            </canvas>-->
		</div>
		<div id="myGallery">
<?php
try {
	$query = $db->prepare("SELECT * FROM db_camagru.posts WHERE user_id = ?");
	$query->execute([$_SESSION['id_user']]);
	$result = $query->fetchAll();
}
catch (PDOException $e)
{
	echo "<h4>error : " . $e->getMessage() ."</h4>";
}
$result = array_reverse($result, true);
foreach ($result as $res)
{
	echo "<div class='item'>";
	echo '    <form action="photoQuery.php" method="post">';
	echo '        <button class="del_btn" type=submit name="del_post" value="'. $res['id'] .'"/>Delete</button>';
	echo '    </form>';
	if(file_exists($res['path_img']))
	{
		echo '    <img src="' . $res["path_img"]. '" alt="'. $res['path_img'] .'" width="320" height="240"/>';
	}
	else
		echo '    <img src="img/no_img.png" alt="no image" width="400"/>';
	echo "</div>";
}
?>
		</div>
	</div>
	<script async src="js/camera.js"></script>
	<?php include_once("../public/static/footer.php"); ?>

</html>
