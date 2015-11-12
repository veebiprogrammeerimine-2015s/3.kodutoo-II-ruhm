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
	  
	 if(isset($_POST["start_game"])){
		 header("Location: raama_basket_0.php");
	 }
?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Discgolfi pargid</h1><br>
<h2>Rääma discgolfi park</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input type="submit" name="start_game" value="Mine mängima">
  </form>
<h2>Jõekääru discgolfi park</h2>
<h2>Nõmme discgolfi park</h2>
<h2>Jõulumäe discgolfi park</h2>
	
