<?php
	require_once("../../konfig_global.php");
	$database = "if13_rene_p";
	
	function getSingleRetseptData($edit_id){
		
		//echo "id on ".$edit_id;
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT title, ingredients, preparation FROM create_retsept WHERE id=? AND deleted IS NULL");
		//var_dump();//asendan ? märgi
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($title, $ingredients, $preparation);
		$stmt->execute();
		
		//tekitan objekti
		$retsept = new Stdclass();
		
		//saime ühe rea andmeid
		if($stmt->fetch()){
			// saan siin alles kasutada bind_result muutujaid
			$retsept->title = $title;
			$retsept->ingredients = $ingredients;
			$retsept->preparation = $preparation;
			
			
		}else{
			// ei saanud rida andmeid kätte
			// sellist id'd ei ole olemas
			// see rida võib olla kustutatud
			header("Location: table.php");
		}
		
		return $retsept;
		
		
		$stmt->close();
		$mysqli->close();
		
	}

	function updateRetsept($id, $title, $ingredients, $preparation){

			$title = cleanInput($_POST["title"]);
			$ingredients = cleanInput($_POST["ingredients"]);
			$preparation = cleanInput($_POST["preparation"]);
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE create_retsept SET title=?, ingredients=?, preparation=? WHERE id=?");
		$stmt->bind_param("sssi",$title, $ingredients, $preparation, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "Uuendus l2ks l2bi!";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		
	}


	function cleanInput($data) {
  	$data = trim($data); //tabulaator, tühikud, Enter
  	$data = stripslashes($data); //Kaldkriipsud
  	$data = htmlspecialchars($data); // 
  	return $data;
	
	
	}
	
	
?>