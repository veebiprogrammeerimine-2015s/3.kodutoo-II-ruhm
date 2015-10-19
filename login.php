
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
	$create_password_error = "";
	$password_error = "";
	$email_error = "";
	$create_email_error = "";
	
	$password = "";
	$email = "";
	$create_email = "";
	$create_password = "";
	
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
		
		
			 //======================================================================================
			//===================СОЗДАНИЕ КНОПКИ "РЕГИСТРАЦИИ" CREATE===============================
			//======================================================================================
	if(isset($_POST["create"])){
		
			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$create_email_error == "" && $create_password_error == ""){
				echo "Nüüd oled registreeritud! <br> Kasutajanimi: ".$create_email." <br> Parool: ".$create_password;
				
				$password_hash = hash("sha512", $create_password);
				echo "<br>";
				echo $password_hash;
				
				createUser($create_email, $password_hash);
				
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



<?php require_once("start/header.php"); ?>
		<h2>Log in</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
			<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
			<input name="login" type="submit" value="Login">
		</form> 
	
		<h2>Create user</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
			<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
			COMMENT THIS SITE TRY IT <br><br>
			<textarea name="comment" rows="5" cols="40"></textarea><br><br>
			kas teil meeldib?<input type="radio" name="gender" value="female">Jah
			<input type="radio" name="gender" value="male">Ei <br><br>
			<input name="create" type="submit" value="create user" > <br><br>
			
		</form>
<?php require_once("start/footer.php"); ?>