<?php
	//function.php
	require_once("../../configGLOBAL.php");
	$database = "if15_vitamak";

	
		//loome uue funktsiooni, et küsida ab'ist andmeid
	function getKULUTUS(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
 		
		$stmt = $mysqli->prepare("SELECT id, name, secondname, age, eriala FROM user_register1");
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
			$kul->secondname = $second;
			$kul->age = $age;
			$kul->eriala = $eriala;
			
			// lisame selle massiivi
			array_push($array, $car);
			echo "<pre>";
			var_dump($array);
			echo "</pre>";
		}
			
			
		
		$stmt->close();
		$mysqli->close();
	}
?>