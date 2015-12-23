<?php

//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login v‰lja
	if (isset($_GET["logout"])){
		//kustutab kıik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}
//tulemuse salvestamine	
	$basket = $basket_error = "";
	
	if(isset($_POST["save"])){
			if ( empty($_POST["basket"]) ) {
				$basket_error = "Palun sisesta tulemus";
			}else{
				$basket = cleanInput($_POST["basket"]);
			}
			
	if(	$basket_error == ""){
				
				
				// function.php failis k‰ivitan funktsiooni
				//msg on message
				$msg = saveJoekaaru(1,$basket);
				
				if($msg != ""){
					//salvestamine ınnestus
					//suunan 2. korvi lehele
					header("Location: joekaaru_2.php?k=2");
					
					
					
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
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi v‰lja</a>
</p>
<h1>Jıek‰‰ru Discgolf (<?=$_SESSION["game_id"];?>)</h1>
<h2>1. korv</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="basket" >Minu tulemus</label>
	<input id="basket" name="basket" type="number" value="<?=$basket; ?>"> <?=$basket_error; ?><br>	
  	<input type="submit" name="save" value="Salvesta">
  </form>