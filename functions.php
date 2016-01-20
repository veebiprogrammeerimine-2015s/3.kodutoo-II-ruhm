<?php

	require_once("../config.php");
	require_once("User.class.php");
	
	
	$database = "if15_vitamak";
	
	session_start();
	
	//loome ab'i ühenduse
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//Uus instants klassist User
	$User = new User($mysqli);
	
	//var_dump($User->connection);
	//loome uue funktsiooni, et küsida ab'ist andmeid
	
	
	
	
	function getUserData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_kd");
		$stmt->bind_result($id, $user_email);
		$stmt->execute();

		
		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$car = new StdClass();
			$car->id = $id;
			$car->email = $user_email;
			
			// lisame selle massiivi
			array_push($array, $car);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
		
	}
	
	function updateComment($send_tekst){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		echo $mysqli->error;
		$stmt = $mysqli->prepare("INSERT INTO text_kd (user_id, text) VALUES (?,?)");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $send_tekst);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "EDUKALT SALVESTANUD!";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		
	}
	
	function getTextData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT post_kd, user_id, text FROM text_kd");
		$stmt->bind_result($post_kd, $user_id, $text);
		$stmt->execute();

		
		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$post = new StdClass();
			$post->post_kd = $post_kd;
			$post->user_id = $user_id;
			$post->text = $text;
			
			// lisame selle massiivi
			array_push($array, $post);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
		
	}
	
	function getEmailData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT email FROM user_kd");
		$stmt->bind_result($table_email);
		$stmt->execute();

		
		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$tablenew = new StdClass();
			$tablenew->emailtable = $table_email;
			
			// lisame selle massiivi
			array_push($array, $tablenew);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
		
	}
	
	function deletePost($delete_post_data){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE text_kd SET deleted=NOW() WHERE post_kd=?");
		$stmt->bind_param("i", $delete_post_data);
		
		if($stmt->execute()){
			// sai edukalt kustutatud
			header("Location: table_post.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getSelfData(){
		
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("SELECT post_kd, user_kd.id, user_kd.email, text FROM text_kd JOIN user_kd ON text_kd.user_id=user_kd.id WHERE user_kd.id = ?");
			$stmt->bind_param("i", $_SESSION["id_from_db"]);
			$stmt->bind_result($post_data, $user_data, $user_email_data, $text_data);
			$stmt->execute();

			
			// tühi massiiv kus hoiame objekte (1 rida andmeid)
			$array = array();
			
			// tee tsüklit nii mitu korda, kui saad 
			// ab'ist ühe rea andmeid
			while($stmt->fetch()){
				
				// loon objekti iga while tsükli kord
				$self_data = new StdClass();
				$self_data->post_kd = $post_data;
				$self_data->user_kd_id = $user_data;
				$self_data->user_kd_email = $user_email_data;
				$self_data->text = $text_data;
				
				// lisame selle massiivi
				array_push($array, $self_data);
				//echo "<pre>";
				//var_dump($array);
				//echo "</pre>";
				
			}
			
			$stmt->close();
			$mysqli->close();
			
			return $array;
	}

	
	function updatePost($up_text, $up_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$mysqli->error;
		$stmt = $mysqli->prepare("UPDATE text_kd SET text=? WHERE post_kd=?");
		$stmt->bind_param("si", $up_text, $up_id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "edukalt salvestanud!!!!";
		}
		
		
		$stmt->close();
		$mysqli->close();
		}
?>