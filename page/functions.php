<?php
    require_once("../../../configglobal.php");
	$database = "if15_koidkan";
	
	session_start();
	
	function createUser($create_email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
		$stmt->bind_param("ss", $create_email, $password_hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();		
	}
	
	function loginUser($email, $password_hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
			
			$_SESSION["id_from_db"] = $id_from_db;
			$_SESSION["user_email"] = $email_from_db;
			
			header("Location: data.php");
			
			
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	
	
	function createDayPlanner($day, $d_time, $d_task){

		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO tasks (user_id, day, d_time, d_task) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("isss", $_SESSION["id_from_db"], $day, $d_time, $d_task);
		
		$message = "";
		
		if($stmt->execute()){
			
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		return $message;
		
	}
	
	function getTaskData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, day, d_time, d_task FROM tasks WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id, $day, $d_time, $d_task);
		$stmt->execute();
		
		
		$array = array();
		
		
		while($stmt->fetch()){
			
			
			$task = new StdClass();
			$task->id = $id;
			$task->user_id = $user_id;
			$task->day = $day;
			$task->d_time = $d_time;
			$task->d_task = $d_task;
			
			
			array_push($array, $task);
		
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
		
	}
	
	
	function deleteTask($id_to_be_deleted){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE tasks SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		
		if($stmt->execute()){
			
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
?>