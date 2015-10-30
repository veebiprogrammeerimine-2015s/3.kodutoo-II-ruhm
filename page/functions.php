<?php 
	
	// Loon AB'i ühenduse
	require_once("../../teine_config.php");
	$database = "if15_kenaon";
	//tekitatakse sessioon, mida hoitakse serveris,
	// kõik session muutujad on kättesaadavad kuni viimase brauseriakna sulgemiseni
	session_start();
	
	function loginUser($email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);		
		
		$stmt = $mysqli->prepare("SELECT id, email FROM kontod32 WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			// ab'i oli midagi
			echo "Email ja parool õiged, kasutaja id=".$id_from_db;
			
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			//suunan data.php lehele
			header("Location: ylesanded.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	function addTask($subject, $lecturer, $task, $date, $difficulty, $importance){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO tasks (user_id, subject, lecturer, task, date, difficulty, importance) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("issssii", $_SESSION["logged_in_user_id"], $subject, $lecturer, $task, $date, $difficulty, $importance);
		
		$message ="";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab õnnestus
			$message = "Edukalt sisestatud andmebaasi";
		}else{
			//execute on false, miski on katki
			echo $stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		
		return $message;
	}
	function tasks(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, subject, lecturer, task, date, difficulty, importance FROM tasks WHERE deleted IS NULL AND done IS NULL AND user_id =?");
		$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($id, $subject, $lecturer, $task, $date, $difficulty, $importance);
		$stmt->execute();
		//tühi massiiv kus hoiame objekte( 1 rida andmeid)
		$array = array();
		
		//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
		while($stmt->fetch())
		{
		
			//loon objekti
			$tasks = new stdClass();
			$tasks->id = $id;
			$tasks->subject= $subject;
			$tasks->lecturer = $lecturer;
			$tasks->task = $task;
			$tasks->datee = $date;
			$tasks->difficulty = $difficulty;
			$tasks->importance = $importance;
			//lisame selle massiivi
			array_push($array, $tasks);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	function deleteTask($id_to_be_deleted)
	{
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("UPDATE tasks SET deleted=NOW() WHERE id=? AND user_id=?");
	$stmt->bind_param("ii", $id_to_be_deleted, $_SESSION["logged_in_user_id"]);
	
	if($stmt->execute())
	{
		//sai edukalt kustutatud
		header("Location: ylesanded.php");
		
	}
	$stmt->close();
	$mysqli->close();
	}
	function doneTask($id_to_mark_as_done)
	{
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("UPDATE tasks SET done=NOW() WHERE id=? AND user_id=?");
	$stmt->bind_param("ii", $id_to_mark_as_done, $_SESSION["logged_in_user_id"]);
	
	if($stmt->execute())
	{
		//sai edukalt kustutatud
		header("Location: ylesanded.php");
		
	}
	$stmt->close();
	$mysqli->close();
	}
	function deletedTasks(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, subject, lecturer, task, date, difficulty, importance FROM tasks WHERE deleted IS NOT NULL AND user_id=?");
		$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($id, $subject, $lecturer, $task, $date, $difficulty, $importance);
		$stmt->execute();
		//tühi massiiv kus hoiame objekte( 1 rida andmeid)
		$array = array();
		
		//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
		while($stmt->fetch())
		{
		
			//loon objekti
			$tasks = new stdClass();
			$tasks->id = $id;
			$tasks->subject= $subject;
			$tasks->lecturer = $lecturer;
			$tasks->task = $task;
			$tasks->datee = $date;
			$tasks->difficulty = $difficulty;
			$tasks->importance = $importance;
			//lisame selle massiivi
			array_push($array, $tasks);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	function doneTasks(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, subject, lecturer, task, date, difficulty, importance FROM tasks WHERE done IS NOT NULL AND user_id=?");
		$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($id, $subject, $lecturer, $task, $date, $difficulty, $importance);
		$stmt->execute();
		//tühi massiiv kus hoiame objekte( 1 rida andmeid)
		$array = array();
		
		//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
		while($stmt->fetch())
		{
		
			//loon objekti
			$tasks = new stdClass();
			$tasks->id = $id;
			$tasks->subject= $subject;
			$tasks->lecturer = $lecturer;
			$tasks->task = $task;
			$tasks->datee = $date;
			$tasks->difficulty = $difficulty;
			$tasks->importance = $importance;
			//lisame selle massiivi
			array_push($array, $tasks);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	function addCarPlate($car_plate, $color) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?, ?, ?)");
		$stmt->bind_param("iss", $_SESSION["logged_in_user_id"], $car_plate, $color);
		
		$message ="";
		//
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab õnnestus
			$message = "Edukalt sisestatud andmebaasi";
		}else{
			//execute on false, miski on katki
			echo $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();	

		return $message;
	}
	/*function editTask($id_to_be_edited)
	{
	header("Location: task.php");
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT subject, lecturer, task, date, difficulty, importance FROM tasks WHERE id=?");
	$stmt->bind_param("i", $id_to_be_edited);
	$stmt->bind_result($esubject, $electurer, $etask, $edate, $edifficulty, $eimportance);
	$stmt->execute();
	
	$subject = $esubject;
	$lecturer = $electurer;
	$task = $etask;
	$date = $edate;
	$edifficulty = $difficulty;
	$eimportance = $importance;
	
	$stmt->close();
	$mysqli->close();
	}
	*/
?>