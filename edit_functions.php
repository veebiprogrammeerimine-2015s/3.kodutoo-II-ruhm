<?php
	require_once("../configglobal.php");
	$database = "if15_tanjak";
	
	function getSingleFlowerData($edit_id){
		
		//echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT flower, color FROM flowers WHERE id=? AND deleted IS NULL");
		//asendan ? m�rgi
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($flower, $color);
		$stmt->execute();
		
		//tekitan objekti
		$car = new Stdclass();
		
		//saime �he rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$fflower->flower = $flower;
			$fflower->color = $color;
			
			
		}else{
			// ei saanud rida andmeid k�tte
			// sellist id'd ei ole olemas
			// see rida v�ib olla kustutatud
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
		
		// kas �nnestus salvestada
		if($stmt->execute()){
			// �nnestus
			echo "jah";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		
	}
	
	
?>