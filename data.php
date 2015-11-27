<?php
	// siia lisame auto nr märgite vormi
	//laeme funktsiooni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: login.php");
	}
	
	//login välja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	$age = $height = $weight = $bf_percentage = $gender = $age_error = $height_error = $weight_error = $bf_percentage_error = $gender_error ="";
	
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){

		if ( empty($_POST["age"]) ) {
			$age_error = "See väli on kohustuslik";
		}else{
			$age = cleanInput($_POST["age"]);
		}

		if ( empty($_POST["height"]) ) {
			$height_error = "See väli on kohustuslik";
		} else {
			$height = cleanInput($_POST["height"]);
		}

				if ( empty($_POST["weight"]) ) {
			$weight_error = "See väli on kohustuslik";
		} else {
			$weight = cleanInput($_POST["weight"]);
		}
		
				if ( empty($_POST["bf_percentage"]) ) {
			$bf_percentage_error = "See väli on kohustuslik";
		} else {
			$bf_percentage = cleanInput($_POST["bf_percentage"]);
		}
		
						if ( empty($_POST["gender"]) ) {
			$gender_error = "See väli on kohustuslik";
		} else {
			$gender = cleanInput($_POST["gender"]);
		}
		
		if(	$age_error == "" && $height_error == "" && $weight_error == "" && $bf_percentage_error == "" && $gender_error == ""){
			
			// functions.php failis käivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createBodyData($age, $height, $weight, $bf_percentage, $gender);
			
			if($msg != ""){
				//salvestamine õnnestus
				// teen tühjaks input value'd
				$age = "";
				$height = "";
				$weight = "";
				$bf_percentage = "";
				$gender = "";
				
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
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

 <h2>Lisa enda andmed</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="age" >Vanus</label><br>
	<input id="age" name="age" type="text" value="<?=$age; ?>"> <?=$age_error; ?><br><br>
  	<label>Pikkus</label><br>
	<input name="height" type="text" value="<?=$height; ?>"> <?=$height_error; ?><br><br>
  	<label>Kaal</label><br>
	<input name="weight" type="text" value="<?=$weight; ?>"> <?=$weight_error; ?><br><br>
	<label>Rasvaprotsent</label><br>
	<input name="bf_percentage" type="text" value="<?=$bf_percentage; ?>"> <?=$bf_percentage_error; ?><br><br>
	<label>Sugu</label><br>
	<input type="radio" name="gender" value="male" checked>Mees
	<br>
	<input type="radio" name="gender" value="female">Naine<br><br>
	<input type="submit" name="create" value="Salvesta">
  </form>