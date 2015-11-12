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
	
	$basket1 = $basket1_error = "";
	
	if(isset($_POST["basket1"])){
			if ( empty($_POST["basket1"]) ) {
				$basket1_error = "Palun sisesta tulemus";
			}else{
				$basket1 = cleanInput($_POST["basket1"]);
			}
			
	if(	$basket1_error == ""){
				
				
				// functions.php failis käivina funktsiooni
				//msg on message
				$msg = savebasket1 ($basket1);
				
				if($msg != ""){
					//salvestamine õnnestus
					//suunan 2. korvi lehele
					header("Location: raama_basket_2.php");
					
					
					
				}
			}
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>
<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Rääma Discgolf</h1>
<h2>1. korv</h2>
<p>Par=3</p>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="basket1" >Minu tulemus</label>
	<input id="basket1" name="basket1" type="number" value="<?=$basket1; ?>"> <?=$basket1_error; ?><br>	
  	<input type="submit" name="save" value="Salvesta">
  </form>