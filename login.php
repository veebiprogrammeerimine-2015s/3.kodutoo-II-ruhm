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

		if(isset($_POST["login"])){
			if ( empty($_POST["email"]) ) {
				$email_error = "This field is required";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "This field is required";
			}else{
				$password = cleanInput($_POST["password"]);
			}
      // Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Welcome! Your login is ".$email." and password is ".$password;
				
				$password_hash = hash("sha512", $password);
				
				// functions php failis käivitan funktsiooni
				loginUser($email, $password_hash);
			}
		} // login if end

    if(isset($_POST["create"])){
		
		if ( empty($_POST["first_name"]) ) {
				$first_name_error = "This field is required";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$first_name = cleanInput($_POST["first_name"]);
			}
		if ( empty($_POST["last_name"])	) {			
				$last_name_error = "This field is required";
			}else{
				$last_name = cleanInput($_POST["last_name"]);
			}
		if ( empty($_POST["date"])	) {
				$date_error = "This field is required";
			}else{
				$date = cleanInput($_POST["date"]);
			}
		if ( empty($_POST["cemail"])	) {
				$cemail_error = "This field is required";	
			}else{
				$cemail = cleanInput($_POST["cemail"]);
			}
		if ( empty($_POST["cpass"])	) {
			$cpassword_error = "This field is required";
			}else{
			$cpassword = cleanInput($_POST["cpass"]);
			}
		if(	$cemail_error == "" && $cpassword_error == ""){
			echo "Welcome! Your login is ".$cemail." and password is ".$cpassword; //cepass ja cemail siia kirja
			
			$password_hash = hash("sha512", $cpassword);
			echo "<br>";
			echo $password_hash;
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
	<h2>Login</h2>
		<form action="login.php" method="post">
		<input name="email" type="email" placeholder="Email" > <?php echo $email_error ?>	<br><br>
		<input name="password" type="password" placeholder="Password" > <?php echo $password_error ?>	<br><br>
		<input type="submit" name="login" value="Login" >	<br><br>
		</form>
		
		<h2>Create user</h2>
		<form action="login.php" method="post" >
		<input name="cemail" type="email" placeholder="Email "><?php echo $cemail_error ?><br><br>
		<input name="cpass" type="password" placeholder="Password "><?php echo $cpassword_error ?><br><br>
		<input name="cpass" type="password" placeholder="Confirm password "> <?php echo $cpassword_error ?><br><br>
		<input name="first_name" type="text" placeholder="First name"><?php echo $first_name_error ?><br><br>
		<input name="last_name" type="name" placeholder="Last name"><?php echo $last_name_error ?><br><br>
		<input name="date" type="age" placeholder="Age"><?php echo $date_error ?><br><br>
		<input type="submit" name="create" value="Sign up">
		</form>
	</body>
</html>