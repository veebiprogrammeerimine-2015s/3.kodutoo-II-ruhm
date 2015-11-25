<?php
//Kõik andmebaasiga seonduv siin

//ühenduse loomiseks kasuta
	require_once("../../configglobal.php");
	$database = "if15_jarmhab";
	
	session_start();
	
	//lisame kasutaja andmebaasi
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
	
	//rääma pargis mängu alustamine
	function createGameRaama($game_name){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO discgolf_raama (user_id, game_name, basket1_par, basket2_par, basket3_par, basket4_par, basket5_par, basket6_par, basket7_par, basket8_par, basket9_par) VALUES (?, ?, '3', '3', '3', '3', '3', '3', '3', '3', '3')");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $game_name);
		
		
		
		if($stmt->execute()){
			//see on tõene, kui sisestus ab'i õnnestus
			$message = "Mäng edukalt loodud!";
			
		}else {
			// kui miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		
		
		
		//kuidas siin ikkagi mängu id kätte saaks, et selle järgi tulemusi salvestada?
		
		/* $stmt = $mysqli->prepare("SELECT id FROM discgolf_raama WHERE user_id=? AND game_name=?");
		echo $mysqli->error;
		$stmt->bind_param("is", $_SESSION["id_from_db"], $game_name);
		
		$stmt->bind_result($game_id);
				$stmt->execute();
		
		$_SESSION["game_id"] = $game_id;
		
		$mysqli->close(); */		
	
		return $message;
	}
	//tulemuste salvestamine toimub siin
	function saveBasket($nr, $result){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE discgolf_raama SET basket".$nr."_result=? WHERE user_id=?");
		$stmt->bind_param("is", $result, $_SESSION["id_from_db"]);
		if($stmt->execute()){
			//see on tõene, kui sisestus ab'i õnnestus
			$message = "Tulemus salvestatud!";
			
		}else {
			// kui miski läks katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();		
	
		return $message;
	
	}
	
	//Loome uue funktsiooni, et ab'st andmeid saada
	function getGameData(){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT basket1_par, basket1_result, comment FROM discgolf_raama");
	
	
	$stmt->execute();
	
			// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$game_raama = new StdClass();
			$game_raama->basket1_par = $basket1_par;
			$game_raama->basket1_result = $basket1_result;
			$game_raama->comment = $comment;
			
			// lisame selle massiivi
			array_push($array, $game_raama);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
	
	
	}
?>