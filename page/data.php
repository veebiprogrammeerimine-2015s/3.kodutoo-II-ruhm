<?php
//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}	

//alusta mängu Rääma pargis	
	 if(isset($_GET["start_game_raama"])){
		 header("Location: raama_basket_0.php");
	 }
//suunan ajaloo lehele
	if (isset($_GET["my_history"])){
		header("Location: my_history.php");
	}
?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Discgolfi pargid</h1><br>
<p>
<a href="?start_game_raama=1"> Rääma discgolfi park</a><br>
Jõekääru discgolfi park<br>
Nõmme discgolfi park<br>
Jõulumäe discgolfi park<br><br>

<a href="?my_history=1"> Mängude ajalugu</a>
</p>
	
