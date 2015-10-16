<?php
	require_once("edit_functions.php");
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		updateCar($_POST["id"],$_POST["number_plate"],$_POST["color"]);
	}
	if(!isset($_GET["edit"])){
		//kui aadressi real ei ole ?edit=, suuname table lehele
		header("location: table.php");
	}else{
		//küsime andmebaasist andmed id järgi
		$car_object = getSingleCarData($_GET["edit"]);
		var_dump($car_object);
	}
	//id mida muudame
	//echo $_GET["edit"];
	//vaja saada kätte kõige uuemad andmed id kohta
	
?>

<h2>Muuda auto</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>">
  	<label for="number_plate" >auto nr</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?=$car_object->number_plate;?>"><br><br>
  	<label for="color">värv</label><br>
	<input id="color" name="color" type="text" value="<?=$car_object->color;?>"><br><br>
  	<input type="submit" name="update" value="Salvesta">
  </form>