<?php
	
	//CREATE TABLE user_php (
    //id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    //email VARCHAR(255) NOT NULL,
	//password VARCHAR(128),
	//login VARCHAR(128),
	//adress VARCHAR(255),
	//telephone INT,
    //created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //UNIQUE(email)
	//);
	
	//ma tahaksin tegeleda kunstitarbete e-poega, kus on registreerimissüsteem, 
	//tarbete nimikiri, iga tarbete kirjeldus, on võimalik tarbed tellida, ja tellimise vorm
	
	
		//laeme funktsiooni failis
	require_once("functions.php");
	
		//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: data.php");
	}
	
	
	//Defineerime muutujad vigased
	$email_error = "";
	$password_error = "";
	$createuseremail_error = "";
	$createuserpassword_error = "";
	$createuserlogin_error = "";
	$createuseradress_error = "";
	$createusertelephone_error = "";
	//Defineerime muutujad õiged
	$email = "";
	$password = "";
	$createuseremail = "";
	$createuserpassword = "";
	$createuserlogin = "";
	$createuseradress = "";
	$createusertelephone = "";
	
	
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//***********
		//LOGI SISSE*
		//***********
		if(isset($_POST["login"])){
	//kas epost on tühi
		if( empty($_POST["email"])){
			$email_error = "See väli on kohustuslik";
		}else{ 
			$email = cleanInput($_POST["email"]);
		}
		echo "siin";
		//kas parool on tühi
		if( empty($_POST["password"])){
			$password_error = "See väli on kohustuslik";
		}else{
			$password = cleanInput($_POST["password"]);
		} 		
		
 //Kui oleme siia jõudnud, võime kasutaja sisse logida
 			if($password_error == "" && $email_error == ""){
 				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$password_hash = hash("sha512", $password);
				
				loginUser($email, $password_hash);
			}
	}//login if end
	
	
		//*************
		//LOO KASUTAJA*
		//*************
		
	if(isset($_POST["create"])){ 
		//kas kasutajanime loomine on tühi
		if( empty($_POST["createuserlogin"]) ){
			$createuserlogin_error = "See väli on kohustuslik";
		}else {
				$createuserlogin = cleanInput($_POST["createuserlogin"]);
			}
	
		//kas emaili loomine on tühi
		if( empty($_POST["createuseremail"]) ){
			$createuseremail_error = "See väli on kohustuslik";
		}else{
				$createuseremail = cleanInput($_POST["createuseremail"]);
		}
	
		
		//kas parooli loomine on tühi
		if( empty($_POST["createuserpassword"]) ){
			$createuserpassword_error = "See väli on kohustuslik";
		}else {
 				if(strlen($_POST["createuserpassword"]) < 8) {
 					$createuserpassword_error = "Peab olema vähemalt 8 tähemärki pikk!";
 				}else{
 					$createuserpassword = cleanInput($_POST["createuserpassword"]);
		
 				}
		}
		//kas aadressi loomine on tühi
		if(empty($_POST["createuseradress"])){
			$createuseradress_error = "See väli on kohustuslik";
		}else {
				$createuseradress = cleanInput($_POST["createuseradress"]);
	
		}
		if( empty($_POST["createusertelephone"])){
			$createusertelephone_error = "See väli on kohustuslik";
		}else {
				$createusertelephone = cleanInput($_POST["createusertelephone"]);
		}
		//echo "siin";
		
			if(	$createuserlogin_error == "" && $createuseremail_error == "" && $createuserpassword_error == "" && $createuseradress_error == "" && $createusertelephone_error == ""){
				//echo "siin";
				
					echo "Võib kasutajat luua! Kasutajanimi on ".$createuseremail." ja parool on ".$createuserpassword;
					$password_hash = hash("sha512", $createuserpassword);
					echo "<br>";
					echo $password_hash;

					createUser($createuseremail, $password_hash);
 
			}//create if end
		}

	}	
	
			function cleanInput($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;

	}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
	<h2>Log in</h2>
	 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input name="email" type="email" placeholder="E-post"> <?php echo $email_error; ?><br><br>
		<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?><br><br>
		<input type="submit" name="login" value="Logi sisse"><br><br>
	</form>
	<h2>Create User</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input name="createuserlogin" type="text" placeholder="Kasutaja nimi"> <?php echo $createuserlogin_error; ?><br><br>
		<input name="createuseremail" type="email" placeholder="E-post" value="<?php echo $createuseremail; ?>"> <?php echo $createuseremail_error; ?><br><br>
		<input name="createuserpassword" type="password" placeholder="Parool"> <?php echo $createuserpassword_error; ?><br><br>
		<input name="createuseradress" type="text" placeholder="Aadress"> <?php echo $createuseradress_error; ?><br><br>
		<input name="createusertelephone" type="telephone" placeholder="Telefon"> <?php echo $createusertelephone_error; ?><br><br>
		<input type="submit" name="create" value="Registreeri"><br><br>
		
  </form>
<body>
<html>