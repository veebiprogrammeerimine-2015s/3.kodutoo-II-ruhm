<?php
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";
	
	//Laeme funktsiooni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
		
	}
	
	//Login välja kui aadressi real on ?logout=1
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}

 ?>
 
 <p>
	Tere, <?=$_SESSION["user_email"]; ?>
	<a href="?logout=1"> Logi välja </a>
</p>

