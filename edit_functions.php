<?php
	require_once("../configglobal.php");
	$database = "if15_areinlo_2";
	
	function getSingleCarsData($edit_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT year, make, model, horsepower, topspeed, transmission FROM CarData WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($year, $make, $model, $horsepower, $topspeed, $transmission);
		$stmt->execute();
		$car = new Stdclass();
		
		if($stmt->fetch()){
			//saan siin alles kasutada bind_result muutujaid
			$car->year = $year;
			$car->make = $make;
			$car->model = $model;
			$car->horsepower = $horsepower;
			$car->topspeed = $topspeed;
			$car->transmission = $transmission;
			
		}else{
			header("Location: table.php");
		}
		
		return $car;
		$stmt->close();
		$mysqli->close();
	
	}

	function updateCars($id, $year, $make, $model, $horsepower, $topspeed, $transmission){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE CarData SET year=?, make=?, model=?, horsepower=?, topspeed=?, transmission=? WHERE id=?");
		$stmt->bind_param("ssssssi",$year, $make, $model, $horsepower, $topspeed, $transmission, $id); 
		if($stmt->execute()){
			echo "yay";
		}
		
		$stmt->close();
		$mysqli->close();
	}
?>