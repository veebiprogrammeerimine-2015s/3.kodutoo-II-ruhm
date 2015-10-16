<?php
	//Kõik AB'iga seotud
	
	//ühenduse loomiseks kasutajaga
	require_once("../../configglobal.php");
	$database = "if15_rimo";

	//pamene sessioni käima, saame kasutada $_SESSION muutujaid
	session_start();
	
	//lisame kasutaja andmebaasi
	function createUser($Cemail, $password_hash, $Cusername){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_info (email, password, username) VALUES (?, ?, ?)");
		//?? saavad väärtused
		$stmt->bind_param("sss", $Cemail, $password_hash, $Cusername);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	//logime sisse
	function loginUser($email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id FROM user_info WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		//vastuse muutujatesse				
		$stmt->bind_result($id_from_db);
		$stmt->execute();
		//kas saime andmebaasist kätte?
		if($stmt->fetch()){
			echo " Logged in with user id=".$id_from_db." email ".$email_from_db;
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email;
			
			//suuname kasutaja data.php lehele
			header("Location: data.php");
		}else{
			echo "Wrong password or email";
		}
		$stmt->close();
		$mysqli->close();
	}
	function createCarPlate ($car_plate, $color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $car_plate, $color);
		$message = "";
		if($stmt->execute()){
			//täpne kui sisestus AB'i õnnestus
			$message = "Numbrimärk on sisestatud";
		}else{
			//kui midagi läks sisestuse käigus katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $message;
	}
?>