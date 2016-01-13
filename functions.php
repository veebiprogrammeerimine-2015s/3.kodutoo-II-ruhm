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
	
	
	
		function getMailData(){
		
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
			$stmt = $mysqli->prepare("SELECT comment_id, user_id, text FROM eksam_comment WHERE send_email = ?");
			$stmt->bind_param("s", $_SESSION["user_email"]);
			$stmt->bind_result($comment_id, $id_mail, $text);
			$stmt->execute();

			
			// tühi massiiv kus hoiame objekte (1 rida andmeid)
			$array = array();
			
			// tee tsüklit nii mitu korda, kui saad 
			// ab'ist ühe rea andmeid
			while($stmt->fetch()){
				
				// loon objekti iga while tsükli kord
				$mail = new StdClass();
				$mail->comment_id = $comment_id;
				$mail->id_mail = $id_mail;
				$mail->text = $text;
				
				// lisame selle massiivi
				array_push($array, $mail);
				//echo "<pre>";
				//var_dump($array);
				//echo "</pre>";
				
			}
			
			$stmt->close();
			$mysqli->close();
			
			return $array;
	}
	
	
	

?>