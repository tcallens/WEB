<?php
//    include ("capture.js");
    include_once("../utils/db_utils.php");
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_POST['img']))
        {
            $img = $_POST['img'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $imgData = base64_decode($img);
            $imgName = 'img/photos/photo_'. mktime() .'.png';

            if (isset($_POST['srcFilters']))
            {
                $x = (int)$_POST['x'];
                $y = (int)$_POST['y'];
                $w = (int)$_POST['w'];
                $h = (int)$_POST['h'];
                $urlFilter = explode("public/", $_POST['srcFilters']);
                $imgData = imagecreatefromstring($imgData);
                imagealphablending($imgData, true);
                imagesavealpha($imgData, true);
                $src = imagecreatefrompng(__DIR__ . "/" . $urlFilter[1]);
                imagecopyresized($imgData, $src, $x, $y, 0, 0, $w, $h, imagesx($src), imagesy($src));
                imagedestroy($src);
                imagepng($imgData, $imgName);
                imagedestroy($imgData);
            }
            file_put_contents($imgName, $imgData);
            db_add("posts", array("user_id" => $_SESSION['id_user'], "path_img" => $imgName), $db);
            $_SESSION["status"] = true;
            $_SESSION["message"] = "Your photo has been added";
            header("Location: http://localhost:8080/camagru_ok/public/camera.php");
        }
        else if(isset($_POST['del_post']))
        {
            try{
                $query = $db->prepare("DELETE FROM db_camagru.posts WHERE id = ? AND user_id = ?");
                $query->execute([$_POST['del_post'], $_SESSION['id_user']]);
            }
            catch(PDOException $e){
                $_SESSION["status"] = false;
                $_SESSION["message"] = "Error : " . $e->getMessage() ;
            }
            $_SESSION["status"] = true;
            $_SESSION["message"] = "Your photo has been deleted";
            header("Location: http://localhost:8080/camagru_ok/public/index.php");
        }
    }
?>
