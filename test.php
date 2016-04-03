<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Söökla menüü</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<center>
<?php

require_once("functions2.php");

//loome AB ühenduse
    require_once("config.php");
	
    $database = "uus";
    $mysqli = new mysqli($servername, $username, $password, $database);
    
    //check connection
    if($mysqli->connect_error) {
        die("connect error ".mysqli_connect_error());
    }
	
	require_once("functions2.php");
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
$nimi = $hind= $nimi_error = $hind_error = "";
	
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){

		if ( empty($_POST["nimi"]) ) {
			$nimi_error = "See väli on kohustuslik";
		}else{
			$nimi = cleanInput($_POST["nimi"]);
		}

		if ( empty($_POST["hind"]) ) {
			$hind_error = "See väli on kohustuslik";
		} else {
			$hind = cleanInput($_POST["hind"]);
		}

		if(	$nimi_error == "" && $hind_error == ""){
			
			// functions.php failis käivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createNimi($nimi, $hind);
			
			if($msg != ""){
				//salvestamine õnnestus
				// teen tühjaks input value'd
				$nimi = "";
				$hind = "";
								
				echo $msg;
				
			}
			
		}

    } // create if end
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	  
	  function createNimi($nimi, $hind){
		// globals on muutuja kõigist php failidest mis on ühendatud
		//$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO toidud (nimi, hind) VALUES (?,?)");
		$stmt->bind_param("si", $nimi, $hind);
		
		$message = "";
		
		if($stmt->execute()){
			// see on tõene siis kui sisestus ab'i õnnestus
			$message = "Edukalt sisestatud andmebaasi";
			
		}else{
			// execute on false, miski läks katki
			echo $stmt->error;
		}
		
		$stmt->close();
		 $GLOBALS["mysqli"]->close();

		return $message;
		
	}
	  ?>
	  
	  	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>
	  <form action="edit.php" method="get"> 
<input type="submit" value="Muuta andmeid"></form> 
 <h2>Lisa toit</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="nimi" > Toit</label><br>
	<input id="nimi" name="nimi" type="text" value="<?=$nimi; ?>"> <?=$nimi_error; ?><br><br>
  	<label>Hind</label><br>
	<input name="hind" type="text" value="<?=$hind; ?>"> <?=$hind_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>