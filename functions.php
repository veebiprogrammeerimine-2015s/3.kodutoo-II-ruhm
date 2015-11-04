<?php
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";

	
	session_start();
	
	
	function createUser($create_email, $password_hash){
		
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUE (?, ?)");
				
		
		
		
		
		$stmt->bind_param("ss", $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
		$stmt->bind_param("ss",$email, $password_hash);
		
		
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			echo"<br>";
			echo "kasutaja id=" .$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			
			header("Location: data.php");
			
		}else{
			
			echo "Wrong password or email";
			
		}
		
		$stmt->close();
		
		$mysqli->close();
	}
	
	function createTournamen($tournament, $team_one, $team_two, $time){
		
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, tournament, team_one, team_two, time) VALUE (?, ?, ?, ?, ?)");
				
		echo $mysqli->error;
		$stmt->bind_param("issss", $_SESSION["id_from_db"], $tournament, $team_one, $team_two, $time);
		
		$message = "";
		
		if($stmt->execute()){
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			echo$stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		return $message;
		
	}
?>