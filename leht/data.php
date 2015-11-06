<?php
//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}
	
	$date = $car = $color = $plate = $color_error  = $car_error =  $date_error =  $plate_error = "";
	
	if(isset($_POST["create"])){
			if ( empty($_POST["värv"]) ) {
				$color_error = "See väli on kohustuslik";
			}else{
				$color = cleanInput($_POST["värv"]);
			}
			if ( empty($_POST["kuupaev"]) ) {
				$date_error = "See väli on kohustuslik";
			}else{
				$date = cleanInput($_POST["kuupaev"]);
			}
			if ( empty($_POST["auto"]) ) {
				$car_error = "See väli on kohustuslik";
			}else{
				$car = cleanInput($_POST["auto"]);
			}
			if ( empty($_POST["nrmark"]) ) {
				$plate_error = "See väli on kohustuslik";
			} else {
				$plate = cleanInput($_POST["nrmark"]);
			}
	if(	$color_error == "" && $plate_error == ""&& $car_error == ""&& $date_error == ""){
		// functions.php failis käivina funktsiooni
				//msg on message
				$msg = createResult ($color, $plate,$date,$car);
				
				if($msg != ""){
					//salvestamine õnnestus
					//teen tühjaks input väljad
					$color	= "";
					$plate = "";
					$car = "";
					$date="";
					echo $msg;
					
				}
			}
	}	// create if end
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Autod</h1><br>
<h2>Vaatluse lisamine</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="värv" >Värv</label> <input id="värv" name="värv" type="text" value="<?=$color; ?>">  <?=$color_error; ?><br><br>
  	<label>Nr.märk</label>	<input name="nrmark" type="text" value="<?=$plate; ?>"><?=$plate_error; ?><br><br>
	<label>Kuupäev</label>	<input name="kuupaev" type="text" value="<?=$date; ?>"> <?=$date_error; ?><br><br>
	<label>Auto mark</label>	<input name="auto" type="text" value="<?=$car; ?>"> <?=$car_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>

