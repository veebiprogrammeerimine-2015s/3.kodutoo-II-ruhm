<?php
	require_once("../configglobal.php");
	$database = "if15_areinlo_2";
	session_start();
	
	function createUser($create_email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO Users (email, password) VALUE (?, ?)");
		$stmt->bind_param("ss", $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	
	function loginUser($email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM Users WHERE email=? AND password=?");
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
	
	function createCars($year, $make, $model, $horsepower, $topspeed, $transmission){
		
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO CarData (user_id, year, make, model, horsepower, topspeed, transmission) VALUE (?, ?, ?, ?, ?, ?, ?)");		
		echo $mysqli->error;
		$stmt->bind_param("issssss", $_SESSION["id_from_db"], $year, $make, $model, $horsepower, $topspeed, $transmission);
		$message = "";
		if($stmt->execute()){
			$message = "Successfully inserted into database.";
		}else{
			echo$stmt->error;
		}
		
		
		$stmt->close();
		$mysqli->close();
		return $message;
		
	}
	
	function getCarsData(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, user_id, year, make, model, horsepower, topspeed, transmission FROM CarData WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id, $year, $make, $model, $horsepower, $topspeed, $transmission);
		$stmt->execute();
		$array = array();
		
		while($stmt->fetch()){
			$cars = new StdClass();
			$cars->id = $id;
			$cars->year = $year;
			$cars->user_id = $user_id;
			$cars->make = $make;
			$cars->model = $model;
			$cars->horsepower = $horsepower;
			$cars->topspeed = $topspeed;
			$cars->transmission = $transmission;
			
			array_push($array, $cars);
		}
		
		$stmt->close();
		$mysqli->close();
		return $array;
	}
	
	function deleteCars($id_to_be_deleted){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE CarData SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		if($stmt->execute()){
			header("Location: table.php");
		}
		
		$stmt->close();
		$mysqli->close();
	}
	getCarsData();
?>