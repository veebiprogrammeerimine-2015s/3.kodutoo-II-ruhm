<?php
	require_once("../../configglobal.php");
	$database = "if15_rimo";
		
	function getSinglePostData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT post_title, post FROM user_posts WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($post_title, $post);
		$stmt->execute();
		$posts = new Stdclass();
		if($stmt->fetch()){
			$posts->post_title = $post_title;
			$posts->post = $post;
		}else{
			//ei saanud andmeid kätte, sellist id'd ei ole või on kustutatud
			//header("Location: home.php");
			echo("test");
		}
		return $posts;
		
		$stmt->close();
		$mysqli->close();
	}
	function updatePost($id, $post_title, $post){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE user_posts SET post_title=?, post=? WHERE id=? AND user_id=?");
		$stmt->bind_param("ssii", $post_title, $post, $id, $_SESSION["id_from_db"]);
		//kas õnnestus salvestada
		if($stmt->execute()){
			//echo"jee";
		}else{	
		}
		$stmt->close();
		$mysqli->close();
	}
?>