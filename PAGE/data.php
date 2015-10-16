<?php

	//muutujad
	$car_plate = $color = $car_plate_error = $color_error = "";
	
	//sisestus vorm
	
	//laeme functions faili
	require_once("functions.php");
	
	//kontrollin, kas kasutaja ei ole sisse loginud
	if(!isset($_SESSION["id_from_db"])){
		//suuname login lehele kui on sisseloginud
		header("Location: login.php");
	}
	//logni välja
	if(isset($_GET["logout"])){
		//kustutab kõik session muutujad
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_POST["create"])){
		
		//kas on tühi
		if(empty($_POST["car_plate"])){
			//jah oli tühi
			$car_plate_error = "Numbrimärk on vajalik";
		}else{
			$car_plate = test_input($_POST["car_plate"]);
		}
			
		//kas create email on tühi
		if(empty($_POST["color"])){
			//jah oli tühi
			$color_error= "Värv on vajalik";
		}else{
			$color = test_input($_POST["color"]);
		}
		
		if($car_plate_error == "" && $color_error == ""){
				
				echo "Plate nr ".$car_plate." color is ".$color;
				//msg = message
				$msg = createCarPlate($car_plate, $color);
				if($msg != ""){
					//salvestamine õnnestus, teen väljad tühjaks
					$car_plate = "";
					$color = "";
					echo $msg;
				}
		}
	}
	function test_input($data) {
		$data = trim($data);                // võtab tühikud, tabid ja enterid ära
		$data = stripslashes($data);        // võtab \\ ära
		$data = htmlspecialchars($data);    // muudab asjad tekstiks
		return $data;	
	}
?>

<?php
$page_title = "data";
$file_name = "data.php";
?>	

<?php require_once("../header.php");?>

<p>
<h2>Data</h2>
Tere, <?=$_SESSION["user_email"];?><br>
<a href="?logout=1"> Logout</a>
</p>

<h2>Lisa auto</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="car_plate" >auto nr</label><br>
	<input id="car_plate" name="car_plate" type="text" value="<?=$car_plate; ?>"> <?=$car_plate_error; ?><br><br>
  	<label>värv</label><br>
	<input name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>
  
<?php require_once("../footer.php");?>