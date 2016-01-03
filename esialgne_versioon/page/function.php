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
	
	//discolfi mängu loomiseks
	function createGame($game_name, $baskets){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO game (user_id, game_name, baskets) VALUES (?, ?, ?)");
		$stmt->bind_param("isi", $_SESSION["id_from_db"], $game_name, $baskets);
		
		if($stmt->execute()){
			//see on tõene, kui sisestus ab'i õnnestus
			$message = "Mäng edukalt loodud";
			
		}else {
			// kui miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		
		$mysqli->close();		
	
		return $message;
	}
	
	//discolfi tabeli jaoks
	function createResult($game_id, $basket_nr, $par, $my_result){
	//1) kas on olemas selline rida AB'is 
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id FROM game_results WHERE game_id = ?");
		$stmt->bind_param("i", $game_id);
		$stmt->execute();
		$stmt->bind_result($id);
		
		// kas on olemas see rida
		if(!$stmt->fetch()){
			// kui ei ole rida siis peaks tekitama
			
			$create_new_entry = 1;
		}
		
		$stmt->close();
		
		if(isset($create_new_entry)){
			
			// siis teen uue tühja rea, kuhu saan hakata siis salvestama
			
			// AINULT 1 salvestuse korral, edaspidi on rida olemas
			
			$stmt = $mysqli->prepare("INSERT INTO game_results (game_id, user_id) VALUES (?, ?)");
			//echo $mysqli->error;
			$stmt->bind_param("ii", $game_id, $_SESSION["id_from_db"]);
			
			$stmt->execute();
			$stmt->close();
		}
		
		$stmt = $mysqli->prepare("UPDATE game_results SET basket".$basket_nr."_par = ?, basket".$basket_nr."_my_result = ? WHERE game_id = ? AND user_id = ?");
		$stmt->bind_param("iiii", $par, $my_result, $game_id, $_SESSION["id_from_db"]);
		$stmt->execute();
		
		$stmt->close();
		
		$mysqli->close();	
}

	
	//Loome uue funktsiooni, et ab'st andmeid saada
	//tulemuste tabli jaoks
 	function getResultData($game_id){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT basket1_par, basket1_my_result, basket2_par, basket2_my_result, basket3_par, basket3_my_result FROM game_results WHERE game_id = ?"); 
	$stmt->bind_param("i", $game_id);
	$stmt->bind_result($basket1_par, $basket1_my_result, $basket2_par, $basket2_my_result, $basket3_par, $basket3_my_result);
	
	$stmt->execute();
	
	$my_result = new StdClass();
		
	//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
	if($stmt->fetch()){
		
		$my_result->basket1_par = $basket1_par;
		$my_result->basket1_my_result = $basket1_my_result;
		$my_result->basket2_par = $basket2_par;
		$my_result->basket2_my_result = $basket2_my_result;
		$my_result->basket3_par = $basket3_par;
		$my_result->basket3_my_result = $basket3_my_result;
		$my_result->basket4_par = $basket4_par;
		$my_result->basket4_my_result = $basket4_my_result;
		$my_result->basket5_par = $basket5_par;
		$my_result->basket5_my_result = $basket5_my_result;
		$my_result->basket6_par = $basket6_par;
		$my_result->basket6_my_result = $basket6_my_result;
		$my_result->basket7_par = $basket7_par;
		$my_result->basket7_my_result = $basket7_my_result;
		$my_result->basket8_par = $basket8_par;
		$my_result->basket8_my_result = $basket8_my_result;
		$my_result->basket9_par = $basket9_par;
		$my_result->basket9_my_result = $basket9_my_result;
		$my_result->basket10_par = $basket10_par;
		$my_result->basket10_my_result = $basket10_my_result;
		$my_result->basket11_par = $basket11_par;
		$my_result->basket11_my_result = $basket11_my_result;
		$my_result->basket12_par = $basket12_par;
		$my_result->basket12_my_result = $basket12_my_result;
	}else{
		
		// ei olndu seda rida, midagi ei ole veel salvestatud
		$my_result->basket1_par = 0;
		$my_result->basket1_my_result = 0;
		$my_result->basket2_par = 0;
		$my_result->basket2_my_result = 0;
		$my_result->basket3_par = 0;
		$my_result->basket3_my_result = 0;
		$my_result->basket4_par = 0;
		$my_result->basket4_my_result = 0;
		$my_result->basket5_par = 0;
		$my_result->basket5_my_result = 0;
		$my_result->basket6_par = 0;
		$my_result->basket6_my_result = 0;
		$my_result->basket7_par = 0;
		$my_result->basket7_my_result = 0;
		$my_result->basket8_par = 0;
		$my_result->basket8_my_result = 0;
		$my_result->basket9_par = 0;
		$my_result->basket9_my_result = 0;
		$my_result->basket10_par = 0;
		$my_result->basket10_my_result = 0;
		$my_result->basket11_par = 0;
		$my_result->basket11_my_result = 0;
		$my_result->basket12_par = 0;
		$my_result->basket12_my_result = 0;
		
	}
	
	$stmt->close();
	$mysqli->close();
		
		return $my_result;
} 

	//Loome uue funktsiooni, et ab'st andmeid saada
	//mängude tabeli jaoks
	function getGameData(){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT id, game_name, baskets FROM game WHERE deleted IS NULL AND user_id = ?"); 
	$stmt->bind_param("i", $_SESSION["id_from_db"]);
	$stmt->bind_result($id, $name, $baskets); //algselt oli $color_from_db
	
	$stmt->execute();
	
	$row = 0;
	
	//tyhi massiiv, kus hoiame objekte (1rida andmeid)
	$array = array();
	
	//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
	while($stmt->fetch()){
		
		$my_result = new StdClass();
		$my_result->id = $id;
		
		$my_result->name = $name;
		$my_result->baskets = $baskets;
		
		//lisame selle massiivi
		array_push($array, $my_result);
		/* echo "<pre>";
		var_dump($array);
		echo "</pre>"; */
	}
	
	$stmt->close();
	$mysqli->close();
		
		return $array;
}


//delete funktsiooni

	function deleteGame($id_to_be_deleted){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);

	$stmt = $mysqli->prepare("UPDATE game SET deleted=NOW() WHERE id=?");
	$stmt->bind_param("i", $id_to_be_deleted);
	if($stmt->execute()){
			// sai edukalt kustutatud
			//header("Location: table.php");
			$stmt->close();
			$mysqli->close();
		
		}
		
}
	
	
	
	
?>