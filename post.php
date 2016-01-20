<?php
	require_once("functions.php");
	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
	
	
	$send_tekst = "";
	$send_tekst_error = "";


// *********************
    if(isset($_POST["salvesta"])){

			if ( empty($_POST["send_tekst"]) ) {
				$send_tekst_error = "See v�li on kohustuslik";
				}else{
					$send_tekst = cleanInput($_POST["send_tekst"]);
				}
			

			if(	$send_tekst_error == ""){
				echo $send_tekst;
				
				// functions.php failis k�ivina funktsiooni
				// msq on message funktsioonist mis tagasi saadame
				$msg = updateComment($send_tekst);
			
				if($msg != ""){
				//salvestamine �nnestus
				// teen t�hjaks input value'd
				$post_tech = "";
								
				echo $msg;
			}

    } // create if end
}
	
// funktsioon, mis eemaldab k�ikv�imaliku �leliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  return $data;
  }


	
?>

<!DOCTYPE html>
<html>
<body>


   
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input align="center"  name="send_tekst" type="text"  placeholder="lisa kuulutus" value="<?php echo $send_tekst; ?>"> <?php echo $send_tekst_error; ?><br><br>
  	<input align="center"  type="submit" align="center" name="salvesta" value="SALVESTA KUULUTUS">
  </form>
  
  
  </form>
</body>
</html>