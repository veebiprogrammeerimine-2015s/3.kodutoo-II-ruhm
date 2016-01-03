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
//mängu alustamine	
	$game_name_joekaaru =  $game_name_joekaaru_error =  "";
	
	if(isset($_POST["create_game_joekaaru"])){
			if ( empty($_POST["game_name_joekaaru"]) ) {
				$game_name_joekaaru_error = "Palun pane mängule nimi!";
			}else{
				$game_name_joekaaru = cleanInput($_POST["game_name_joekaaru"]);
			}
	if(	$game_name_joekaaru_error == ""){
		// functions.php failis käivitan funktsiooni
				//msg on message
				$msg = createGameJoekaaru($game_name_joekaaru);
				
				if($msg != ""){
					//salvestamine õnnestus
					//suunan 1. korvi lehele
					header("Location: joekaaru_2.php?k=1");
					
					echo $msg;
					
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
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Jõekääru Discgolf</h1>
<h2>Loo mäng</h2><br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="game_name_joekaaru" >Mängu nimetus</label> <input id="game_name_joekaaru" name="game_name_joekaaru" type="text" value="<?=$game_name_joekaaru; ?>"> <?=$game_name_joekaaru_error; ?>
	<input type="submit" name="create_game_joekaaru" value="Alusta mängu">
  </form>