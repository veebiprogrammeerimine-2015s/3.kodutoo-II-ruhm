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
	
	//discolfi tabeli jaoks
	function createResult($par, $result){
		// globals on muutuja kõigist php failidest mis on ühendatud
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO results (user_id, par, result) VALUES (?, ?, ?)");
		$stmt->bind_param("iii", $_SESSION["id_from_db"], $par, $result);
		
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

	
	//Loome uue funktsiooni, et ab'st andmeid
	function getResultData(){
		
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT id, user_id, par, result FROM results"); //WHERE deleted IS NULL
	$stmt->bind_result($id, $user_id, $par, $result_from_db); //algselt oli $color_from_db
	
	$stmt->execute();
	
	$row = 0;
	
	//tyhi massiiv, kus hoiame objekte (1rida andmeid)
	$array = array();
	
	//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
	while($stmt->fetch()){
		
		$result = new StdClass();
		$result->id = $id;
		$result->user_id = $user_id;
		$result->par = $par;
		$result->result_from_db = $result_from_db;
		
		//lisame selle massiivi
		array_push($array, $result);
		//echo "<pre>";
		//var_dump($array);
		//echo "</pre>";
	}
	
	$stmt->close();
	$mysqli->close();
		
		return $array;
}
	
	
	
	
?>