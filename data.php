<?php

	require_once("functions.php");

	if(!isset($_SESSION["id_from_db"])){

		header("Location: login.php");
	}
	
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
			
			$msg = createCarData($year, $make, $model, $horsepower, $topspeed, $transmission);
			
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
	<?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logout</a>
</p>

 <h2>Add cars data:</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  
  	<label>Year</label><br>
	<input name="Year" type="text" value="<?=$year; ?>"> <?=$year_error; ?><br><br>
  	<label>Make</label><br>
	<input name="Make" type="text" value="<?=$make; ?>"> <?=$make_error; ?><br><br>
  	<label>Model</label><br>
	<input name="Model" type="text" value="<?=$model; ?>"> <?=$model_error; ?><br><br>
	<label>Horsepower</label><br>
	<input name="Horsepower" type="text" value="<?=$horsepower; ?>"> <?=$horsepower_error; ?><br><br>
	<label>Topspeed</label><br>
	<input name="Topspeed" type="text" value="<?=$topspeed; ?>"> <?=$topspeed_error; ?><br><br>
	<label>Transmission</label><br>
	<input type="radio" name="type" value="automatic" checked>Automatic
	<br>
	<input type="radio" name="type" value="manual">Manual<br><br>
	<input type="submit" name="create" value="Save">
  </form>