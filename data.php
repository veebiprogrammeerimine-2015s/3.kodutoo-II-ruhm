<?php

//siia lisame auto nr. märgi
//kontrollin, kas kasutaja ei ole sisseligunud+
	require_once("functions.php");
	
	if(!isset($_SESSION["id_from_db"])){
		//suunan data lehele
		header("Location: login.php");
	}
	//login välja
	if(isset($_GET["logout"])){
		//kustutab muutujad
		session_destroy();
		
		header("Location: login.php");
		
	}
	$car_plate = $color = $car_plate_error = $color_error = "";
	

	if(isset($_POST["create"])){
		if ( empty($_POST["car_plate"]) ) {
			$car_plate_error = "See väli on kohustuslik";
		}else{
			$car_plate = cleanInput($_POST["car_plate"]);
		}
		if ( empty($_POST["color"]) ) {
			$color_error = "See väli on kohustuslik";
		} else {
			$color = cleanInput($_POST["color"]);
		}
		if(	$car_plate_error == "" && $color_error == ""){
			
			// functions.php failis käivina funktsiooni
			// msq = messege
			$msg = createCarPlate($car_plate, $color);
			
			if($msg != ""){
				//salvestamine õnnetus
				//teen tühjaks input valued
				$car_plate = "";
				$color = "";
				
				echo $msg;
				
			}
			
		}
    } // create if end
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>
<p>
	Tere, <?=$_SESSION["user_email"];?>, your account id = <?=$_SESSION["id_from_db"];?>
	<a href="?logout=1"> logi välja </a>

</p>

<h2>Lisa auto</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="car_plate" >auto nr</label><br>
	<input id="car_plate" name="car_plate" type="text" value="<?=$car_plate; ?>"> <?=$car_plate_error; ?><br><br>
	<label>värv</label><br>
	<input name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
	<input type="submit" name="create" value="Salvesta">
	</form> 
