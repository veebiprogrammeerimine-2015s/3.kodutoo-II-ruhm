<?php
	//function.php
	require_once("../../configGLOBAL.php");
	$database = "if15_vitamak";

	
		//loome uue funktsiooni, et küsida ab'ist andmeid
	function getKULUTUS(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
 		
		$stmt = $mysqli->prepare("SELECT id, name, secondname, age, eriala FROM user_register1");
		echo $mysqli->error;
		$stmt->bind_result($id, $name, $secondname, $age, $eriala);
		$stmt->execute();
 		
		// tühi massiiv kus hoiame objekte (1 rida andmeid)
		$array = array();
		
		// tee tsüklit nii mitu korda, kui saad 
		// ab'ist ühe rea andmeid
		while($stmt->fetch()){
			
			// loon objekti iga while tsükli kord
			$kul = new StdClass();
			$kul->id = $id;
			$kul->name = $name;
			$kul->secondname = $secondname;
			$kul->age = $age;
			$kul->eriala = $eriala;
			
			// lisame selle massiivi
			array_push($array, $kul);
			//echo "<pre>";
			//var_dump($array);
			//echo "</pre>";
		}
			
			
		
		$stmt->close();
		$mysqli->close();
		return $array;
	}
	
	function deleteKULUTUS($id_to_be_deleted){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE user_register1 SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id_to_be_deleted);
		
		if($stmt->execute()){
			// sai edukalt kustutatud
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
?>