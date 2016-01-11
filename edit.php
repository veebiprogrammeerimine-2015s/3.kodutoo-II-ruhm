<?php

	$page_title = "Muudatuste leht";
	$file_name = "edit.php";
	
?>


<?php require_once("menu.php")?>

<?php
	
	require_once("edit_functions.php");
	
	if(isset($_POST["update"])){
		
		updateTournament($_POST["id"], $_POST["tournament"], $_POST["team_one"], $_POST["team_two"], $_POST["time"]);
	}
	
	if(!isset($_GET["edit"])){
		
		header("location: table.php");
		
	}else{
		
		$tournament_object = getSingleTournamentData($_GET["edit"]);
		var_dump($tournament_object);
	}
	
	
	
?>
<h2>Muuda turniiri</h2>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input type="hidden" name="id" value="<?=$_GET["edit"];?>" >
		<label for="tournament" >Turniiri nimi</label><br>
		<input id="tournament" name="tournament" type="text" value="<?=$tournament_object->tournament;?>"> <br><br>
		<label for="team_one" >Esimene tiim</label><br>
		<input id="team_one" name="team_one" type="text" value="<?=$tournament_object->team_one;?>"> <br><br>
		<label for="team_two" >Teine tiim</label><br>
		<input id="team_two" name="team_two" type="text" value="<?=$tournament_object->team_two;?>"> <br><br>
		<label for="time" >Turniiri toimumisaeg</label><br>
		<input id="time" name="time" type="text" value="<?=$tournament_object->time;?>"> <br><br>
		<input type="submit" name="update" value="Salvesta">
	  </form>