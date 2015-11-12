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
	$basket2 = $basket2_error = "";
	
	if(isset($_POST["basket2"])){
			if ( empty($_POST["basket2"]) ) {
				$basket2_error = "Palun sisesta tulemus";
			}else{
				$basket2 = cleanInput($_POST["basket2"]);
			}
			
	if(	$basket2_error == ""){
				
				
				// functions.php failis k‰ivina funktsiooni
				//msg on message
				$msg = savebasket2 ($basket2);
				
				if($msg != ""){
					//salvestamine ınnestus
					//suunan 2. korvi lehele
					header("Location: raama_basket_3.php");
					
					
					
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
	<a href="?logout=1"> Logi v‰lja</a>
</p>
<h1>R‰‰ma Discgolf</h1>
<h2>2. korv</h2>
<p>Par=3</p>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="basket2" >Minu tulemus</label>
	<input id="basket2" name="basket2" type="number" value="<?=$basket2; ?>"> <?=$basket2_error; ?><br>	
  	<input type="submit" name="save" value="Salvesta">
  </form>