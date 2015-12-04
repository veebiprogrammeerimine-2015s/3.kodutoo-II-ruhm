<?php

	require_once("functions.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: login.php");
	}
	
	//login v�lja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab k�ik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	$flower = $color = $flower_error = $color_error = "";
	
	// et ei ole t�hjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){
		if ( empty($_POST["flower"]) ) {
			$flower_error = "See v�li on kohustuslik";
		}else{
			$flower = cleanInput($_POST["flower"]);
		}
		if ( empty($_POST["color"]) ) {
			$color_error = "See v�li on kohustuslik";
		} else {
			$color = cleanInput($_POST["color"]);
		}
		if(	$flower_error == "" && $color_error == ""){
			
			// functions.php failis k�ivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createFlowerColor($flower, $color);
			
			if($msg != ""){
				//salvestamine �nnestus
				// teen t�hjaks input value'd
				$flower = "";
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
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi v�lja</a>
</p>

 <h2>Lisa lill</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="flower" >lille nimetus</label><br>
	<input id="flower" name="flower" type="text" value="<?=$flower; ?>"> <?=$flower_error; ?><br><br>
  	<label>v�rv</label><br>
	<input name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>
	
	
?>