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
		
		
		/*
		$stmt = $mysqli->prepare("SELECT id FROM discgolf_raama WHERE user_id=? AND game_name=?");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $game_name);
		
		$stmt->bind_result($game_id);
		$stmt->execute();
		if($stmt->fetch()){
			
			//oli olemas 
			return>
		}
		
		$stmt->close();
		
		*/
		
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
		
		
		
		//küsin mängu id
		
		$stmt = $mysqli->prepare("SELECT id FROM discgolf_raama WHERE user_id=? AND game_name=?");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $game_name);
		
		$stmt->bind_result($game_id);
		$stmt->execute();
		if($stmt->fetch()){
			$_SESSION["game_id"] = $game_id;
		}
		
		
		$stmt->close(); 	
	
		return $message;
	}
	//tulemuste salvestamine toimub siin
	function saveBasket($nr, $result){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE discgolf_raama SET basket".$nr."_result=? WHERE id=?");
		$stmt->bind_param("is", $result, $_SESSION["game_id"]);
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
	
	$stmt = $mysqli->prepare("SELECT basket1_par, basket1_result, basket2_par, basket2_result, basket3_par, basket3_result, basket4_par, basket4_result, basket5_par, basket5_result, basket6_par, basket6_result, basket7_par, basket7_result, basket8_par, basket8_result, basket9_par, basket9_result, comment FROM discgolf_raama WHERE id=?");
	$stmt->bind_param("i", $_SESSION["game_id"]);
	$stmt->bind_result($basket1_par, $basket1_result, $basket2_par, $basket2_result, $basket3_par, $basket3_result, $basket4_par, $basket4_result, $basket5_par, $basket5_result, $basket6_par, $basket6_result, $basket7_par, $basket7_result, $basket8_par, $basket8_result, $basket9_par, $basket9_result, $comment );
	
	
	
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
			$game_raama->basket2_par = $basket2_par;
			$game_raama->basket2_result = $basket2_result;
			$game_raama->basket3_par = $basket3_par;
			$game_raama->basket3_result = $basket3_result;
			$game_raama->basket4_par = $basket4_par;
			$game_raama->basket4_result = $basket4_result;
			$game_raama->basket5_par = $basket5_par;
			$game_raama->basket5_result = $basket5_result;
			$game_raama->basket6_par = $basket6_par;
			$game_raama->basket6_result = $basket6_result;
			$game_raama->basket7_par = $basket7_par;
			$game_raama->basket7_result = $basket7_result;
			$game_raama->basket8_par = $basket8_par;
			$game_raama->basket8_result = $basket8_result;
			$game_raama->basket9_par = $basket9_par;
			$game_raama->basket9_result = $basket9_result;
			$game_raama->comment = $comment;
			
			
			// lisame selle massiivi
			array_push($array, $game_raama);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	
	//küsin siin ab-st tulemuste summa
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT (basket1_result + basket2_result + basket3_result + basket4_result + basket5_result + basket6_result + basket7_result + basket8_result + basket9_result) as total_result, (basket1_par+basket2_par+basket3_par+basket4_par+basket5_par+basket6_par+basket7_par+basket8_par+basket9_par) as total_par, ((basket1_result + basket2_result + basket3_result + basket4_result + basket5_result + basket6_result + basket7_result + basket8_result + basket9_result)-(basket1_par+basket2_par+basket3_par+basket4_par+basket5_par+basket6_par+basket7_par+basket8_par+basket9_par)) as difference FROM discgolf_raama WHERE id=?");
		$stmt->bind_param("i", $_SESSION["game_id"]);
		echo $stmt->error;
		$stmt->bind_result($total_result, $total_par, $difference);
		
		$stmt->execute();
		
		if($stmt->fetch()){
			$_SESSION["total_result"] = $total_result;
			$_SESSION["total_par"] = $total_par;
			$_SESSION["difference"] = $difference;
		}
		
		$stmt->close();
		$mysqli->close();
		
	//loon funktsiooni mängude ajaloo jaoks
		function getGameHistory(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT date, game_name FROM discgolf_raama WHERE user_id=?");
		$stmt->bind_param("i", $_SESSION["id_from_db"]);
		$stmt->bind_result($game_date, $game_name);
		
		$stmt->execute();
			$array = array();
			while($stmt->fetch()){
				
				$game_history = new StdClass();
				$game_history->date = $game_date;
				$game_history->game_name = $game_name;
				
				array_push($array, $game_history);
			}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
			
		}

?>
