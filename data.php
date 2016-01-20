<?php
	require_once("functions.php");
	require_once("header.php");
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>  <li><a href="?logout=1"> Logi välja</a></li> 
</p>

<p>
	Minu tabelid <a href="tables.txt"> siin</a> 
	<br> Minu tabeli workbrench <a href="tabelid.png"> siin</a>
		<br> Minu eelmised kodutood <a href="kodutood.php"> siin</a>
</p>



<!DOCTYPE html>
<html>
<h1>Olete sisselogitud!</h1>
<p>Nuud te voite lisada sinu kuulutus, ja vaatama mida lisati teised.
	<br>Ka te voite saada sonum teisele kasutajale! </p>
<br> Vaata kõik kasutajad <a href="table.php"> siin!</a>
<br> Vaata sinu postitusi <a href="Single_post.php"> siin!</a>
</body>
</html>

<h1 align="center">Kõik kuulutused!</h1>
<?php require_once("table_post.php");?>
<?php require_once("post.php");?>
