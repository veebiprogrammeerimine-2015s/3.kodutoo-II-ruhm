<?php

	require_once("../../configGLOBAL.php");
	$database = "if15_vitamak";
	
	function getSingleCarData($edit_id){
		
		echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT number_plate, color FROM car_plates WHERE id=? AND deleted is NULL");
		//asendan ? märgi
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($number_plate, $color);
		$stmt->execute();
		
		//tekkitan objekti
		$car = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			//saan siin alles kasutada bind_resoult muutujad
			$car->number_plate = $number_plate;
			$car->color = $color;
			
			
		}else{
			//see rida võib olla kustutatud
			// ei saanud rida andmeid kätte
			// sellest idd ei ole olemas
			header("Location: table.php");
			
			}
		
		return $car;
		
		$stmt->close();
		$mysqli->close();
	}
	function uptadeCar($id, $number_plate, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi",$number_plate, $color, $id);
		//kas õnnestus salvestada
		if($stmt->execute());{
			//õnnestus
			echo "yuss";
		
		}
		$stmt->close();
		$mysqli->close();
		
		
		
		
		
	}

?>