<?php
	
	require_once("edit_function.php");
	
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["uptade"])){
		
		uptadeCAR($_POST["id"], $_POST["number_plate"], $_POST["color"]);
		
		
		
	}
	
	
	
	
	//edit.php
	//id mida muudame
	if(!isset($_GET["edit"])){
		
			//ei ole aadressieal ?edit=midagi
			// suunan table.php legele
			header("location: table.php");
			
	}else{
		
			//saada kätte kõige uuemad andmed selle id kohta
			//numbrimärk ja värv
			//küsime andmebaasist andmed id järgi
			//saadan kaasa id
			$car_object = getSingleCarData($_GET["edit"]);
			var_dump($car_object);
		
	}
	

	

?>

<h2>Kuulutused</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="Kuulutus_nimi" >kuulutus nr</label><br>
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>">
	<input id="kuulutus_nr" name="kuulutus_nr" type="text" value="<?php echo $car_object->number_plate;?>"><br><br>
	<label for="color">Varv</label><br>
	<input name="color" type="text" value="<?=$car_object->color;?>"> <br><br>
	<input type="submit" name="uptade" value="Salvesta">
	</form> 