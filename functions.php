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
		$stmt = $mysqli->prepare("INSERT INTO text_kd (user_id, text) VALUES (?,?,?)");
		$stmt->bind_param("s", $_SESSION["id_from_db"], $send_tekst);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "jeeee";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		
	}
	
	
	

?>