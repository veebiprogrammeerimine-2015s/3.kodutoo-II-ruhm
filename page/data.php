<?php
		$page_title = "Data";
		$file_name = "index.php";
		require_once("funtions.php");
		
		
		$title_error = "";
		$ingredients_error = "";
		$preparation_error = "";
		
		$title = "";
		$ingredients = "";
		$preparation = "";
		
		
		
		
	
	//Kontrollin kas kasutaja on sisse loginud
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
		
		
		
	}
	//aadressireal on ?logout=?
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: index.php");
		
	}
	
	
if(isset($_POST["add_retsept"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["title"]) ) {
			$title_error = "See väli on kohustuslik";
		}else{
			$title = cleanInput($_POST["title"]);
		}
		
		if ( empty($_POST["ingredients"]) ) {
			$ingredients_error = "See väli on kohustuslik";
		}else{
			$ingredients = cleanInput($_POST["ingredients"]);
		}

		if ( empty($_POST["preparation"]) ) {
			$preparation_error = "See väli on kohustuslik";
		}else{
			$preparation = cleanInput($_POST["preparation"]);
		}
		
		// mõlemad on kohustuslikud
		if($ingredients_error == "" && $title_error == "" && $preparation_error == ""){
			//salvestate ab'i fn kaudu addRetsept
		$msg = addRetsept($title, $ingredients, $preparation);
			
			if($msg != ""){
				//salvestamine õnnestus
				
				$title = "";
				$ingredients = "";
				$preparation = "";
				
				echo $msg;
				
			}
		}
		
	}
	
	
	
	
	function cleanInput($data) {
  	$data = trim($data); //tabulaator, tühikud, Enter
  	$data = stripslashes($data); //Kaldkriipsud
  	$data = htmlspecialchars($data); // 
  	return $data;
  }
	

?>
<?php
	
	require_once("../header.php");



?>



<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

<p>
	Tere, <?=$_SESSION["user_email"]; ?>
	<a href="?logout=1">Logi väljalja</a><br><br>

</p>

  <h2>Lisa Retsept</h2>
  <form id="usrform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="title" type="text" placeholder="Retsepti nimi" value="<?php echo $title; ?>"> <?php echo $title_error; ?><br><br>
  	<textarea name="ingredients" form="usrform" placeholder="Koostisosad"><?php echo $ingredients; ?></textarea><?php echo $ingredients_error; ?><br><br>
  	<textarea name="preparation" form="usrform" placeholder="Valmistamine"><?php echo $preparation; ?></textarea><?php echo $preparation_error; ?><br><br>
  	<input type="submit" name="add_retsept" value="Lisa">
  </form>

  
<body>
<html>
<?php
	
	require_once("../footer.php");



?>