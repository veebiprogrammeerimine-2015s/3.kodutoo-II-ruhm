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





?>





<!DOCTYPE html>
<html>
<body>


   
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="send_tekst" type="text" placeholder="k" value="<?php echo $send_tekst; ?>"> <?php echo $send_tekst_error; ?><br><br>
	<input type="submit" name="salvesta" value="SALVESTA">
  </form>
  
  
  </form>
</body>
</html>