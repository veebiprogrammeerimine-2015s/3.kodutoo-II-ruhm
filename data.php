<?php
	$page_title = "Andmete leht";
	$file_name = "data.php";
	
?>

<?php require_once("menu.php")?>
<?php

	
	
	require_once("../configglobal.php");
	$database = "if15_areinlo_2";
	
	//Laeme funktsiooni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");	
	}
	
	//Login välja kui aadressi real on ?logout=1
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	$year = $make = $model = $horsepower = $topspeed = $transmission = $year_error = $make_error = $model_error = $horsepower_error = $topspeed_error = $transmission_error = "";
	
	if(isset($_POST["create"])){
		
		if ( empty($_POST["year"]) ) {
			$year_error = "This field is required";
		} else {
			$year = cleanInput($_POST["year"]);
		}
		if ( empty($_POST["make"]) ) {
			$make_error = "This field is required";
		} else {
			$make = cleanInput($_POST["make"]);
		}
				if ( empty($_POST["model"]) ) {
			$model_error = "This field is required";
		} else {
			$model = cleanInput($_POST["model"]);
		}
				if ( empty($_POST["horsepower"]) ) {
			$horsepower_error = "This field is required";
		} else {
			$horsepower = cleanInput($_POST["horsepower"]);
		}
						if ( empty($_POST["topspeed"]) ) {
			$topspeed_error = "This field is required";
		} else {
			$topspeed = cleanInput($_POST["topspeed"]);
		}
						if ( empty($_POST["transmission"]) ) {
			$transmission_error = "This field is required";
		} else {
			$transmission = cleanInput($_POST["transmission"]);
			
		}
		if($year_error == "" && $make_error == "" && $model_error == "" && $horsepower_error == "" && $topspeed_error == "" && $transmission_error == ""){
			
			$msg = createCars($year, $make, $model, $horsepower, $topspeed, $transmission);
			
			if($msg != ""){
				$year = "";
				$make = "";
				$model = "";
				$horsepower = "";
				$topspeed = "";
				$transmission = "";
				
				echo $msg;
			}
		}
    }
			
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
 ?>
 
 <p>
	Welcome, <?=$_SESSION["user_email"]; ?>
	<a href="?logout=1"> Logout </a>
</p>
 
<h2>Add cars data:</h2>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="year" >Year</label><br>
	<input id="year" name="year" type="text" value="<?=$year; ?>"> <?=$year_error; ?><br><br>
  	<label for="make" >Make</label><br>
	<input id="make" name="make" type="text" value="<?=$make; ?>"> <?=$make_error; ?><br><br>
  	<label for="model" >Model</label><br>
	<input id="model" name="model" type="text" value="<?=$model; ?>"> <?=$model_error; ?><br><br>
	<label for="horsepower" >Horsepower</label><br>
	<input id="horsepower" name="horsepower" type="text" value="<?=$horsepower; ?>"> <?=$horsepower_error; ?><br><br>
	<label for="topspeed" >Topspeed</label><br>
	<input id="topspeed" name="topspeed" type="text" value="<?=$topspeed; ?>"> <?=$topspeed_error; ?><br><br>
	<label for="transmission" >Transmission</label><br>
	<input id="transmission" name="transmission" type="text" value="<?=$transmission; ?>"> <?=$transmission_error; ?><br><br>
	<input type="submit" name="create" value="Save">
  </form>