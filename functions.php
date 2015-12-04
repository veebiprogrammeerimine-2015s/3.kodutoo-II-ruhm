<?php
	
	// functions.php
	require_once("../configglobal.php");
	$database = "if15_tanjak";
	
	session_start();
	
	//loome uue funktsiooni, et küsida ab'ist andmeid
	function getFlowerData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, flower, color FROM flowers WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id, $flower, $color_from_db);
		$stmt->execute();
		
		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$fflower = new StdClass();
			$fflower->id = $id;
			$fflower->flower = $flower;
			$fflower->user_id = $user_id;
			$fflower->color = $color_from_db;
			
			// lisame selle massiivi
			array_push($array, $fflower);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
		
	}
	
	
	function deleteFlower($id_to_be_deleted){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE flowers SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		
		if($stmt->execute()){
			// sai edukalt kustutatud
			header("Location: table.php");
			
		}
		
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
	
		// lisame kasutaja ab'i
	function createUser($createuseremail, $password_hash){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO user_php (email, password, login, adress, telephone) VALUES (?, ?, ?, ?, ?)");
					$stmt->bind_param("sssss", $createuseremail, $password_hash, $createuserlogin, $createuseradress, $createusertelephone);
					$stmt->execute();
					$stmt->close(); 
					
						$mysqli->close();	
	}
		function createFlower($flower, $color){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO flowers (user_id, flower, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["id_from_db"], $flower, $color);
		
		$message = "";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab'i õnnestus
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $message;
		
	}
?>