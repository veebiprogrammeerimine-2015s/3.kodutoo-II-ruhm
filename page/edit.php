<?php
	//edit.php
	require_once("edit_functions.php");
	
	
	
		if(!isset($_SESSION["id_from_db"])){
		header("Location: table.php");
		
		
		
	}


	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){



		
			updateRetsept($_POST["id"],$_POST["title"], $_POST["ingredients"], $_POST["preparation"]);
		
	}
	
	
	
	//id mida muudame
	if(!isset($_GET["edit"])){
		
		// ei ole aadressieal ?edit=midagi
		// suunan table.php lehele
		
		header("location: table.php");
		
	}else{
		// saada kätte kõige uuemad andmed selle id kohta

		//küsime andmebaasist andmed id järgi
		
		//saadan kaasa id
		$retsept_object = getSingleRetseptData($_GET["edit"]);
		var_dump($retsept_object);
	}
	


	
?>
<h2>Muuda Retsepti</h2>
  <form id="usrform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>" > 
  	<label for="title" >Retsepti nimi</label><br>
	<input id="title" name="title" type="text" value="<?php echo $retsept_object->title;?>" ><br><br>
  	<label for="ingredients" >ingredients</label><br>
	<textarea id="ingredients" form="usrform" name="ingredients"><?php echo $retsept_object->ingredients;?></textarea><br><br>
	<label for="preparation" >preparation</label><br>
	<textarea id="preparation" form="usrform" name="preparation"><?php echo $retsept_object->preparation;?></textarea><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>