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
			if ( empty($_POST["color"]) ) {
				$color_error = "See väli on kohustuslik";
			}else{
				$color = cleanInput($_POST["color"]);
			}
			if ( empty($_POST["date"]) ) {
				$date_error = "See väli on kohustuslik";
			}else{
				$date = cleanInput($_POST["date"]);
			}
			if ( empty($_POST["car"]) ) {
				$car_error = "See väli on kohustuslik";
			}else{
				$car = cleanInput($_POST["car"]);
			}
			if ( empty($_POST["plate"]) ) {
				$plate_error = "See väli on kohustuslik";
			} else {
				$plate = cleanInput($_POST["plate"]);
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
  	<label>Värv</label> <input name="color" type="text" value="<?=$color; ?>">  <?=$color_error; ?><br><br>
  	<label>Nr.märk</label>	<input name="plate" type="text" value="<?=$plate; ?>"><?=$plate_error; ?><br><br>
	<label>Kuupäev</label>	<input name="date" type="date" value="<?=$date; ?>"> <?=$date_error; ?><br><br>
	<label>Auto mark</label>	<input name="car" type="text" value="<?=$car; ?>"> <?=$car_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>

