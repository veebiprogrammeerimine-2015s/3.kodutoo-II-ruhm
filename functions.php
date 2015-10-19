<?php


	require_once("../configGLOBAL.php");
	$database = "if15_vitamak";
	
	
	// paneme sessiooni käima, saame kasutada $_SESSION muutujaid
	session_start();
	
	// lisame kasutaja ab'i
	function createUser($create_email, $password_hash, $create_name, $create_secondname, $create_age, $create_eriala){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_register1 (email, password, name, secondname, age, eriala) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ss", $create_email, $password_hash, $create_name, $create_secondname, $create_age, $create_eriala);
		
		
	}
	
	
	
	//logime sisse
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_register1 WHERE email=? AND password=?");
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
			echo " on wrong!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	
	//__________________________________________________________________________MUST WORK ON________________________________________________________
	
	function createCarPlate($car_plate, $color){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $car_plate, $color);
		$stmt->execute();
		echo $stmt->error;
		
		if($stmt->execute()){
			//see on tõene siis kui sosestus abi õnnestus
			$messege = "Edukalt sisestatud andmebaasi";
		}else{
			echo $stmt->error;
		}
		
		$stmt->close;
		
		$mysqli->close();	
		return $messege;			
	}
	
	
	
	
?>