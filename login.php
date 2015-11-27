<?php

	//laeme funktsiooni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: data.php");
	}
	
  // muuutujad errorite jaoks
	$email_error ="";
	$password_error = "";
	$first_name_error = "";
	$last_name_error = "";
	$date_error = "";
	$cemail_error ="";
	$cpassword_error ="";
	
	
	
  // muutujad väärtuste jaoks
	$email ="";
	$password = "";
	$first_name = "";
	$last_name = "";
	$date = "";
	$cemail ="";
	$cpassword ="";


	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // *********************
    // **** LOGI SISSE *****
    // *********************
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
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$password_hash = hash("sha512", $password);
				
				// functions php failis käivitan funktsiooni
				loginUser($email, $password_hash);
			}

		} // login if end

    // *********************siia tuleb lisada logi sisse issetid, et süstemaatika 
    // ** LOO KASUTAJA *****
    // *********************
    if(isset($_POST["create"])){
		
		
		if ( empty($_POST["first_name"]) ) {
				$first_name_error = "See väli on kohustuslik";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$first_name = cleanInput($_POST["first_name"]);
			}
		
		if ( empty($_POST["last_name"])	) {			
				$last_name_error = "See väli on kohustuslik";
			}else{
				$last_name = cleanInput($_POST["last_name"]);
			}
		
		if ( empty($_POST["date"])	) {
				$date_error = "See väli on kohustuslik";
			}else{
				$date = cleanInput($_POST["date"]);
			}
		
		
		
		if ( empty($_POST["cemail"])	) {
				$cemail_error = "See väli on kohustuslik";	
			}else{
				$cemail = cleanInput($_POST["cemail"]);
			}
		
		if ( empty($_POST["cpass"])	) {
			$cpassword_error = "See väli on kohustuslik";
			}else{
			$cpassword = cleanInput($_POST["cpass"]);
			}


		if(	$cemail_error == "" && $cpassword_error == ""){
			echo "Võib kasutajat luua! Kasutajanimi on ".$cemail." ja parool on ".$cpassword; //cepass ja cemail siia kirja
			
			$password_hash = hash("sha512", $cpassword);
			echo "<br>";
			echo $password_hash;
			
			// functions.php failis käivina funktsiooni
			createUser($cemail, $password_hash);
			
		}

    } // create if end

	}

  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
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
	<title>Login Page</title>
</head>
<body>

	<h2>Logi sisse</h2>
	<form action="login.php" method="post">
	<input name="email" type="email" placeholder="E-post" > <?php echo $email_error ?>	<br><br>
	<input name="password" type="password" placeholder="Parool" > <?php echo $password_error ?>	<br><br>
	<input type="submit" name="login" value="Logi sisse" >	<br><br>
	</form>
	
	
	<h2>Tee kasutaja</h2>
	<form action="login.php" method="post" >
	<input name="cemail" type="email" placeholder="Email ">*<?php echo $cemail_error ?><br><br>
	<input name="cpass" type="password" placeholder="Parool ">*<?php echo $cpassword_error ?><br><br>
	<input name="first_name" type="text" placeholder="Eesnimi">*<?php echo $first_name_error ?><br><br>
	<input name="last_name" type="name" placeholder="Perekonnanimi">*<?php echo $last_name_error ?><br><br>
	<input name="date" type="age" placeholder="Vanus">*<?php echo $date_error ?><br><br>
	<input type="submit" name="create" value="Registeeri">
	</form>
</body>
</html>