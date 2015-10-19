
	
<?php
	$create_password_error = "";
	$create_email_error = "";

	$create_email = "";
	$create_password = "";


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

//funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
		function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
  }

?>


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