<?php
	//functions
	
	require_once("../../configglobal.php");
	$database = "if15_rimo";
	
	//funktsioon et küsida andmebaasist andmeid
	function getPostData(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, post_title, post FROM user_posts WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id, $post_title, $post);
		$stmt->execute();
		
		//tühi masiiv kus hoiame objekte(1rida andmeid)
		$array = array();
		//tee tsüklit nii palju kordi kui saad ab'st ühe rea andmeid
		while($stmt->fetch()){
			//loon objekti
			$car = new StdClass();
			$car->id = $id;
			$car->post_title = $post;
			$car->post = $post;
			$car->user_id = $user_id;
			array_push($array, $posts);
		}
		$stmt->close();
		$mysqli->close();
		return $array;
	}
	
	function deletePost($id_to_be_deleted){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE user_posts SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		if($stmt->execute()){
			//kui on edukas
			header("Location: table.php");
		}
		$stmt->close();
		$mysqli->close();
	}
?>