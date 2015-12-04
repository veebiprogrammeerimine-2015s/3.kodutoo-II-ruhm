<?php
	//k�ik AB'iga seonduv
	
	// �henduse loomiseks kasuta
	require_once("../configglobal.php");
	$database = "if15_tanjak";
	
	// paneme sessiooni k�ima, saame kasutada $_SESSION muutujaid
	session_start();
	
	// lisame kasutaja ab'i
	function createUser($createuseremail, $password_hash, $createuserlogin, $createuseradress, $createusertelephone){
		// globals on muutuja k�igist php failidest mis on �hendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_php (email, password, login, adress, telephone) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $createuseremail, $password_hash, $createuserlogin, $createuseradress, $createusertelephone);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();		
	}
	
	//logime sisse
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_php WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			
			//suunan kasutaja data.php lehele
			header("Location: data.php");
			
			
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	
	function createFlowerColor($flower, $color){
		// globals on muutuja k�igist php failidest mis on �hendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, flower, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $flower, $color);
		
		$message = "";
		
		if($stmt->execute()){
			// see on t�ene siis kui sisestus ab'i �nnestus
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski l�ks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $message;
		
	}