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
			header("Location: data.php");
			
		}else{
			// ei leidnud
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
	}
	function addTask($aine, $opetaja, $ylesanne, $kuupaev, $raskus, $olulisus){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO koolike (aine, opetaja, ylesanne, kuupaev, raskus, olulisus) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssii", $aine, $opetaja, $ylesanne, $kuupaev, $raskus, $olulisus);
		
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
	function koolike(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, aine, opetaja, ylesanne, kuupaev, raskus, olulisus FROM koolike WHERE deleted IS NULL AND done IS NULL");
		$stmt->bind_result($id, $aine, $opetaja, $ylesanne, $kuupaev, $raskus, $olulisus);
		$stmt->execute();
		//tühi massiiv kus hoiame objekte( 1 rida andmeid)
		$array = array();
		
		//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
		while($stmt->fetch())
		{
		
			//loon objekti
			$koolike = new stdClass();
			$koolike->id = $id;
			$koolike->aine= $aine;
			$koolike->opetaja = $opetaja;
			$koolike->ylesanne = $ylesanne;
			$koolike->kuupaev = $kuupaev;
			$koolike->raskus = $raskus;
			$koolike->olulisus = $olulisus;
			//lisame selle massiivi
			array_push($array, $koolike);
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
	
	$stmt = $mysqli->prepare("UPDATE koolike SET deleted=NOW() WHERE id=?");
	$stmt->bind_param("i", $id_to_be_deleted);
	
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
	
	$stmt = $mysqli->prepare("UPDATE koolike SET done=NOW() WHERE id=?");
	$stmt->bind_param("i", $id_to_mark_as_done);
	
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
		$stmt = $mysqli->prepare("SELECT id, aine, opetaja, ylesanne, kuupaev, raskus, olulisus FROM koolike WHERE deleted IS NOT NULL");
		$stmt->bind_result($id, $aine, $opetaja, $ylesanne, $kuupaev, $raskus, $olulisus);
		$stmt->execute();
		//tühi massiiv kus hoiame objekte( 1 rida andmeid)
		$array = array();
		
		//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
		while($stmt->fetch())
		{
		
			//loon objekti
			$koolike = new stdClass();
			$koolike->id = $id;
			$koolike->aine= $aine;
			$koolike->opetaja = $opetaja;
			$koolike->ylesanne = $ylesanne;
			$koolike->kuupaev = $kuupaev;
			$koolike->raskus = $raskus;
			$koolike->olulisus = $olulisus;
			//lisame selle massiivi
			array_push($array, $koolike);
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
		$stmt = $mysqli->prepare("SELECT id, aine, opetaja, ylesanne, kuupaev, raskus, olulisus FROM koolike WHERE done IS NOT NULL");
		$stmt->bind_result($id, $aine, $opetaja, $ylesanne, $kuupaev, $raskus, $olulisus);
		$stmt->execute();
		//tühi massiiv kus hoiame objekte( 1 rida andmeid)
		$array = array();
		
		//tee tsüklit nii mitu korda, kui saad ab'st ühe rea andmeid
		while($stmt->fetch())
		{
		
			//loon objekti
			$koolike = new stdClass();
			$koolike->id = $id;
			$koolike->aine= $aine;
			$koolike->opetaja = $opetaja;
			$koolike->ylesanne = $ylesanne;
			$koolike->kuupaev = $kuupaev;
			$koolike->raskus = $raskus;
			$koolike->olulisus = $olulisus;
			//lisame selle massiivi
			array_push($array, $koolike);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		$stmt->close();
		$mysqli->close();
		
		return $array;
	}
	/*function editTask($id_to_be_edited)
	{
	header("Location: task.php");
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT aine, opetaja, ylesanne, kuupaev, raskus, olulisus FROM koolike WHERE id=?");
	$stmt->bind_param("i", $id_to_be_edited);
	$stmt->bind_result($eaine, $eopetaja, $eylesanne, $ekuupaev, $eraskus, $eolulisus);
	$stmt->execute();
	
	$aine = $eaine;
	$opetaja = $eopetaja;
	$ylesanne = $eylesanne;
	$kuupaev = $ekuupaev;
	$eraskus = $raskus;
	$eolulisus = $olulisus;
	
	$stmt->close();
	$mysqli->close();
	}
	*/
?>