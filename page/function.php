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
////////////////////////////////////////////
///////////                       //////////
//////////   RÄÄMA PARGI ASJAD   ///////////
//////////                       //////////
///////////////////////////////////////////
	
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
	//Rääma tulemuste salvestamine toimub siin
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
		$stmt->bind_result($total_result_raama, $total_par_raama, $difference_raama);
		
		$stmt->execute();
		
		if($stmt->fetch()){
			$_SESSION["total_result"] = $total_result_raama;
			$_SESSION["total_par"] = $total_par_raama;
			$_SESSION["difference"] = $difference_raama;
		}
		
		$stmt->close();
		$mysqli->close();
		
	//loon funktsiooni mängude ajaloo jaoks
		function getGameHistory(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, date, game_name, comment FROM discgolf_raama WHERE user_id=? AND deleted IS NULL");
		$stmt->bind_param("i", $_SESSION["id_from_db"]);
		$stmt->bind_result($game_id, $game_date, $game_name, $comment);
		
		$stmt->execute();
			$array = array();
			while($stmt->fetch()){
				
				$game_history = new StdClass();
				$game_history->id = $game_id;
				$game_history->date = $game_date;
				$game_history->game_name = $game_name;
				$game_history->comment = $comment;
				
				
				
				array_push($array, $game_history);
			}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
			
		}
		
	//mängule kommentaari jätmine
		function commentRaama($raama_comment){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE discgolf_raama SET comment=? WHERE id=?");
		$stmt->bind_param("si", $raama_comment, $_SESSION["game_id"]);
		if($stmt->execute()){
			//see on tõene, kui sisestus ab'i õnnestus
			$message = "Kommentaar lisatud!";
			
		}else {
			// kui miski läks katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();		
	
		return $message;
	
	}
		
	//mängu kustutamine
		function deleteGame($id_to_be_deleted){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
			$stmt = $mysqli->prepare("UPDATE discgolf_raama SET deleted=NOW() WHERE id=?");
			$stmt->bind_param("i", $id_to_be_deleted);
				if($stmt->execute()){
			// sai edukalt kustutatud
				header("Location: my_history.php");
			$stmt->close();
			$mysqli->close();
		
		}
		
	}
	
	//mängu nime ja kommentaari muutmine
		function editGame($id, $game_name, $comment){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
			$stmt = $mysqli->prepare("UPDATE discgolf_raama SET game_name=?, comment=? WHERE id=?");
			$stmt->bind_param("ssi", $game_name, $comment, $id);
			
			if($stmt->execute()){
				echo "Muudatused edukalt sisseviidud!";
			}
			
			$stmt->close();
			$mysqli->close();
		
	}
	
///////////////////////////////////////////////
///////////                          //////////
//////////   JÕEKÄÄRU PARGI ASJAD   ///////////
//////////                          //////////
//////////////////////////////////////////////
	
	//jõekääru pargis mängu alustamine
	function createGameJoekaaru($game_name_joekaaru){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO discgolf_joekaaru (user_id, game_name, basket1_par, basket2_par, basket3_par, basket4_par, basket5_par, basket6_par, basket7_par, basket8_par, basket9_par, basket10_par, basket11_par, basket12_par, basket13_par, basket14_par, basket15_par, basket16_par, basket17_par, basket18_par) VALUES (?, ?, '3', '3', '3', '3', '4', '3', '3', '3', '3', '4', '4', '3', '3', '3', '3', '4', '3', '3')");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $game_name_joekaaru);
		
		if($stmt->execute()){
			//see on tõene, kui sisestus ab'i õnnestus
			$message = "Mäng edukalt loodud!";
			
		}else {
			// kui miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		
		//küsin mängu id
		
		$stmt = $mysqli->prepare("SELECT id FROM discgolf_joekaaru WHERE user_id=? AND game_name=?");
		$stmt->bind_param("is", $_SESSION["id_from_db"], $game_name_joekaaru);
		
		$stmt->bind_result($game_id);
		$stmt->execute();
		if($stmt->fetch()){
			$_SESSION["game_id"] = $game_id;
		}
		
		
		$stmt->close(); 	
	
		return $message;
	}
	
	//Jõekääru tulemuste salvestamine toimub siin
	function saveJoekaaru($nr, $result){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE discgolf_joekaaru SET basket".$nr."_result=? WHERE id=?");
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
	
	

	//Loome uue funktsiooni, et ab'st Jõekääru andmeid saada
	function getJoekaaruData(){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT basket1_par, basket1_result, basket2_par, basket2_result, basket3_par, basket3_result, basket4_par, basket4_result, basket5_par, basket5_result, basket6_par, basket6_result, basket7_par, basket7_result, basket8_par, basket8_result, basket9_par, basket9_result, basket10_par, basket10_result, basket11_par, basket11_result, basket12_par, basket12_result, basket13_par, basket13_result, basket14_par, basket14_result, basket15_par, basket15_result, basket16_par, basket16_result, basket17_par, basket17_result, basket18_par, basket18_result, comment FROM discgolf_joekaaru WHERE id=?");
	$stmt->bind_param("i", $_SESSION["game_id"]);
	$stmt->bind_result($basket1_par, $basket1_result, $basket2_par, $basket2_result, $basket3_par, $basket3_result, $basket4_par, $basket4_result, $basket5_par, $basket5_result, $basket6_par, $basket6_result, $basket7_par, $basket7_result, $basket8_par, $basket8_result, $basket9_par, $basket9_result, $basket10_par, $basket10_result, $basket11_par, $basket11_result, $basket12_par, $basket12_result, $basket13_par, $basket13_result, $basket14_par, $basket14_result, $basket15_par, $basket15_result, $basket16_par, $basket16_result, $basket17_par, $basket17_result, $basket18_par, $basket18_result, $comment );
	
	
	
	$stmt->execute();
	
			// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$game_joekaaru = new StdClass();
			$game_joekaaru->basket1_par = $basket1_par;
			$game_joekaaru->basket1_result = $basket1_result;
			$game_joekaaru->basket2_par = $basket2_par;
			$game_joekaaru->basket2_result = $basket2_result;
			$game_joekaaru->basket3_par = $basket3_par;
			$game_joekaaru->basket3_result = $basket3_result;
			$game_joekaaru->basket4_par = $basket4_par;
			$game_joekaaru->basket4_result = $basket4_result;
			$game_joekaaru->basket5_par = $basket5_par;
			$game_joekaaru->basket5_result = $basket5_result;
			$game_joekaaru->basket6_par = $basket6_par;
			$game_joekaaru->basket6_result = $basket6_result;
			$game_joekaaru->basket7_par = $basket7_par;
			$game_joekaaru->basket7_result = $basket7_result;
			$game_joekaaru->basket8_par = $basket8_par;
			$game_joekaaru->basket8_result = $basket8_result;
			$game_joekaaru->basket9_par = $basket9_par;
			$game_joekaaru->basket9_result = $basket9_result;
			$game_joekaaru->basket10_par = $basket10_par;
			$game_joekaaru->basket10_result = $basket10_result;
			$game_joekaaru->basket11_par = $basket11_par;
			$game_joekaaru->basket11_result = $basket11_result;
			$game_joekaaru->basket12_par = $basket12_par;
			$game_joekaaru->basket12_result = $basket12_result;
			$game_joekaaru->basket13_par = $basket13_par;
			$game_joekaaru->basket13_result = $basket13_result;
			$game_joekaaru->basket14_par = $basket14_par;
			$game_joekaaru->basket14_result = $basket14_result;
			$game_joekaaru->basket15_par = $basket15_par;
			$game_joekaaru->basket15_result = $basket15_result;
			$game_joekaaru->basket16_par = $basket16_par;
			$game_joekaaru->basket16_result = $basket16_result;
			$game_joekaaru->basket17_par = $basket17_par;
			$game_joekaaru->basket17_result = $basket17_result;
			$game_joekaaru->basket18_par = $basket18_par;
			$game_joekaaru->basket18_result = $basket18_result;
			$game_joekaaru->comment = $comment;
			
			
			// lisame selle massiivi
			array_push($array, $game_joekaaru);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	
	//küsin siin ab-st tulemuste summa
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT (basket1_result + basket2_result + basket3_result + basket4_result + basket5_result + basket6_result + basket7_result + basket8_result + basket9_result + basket10_result + basket11_result + basket12_result + basket13_result + basket14_result + basket15_result + basket16_result + basket17_result + basket18_result) as total_result_joekaaru, (basket1_par+basket2_par+basket3_par+basket4_par+basket5_par+basket6_par+basket7_par+basket8_par+basket9_par+basket10_par+basket11_par+basket12_par+basket13_par+basket14_par+basket15_par+basket16_par+basket17_par+basket18_par) as total_par_joekaaru, ((basket1_result + basket2_result + basket3_result + basket4_result + basket5_result + basket6_result + basket7_result + basket8_result + basket9_result + basket10_result + basket11_result + basket12_result + basket13_result + basket14_result + basket15_result + basket16_result + basket17_result + basket18_result)-(basket1_par+basket2_par+basket3_par+basket4_par+basket5_par+basket6_par+basket7_par+basket8_par+basket9_par+basket10_par+basket11_par+basket12_par+basket13_par+basket14_par+basket15_par+basket16_par+basket17_par+basket18_par)) as difference_joekaaru FROM discgolf_joekaaru WHERE id=?");
		$stmt->bind_param("i", $_SESSION["game_id"]);
		echo $stmt->error;
		$stmt->bind_result($total_result_joekaaru, $total_par_joekaaru, $difference_joekaaru);
		
		$stmt->execute();
		
		if($stmt->fetch()){
			$_SESSION["total_result"] = $total_result_joekaaru;
			$_SESSION["total_par"] = $total_par_joekaaru;
			$_SESSION["difference"] = $difference_joekaaru;
		}
		
		$stmt->close();
		$mysqli->close();
		
	//mängule kommentaari jätmine
		function commentJoekaaru($joekaaru_comment){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE discgolf_joekaaru SET comment=? WHERE id=?");
		$stmt->bind_param("si", $joekaaru_comment, $_SESSION["game_id"]);
		if($stmt->execute()){
			//see on tõene, kui sisestus ab'i õnnestus
			$message = "Kommentaar lisatud!";
			
		}else {
			// kui miski läks katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();		
	
		return $message;
	
	}
	
	//loon funktsiooni mängude ajaloo jaoks
		function getGameHistoryJoekaaru(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, date, game_name, comment FROM discgolf_joekaaru WHERE user_id=? AND deleted IS NULL");
		$stmt->bind_param("i", $_SESSION["id_from_db"]);
		$stmt->bind_result($game_id, $game_date, $game_name, $comment);
		
		$stmt->execute();
			$array = array();
			while($stmt->fetch()){
				
				$game_history_joekaaru = new StdClass();
				$game_history_joekaaru->id = $game_id;
				$game_history_joekaaru->date = $game_date;
				$game_history_joekaaru->game_name = $game_name;
				$game_history_joekaaru->comment = $comment;
				
				
				
				array_push($array, $game_history_joekaaru);
			}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
			
		}
		//mängu kustutamine
		function deleteGameJoekaaru($id_to_be_deleted){
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
			$stmt = $mysqli->prepare("UPDATE discgolf_joekaaru SET deleted=NOW() WHERE id=?");
			$stmt->bind_param("i", $id_to_be_deleted);
				if($stmt->execute()){
			// sai edukalt kustutatud
				header("Location: my_history.php");
			$stmt->close();
			$mysqli->close();
		
		}
		
	}
	
	//mängu nime ja kommentaari muutmine
		function editGameJoekaaru($id, $game_name, $comment){
			
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
			$stmt = $mysqli->prepare("UPDATE discgolf_joekaaru SET game_name=?, comment=? WHERE id=?");
			$stmt->bind_param("ssi", $game_name, $comment, $id);
			
			if($stmt->execute()){
				
			}
			
			$stmt->close();
			$mysqli->close();
		
	}
	
?>
