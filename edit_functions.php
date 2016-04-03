<?php

	 
     require_once("config.php");
	
    $database = "uus";
    $mysqli = new mysqli($servername, $username, $password, $database);
	
	function getSingleToit($edit_id){
		
		//echo "id on ".$edit_id;
		
		//$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $GLOBALS["mysqli"]->prepare("SELECT nimi, hind FROM nimi WHERE id=? AND deleted IS NULL");
		//asendan ? märgi
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($nimi, $hind);
		$stmt->execute();
		
		//tekitan objekti
		$toit = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$toit->nimi = $nimi;
			$toit->hind = $hind;
			
			
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: table.php");
		}
		
		return $toit;
		
		
		$stmt->close();
		$GLOBALS["mysqli"]->close();
		
	}


	function updateToit($id, $nimi, $hind){
		
		//$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $GLOBALS["mysqli"]->prepare("UPDATE toit SET nimi=?, hind=? WHERE id=?");
		$stmt->bind_param("ssi",$nimi, $hind, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "jeeee";
		}
		
		
		$stmt->close();
		$GLOBALS["mysqli"]->close();
		
		
	}
	
	
?>