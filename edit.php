<?php
	//edit.php
	require_once("edit_functions.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updateToit($_POST["id"],$_POST["nimi"],$_POST["hind"]);
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
		$toit_object = getSingleToit($_GET["edit"]);
		var_dump($toit_object);
	}
	
	
	
	
	
?>
<h2>Muuda toit</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>" > 
  	<label for="nimi" >nimi</label><br>
	<input id="nimi" name="nimi" type="text" value="<?php echo $toit_object->nimi;?>" ><br><br>
  	<label for="hind" >hind</label><br>
	<input id="hind" name="hind" type="text" value="<?=$toit_object->hind;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>