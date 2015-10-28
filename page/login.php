<?php

	//laeme funktsiooni faili
	require_once("function.php");
	
	//kontrollin, kas kasutaja on sisse loginud
	if(isset($_SESSION["id_from_db"])){
		//suunan data lehele
		header("Location: data.php");
	}
	
// muutujad errorite
	$email_error = "";
	$password_error = "";
	$first_name_error = "";
	$last_name_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$gender_error = "";
	
 // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$first_name = "";
	$last_name = "";
	$create_email = "";
	$create_password = "";
	$gender = "";
	
	//kontrollin kas keegi vajutas nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
	// *********************
    // **** LOGI SISSE *****
    // *********************
				
				// kontrollin mis nuppu vajutati
		if(isset($_POST["login"])){
			
				//kas e-post on tyhi
			if( empty($_POST["email"])) {
				//jah oli tyhi
				$email_error = "See väli on kohustuslik";
				}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);				
			}
			if( empty($_POST["password"])) {
				//jah oli tyhi
				$password_error = "See väli on kohustuslik";
				
			}else{
				$password = cleanInput($_POST["password"]);
			}
		// Kui oleme siia jõudnud, võime kasutaja sisse logida	
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email;
				
				$password_hash = hash("sha512", $password);
				
				// functions php failis käivitan funktsiooni
				 loginUser($email, $password_hash);
				
				
				
				
			}
		} 
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
		
			if( empty($_POST["first_name"])) {
				//jah oli tyhi
				$first_name_error = "See väli on kohustuslik";
				}else{
				$first_name = cleanInput($_POST["first_name"]);				
			}
			
			if( empty($_POST["last_name"])) {
				//jah oli tyhi
				$last_name_error = "See väli on kohustuslik";
				}else{
				$last_name = cleanInput($_POST["last_name"]);
			}
			
			if( empty($_POST["create_email"])) {
				//jah oli tyhi
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if( empty($_POST["create_password"])) {
				//jah oli tyhi
				$create_password_error = "See väli on kohustuslik";
			}else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$create_email_error == "" && $create_password_error == "" && $first_name_error == "" && $last_name_error == ""){
				echo "Kasutajakonto edukalt loodud! Kasutajanimi on ".$create_email;

			$password_hash = hash("sha512", $create_password);
				//echo "<br>";
				//echo $password_hash;
				
				// functions.php failis käivina funktsiooni
				createUser($first_name, $last_name, $create_email, $password_hash);

			}
		} // create if end
	}
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  
  //paneme ühenduse kinni. See ka viia function.php-sse???
 // $mysqli->close();
?>

<?php

	$page_title = "login leht";
	$file_name = "login.php";


?>
<?php require_once("../header.php"); ?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
	 
	<h2>Login</h2>
	<form action="login.php" method="post">
	<input name="email" type="email" placeholder="E-post"><?php echo $email_error ?> <br><br>
	<input name="password"type="password" placeholder="Parool" ><?php echo $password_error ?> <br><br>
	<input name="login" type="submit" value="Logi sisse"> <br><br>
	</form>
	<h2> Konto loomine</h2>
	<form action="login.php" method="post" >
	<input name="first_name" type="text" placeholder="Eesnimi"><?php echo $first_name_error ?> <br><br>
	<input name="last_name" type="text" placeholder="Perekonnanimi"><?php echo $last_name_error ?> <br><br>
	<input name="create_email" type="email" placeholder="E-post"><?php echo $create_email_error ?> <br><br>
	<input name="create_password" type="password" placeholder="Parool"><?php echo $create_password_error ?> <br><br>
	<!--<input type="radio" name="gender" value="female">Naine
	<input type="radio" name="gender" value="male">Mees <br><br>-->
	<input name="create" type="submit" value="Registreeri">
	</form>
	<br><br>
	<p>Mvp ideeks mõtlesin teha mingi veebirakenduse disc golfi jaoks. Ma pole päris kindel, kuidas ja kas seda teha saab, aga esialgne mõte oli, et kasutaja saaks sisestada, mis on raja par ja siis sisestada mitu viset tal endal ketta korvi saamiseks kulus. Samuti võiks rakendus näidata ka üldskoori, kus on summeeritud kõikide radade par ning enda skoor. Loodetavasti midagi sellist sobiks!?</p>
	
	
<?php require_once("../footer.php"); ?>