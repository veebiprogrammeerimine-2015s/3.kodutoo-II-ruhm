<?php
	//edit.php
	require_once("edit_functions.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updateFlower($_POST["id"],$_POST["flower"],$_POST["color"]);
	}
	
	
	
	//id mida muudame
	if(!isset($_GET["edit"])){
		
		// ei ole aadressieal ?edit=midagi
		// suunan table.php lehele
		
		header("location: table.php");
		
	}else{
		// saada kätte kõige uuemad andmed selle id kohta
		//numbrimärk ja värv
		//küsime andmebaasist andmed id järgi
		
		//saadan kaasa id
		$flower_object = getSingleFlowerData($_GET["edit"]);
		var_dump($flower_object);
	}
	
	
	
	
	
?>
<h2>Muuda autot</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>" > 
  	<label for="flower" >auto nr</label><br>
	<input id="flower" name="flower" type="text" value="<?php echo $flower_object->flower;?>" ><br><br>
  	<label for="color" >värv</label><br>
	<input id="color" name="color" type="text" value="<?=$flower_object->color;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>