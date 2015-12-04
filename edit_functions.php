<?php
	require_once("../configglobal.php");
	$database = "if15_tanjak";
	
	function getSingleFlowerData($edit_id){
		
		//echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT flower, color FROM flowers WHERE id=? AND deleted IS NULL");
		//asendan ? märgi
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($flower, $color);
		$stmt->execute();
		
		//tekitan objekti
		$car = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$fflower->flower = $flower;
			$fflower->color = $color;
			
			
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: table.php");
		}
		
		return $fflower;
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	function updateFlower($id, $flower, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE car_plates SET flower=?, color=? WHERE id=?");
		$stmt->bind_param("ssi",$flower, $color, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "jah";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		
	}
	
	
?>