<?php
	$page_title = "Muudatuste leht";
	$file_name = "edit.php";
	
?>

<?php require_once("menu.php")?>
<?php
	
	require_once("edit_functions.php");
	
	if(isset($_POST["update"])){
		updateCars($_POST["id"], $_POST["year"], $_POST["make"], $_POST["model"], $_POST["horsepower"], $_POST["topspeed"], $_POST["transmission"]);
	}
	
	if(!isset($_GET["edit"])){
		header("location: table.php");

	}else{
		
		$Cars_object = getSingleCarsData($_GET["edit"]);
		var_dump($Cars_object);
	}
?>
<h2>Edit Car data</h2> 
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input type="hidden" name="id" value="<?=$_GET["edit"];?>" >
		<label id="year" >Year</label><br>
		<input for="year" name="year" type="text" value="<?=$year->year; ?>"> <br><br>
		<label id="make" >Make</label><br>
		<input for="make" name="make" type="text" value="<?=$make->make; ?>"> <br><br>
		<label id="model" >Model</label><br>
		<input for="model" name="mdel" type="text" value="<?=$model->model; ?>"> <br><br>
		<label id="horsepower" >Horsepower</label><br>
		<input for="horsepower" name="horsepower" type="text" value="<?=$horsepower->horsepower; ?>"> <br><br>
		<label id="topspeed" >Topspeed</label><br>
		<input for="topspeed" name="topspeed" type="text" value="<?=$topspeed->topspeed; ?>"> <br><br>
		<label id="transmission" >Transmission</label><br>
		<input for="transmission" name="transmission" type="text" value="<?=$transmission->transmission; ?>"> <br><br>
		<input type="submit" name="create" value="Save">
	</form>