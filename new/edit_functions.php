<?php
	require_once("../../configglobal.php");
	$database = "if15_rimo";
		
	function getSingleCarData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT number_plate, color FROM car_plates WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($number_plate, $color);
		$stmt->execute();
		$car = new Stdclass();
		if($stmt->fetch()){
			$car->number_plate = $number_plate;
			$car->color = $color;
		}else{
			//ei saanud andmeid kätte, sellist id'd ei ole või on kustutatud
			header("Location: table.php");
		}
		return $car;
		
		$stmt->close();
		$mysqli->close();
	}
	function updateCar($id, $number_plate, $color){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE car_plates SET number_plate=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $number_plate, $color, $id);
		//kas õnnestus salvestada
		if($stmt->execute()){
			//echo"jee";
		}else{
			
		}
		$stmt->close();
		$mysqli->close();
	}
?>