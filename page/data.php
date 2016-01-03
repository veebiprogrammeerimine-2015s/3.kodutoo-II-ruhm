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


?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Discgolfi pargid</h1><br>
<p>Mängimiseks vajuta lingile</p>
<p>
<a href="raama_basket_0.php"> Rääma discgolfi park</a><br>
<a href="joekaaru_0.php">Jõekääru discgolfi park</a><br>
Nõmme discgolfi park<br>
Jõulumäe discgolfi park<br><br>

<a href="my_history.php"> Mängude ajalugu</a>
</p>
	
