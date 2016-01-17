<?php
//ANDMEBAAS
//�henduse loomiseks kasuta
	require_once("../../config.php");
	$database = "if15_koitkor_2";
	
	session_start();
	
	//kasutaja lisamine andmebaasi
	function createUser($first_name, $last_name, $create_email, $password_hash){
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
				//echo $mysqli->error;
				//echo $stmt->error;
		$stmt->bind_param("ssss", $first_name, $last_name, $create_email, $password_hash);
		$stmt->execute();
		
		//header("Location: login.php");
		
		$stmt->close();
		
		$mysqli->close();		
	}
	
	//logime sisse
	
	function loginUser($email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	
	$stmt = $mysqli->prepare("SELECT id, email FROM user WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $password_hash);
				
				//paneme vastused muutujatesse
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				if($stmt->fetch()){
					//leidis
					echo "kasutaja id=".$id_from_db;
					
					$_SESSION["id_from_db"] = $id_from_db;
					$_SESSION["user_email"] = $email_from_db;
					
					header("Location: data.php");
					
				}else{
					//tyhi ei leidnud
					echo "wrong password or email id";
				}
				
				$stmt->close();
				$mysqli->close();
	}
	
	//vaatlus
	function createResult($color, $plate,$date,$car){
		// globals on muutuja k�igist php failidest mis on �hendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO result (user_id, color, plate, date, car) VALUES (?, ?, ?,?,?)");
		$stmt->bind_param("issss", $_SESSION["id_from_db"], $color, $plate,$date,$car);
		
		if($stmt->execute()){
			//see on t�ene, kui sisestus ab'i �nnestus
			$message = "Edukalt sisestatud andmebaasi";
			
		}else {
			// kui miski l�ks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		
		$mysqli->close();		
	
		return $message;
	}
	
