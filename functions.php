<?php
	
	// functions.php
	require_once("../configglobal.php");
	$database = "if15_tanjak";
	
	//loome uue funktsiooni, et küsida ab'ist andmeid
	function getFlowerData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, flower, color FROM car_plates WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_id, $flower_plate, $color_from_db);
		$stmt->execute();
		
		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$car = new StdClass();
			$car->id = $id;
			$car->flower = $flower;
			$car->user_id = $user_id;
			$car->color = $color_from_db;
			
			// lisame selle massiivi
			array_push($array, $flower);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
		
	}
	
	
	function deleteFlower($id_to_be_deleted){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE flowers SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		
		if($stmt->execute()){
			// sai edukalt kustutatud
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
?>