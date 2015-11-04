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
	function createGame_results($par, $my_result){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO game_results (user_id, basket1_par, basket1_my_result) VALUES (?, ?, ?)");
		$stmt->bind_param("iii", $_SESSION["id_from_db"], $par, $my_result);
		
		if($stmt->execute()){
			//see on tõene, kui sisestus ab'i õnnestus
			$message = "Edukalt sisestatud andmebaasi";
			
		}else {
			// kui miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		
		$mysqli->close();		
	
		return $message;
	}

	
	//Loome uue funktsiooni, et ab'st andmeid saada
	function getResultData(){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT id, user_id, par, my_result FROM game_results"); 
	$stmt->bind_result($id, $user_id, $par, $my_result); //algselt oli $color_from_db
	
	$stmt->execute();
	
	$row = 0;
	
	//tyhi massiiv, kus hoiame objekte (1rida andmeid)
	$array = array();
	
	//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
	while($stmt->fetch()){
		
		$my_result = new StdClass();
		$my_result->id = $id;
		$my_result->user_id = $user_id;
		$my_result->par = $par;
		$my_result->my_result = $my_result_from_db;
		
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

	//Loome uue funktsiooni, et ab'st andmeid saada
	function getGameData(){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT id, game_name, baskets FROM game WHERE deleted IS NULL"); 
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