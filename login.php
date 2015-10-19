
<?php
	
	//laeme funktsioni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisseligunud
	if(isset($_SESSION["id_from_db"])){
		//suunan data lehele
		header("Location: data.php");
	}
	
	// LOGIN.PHP
	
	// ühenduse loomiseks kasuta
	
	
	// ВСЕ ОШИБКИ ИДУТ СЮДА, И ЕЩЕ В 2 ОПРЕДЕЛЕННЫХ МЕСТА ВНИЗУ.
	$password_error = "";
	$email_error = "";
	
	$password = "";
	$email = "";
	
	
	// ПРОВЕРЯЕМ НАЖАЛ ЛИ КТО КНОПКУ СЛ
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//echo "ktonibuty nazhimal knopku";
		//======================================================================================
		//===================CREATE LOG ========================================================
		//======================================================================================
		//======================================================================================
		
		if(isset($_POST["login"])){
		
			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
			// puhastame muutuja võimalikest üleliigsetest sümbolitest
			$email = cleanInput($_POST["email"]);
			}
			
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
				// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Kasutajanimi ja Parool ";
				
				
				
				$password_hash = hash("sha512", $password);
				
				LoginUser($email, $password_hash);
			}
			
			
			 
		} 
		
}
  //funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
		function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
  }
  
  
?>


<?php
	$page_title = "logi sisse";
	$file_name = "login.php";
?>




		<h2>Log in</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
			<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
			<input name="login" type="submit" value="Login">
		</form> 
		
		<?php require_once("start/header.php"); ?>
		<?php require_once("start/footer.php"); ?>
	