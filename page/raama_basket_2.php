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
//tulemuse salvestamine	
	$basket = $basket_error = "";
	
	if(isset($_POST["save"])){
			if ( empty($_POST["basket"]) ) {
				$basket_error = "Palun sisesta tulemus";
			}else{
				$basket = cleanInput($_POST["basket"]);
			}
			
	if(	$basket_error == ""){
				

				$msg = saveBasket($_GET["k"],$basket);
				
				if($msg != ""){
					
					if($_GET["k"] == "9"){
						header("Location: raama_basket_final.php");
						var_dump($_GET["k"]);
						exit();
					}
					$k = $_GET["k"]+1;
					header("Location: raama_basket_2.php?k=".$k);
						
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
<h1>Rääma Discgolf</h1>

<h2><?=$_GET["k"];?>. korv</h2>
<p>Par=3</p>
  <form action="raama_basket_2.php?k=<?php echo $_GET["k"]; ?>" method="post" >
  	<label for="basket" >Minu tulemus</label>
	<input id="basket" name="basket" type="number" value="<?=$basket; ?>"> <?=$basket_error; ?><br>	
  	<input type="submit" name="save" value="Salvesta">
  </form>