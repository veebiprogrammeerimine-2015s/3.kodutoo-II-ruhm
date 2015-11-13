<?php
// ühenduse loomiseks kasuta
		//laeme funktsiooni faili
	require_once("function.php");
	
	//kontrollin, kas kasutaja on sisse loginud
	if(isset($_SESSION["id_from_db"])){
		//suunan data lehele
		header("Location: data.php");
	}

//echo $_POST["email"];

//defineerime muutujad
$email_error="";
$password_error="";

//kontrollin kas keegi vajutas nuppu
if($_SERVER["REQUEST_METHOD"]=="POST"){
	
	

// kontrollin mis nuppu vajutati
		if(isset($_POST["login"])){

	if(empty($_POST["email"])){
		//jah oli tühi
		$email_error = "See väli on kohustuslik";
}
else{

//puhastame muutuja võimalikest üleliigsetest sümbolitest
$email = cleanInput($_POST["email"]);
}
//kas parool on tühi
	//jah on tühi
if(empty($_POST["password"])){
		$password_error = "See väli on kohustuslik";
}
else{	
		$password = cleanInput($_POST["password"]);
		}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$password_hash = hash("sha512", $password);
				
				loginUser($email, $password_hash);
			
				
	}
	
		}
}	
	
	//Paneme ühenduse kinni

	
	
	
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
  	return $data;
  }
?>

<?php
	$page_title = "Login leht";
	$file_name = "";
?>


<?php require_once("../header.php"); ?>


<title>Login Page </title>

<h2>Lehekülg</h2>


<h2>Login</h2>
	<form action="login.php" method="post">
	<input name="email" type="email" placeholder="E-post"><?php echo $email_error ?> <br><br>
	<input name="password"type="password" placeholder="Parool" ><?php echo $password_error ?> <br><br>
	<input name="login" type="submit" value="Logi sisse"> <br><br>
	</form>
<h2> <a href="../page/leht2">Not user? <br>Create User here!<br> </a> </h2>



 Idee kirjeldus. Lisan lehele Logimis ja registeerimis vormid, peale mida lisan lehti juurde , kuhu saab lisada oma jooksu pikkusi ja aegu.





<?php require_once("../footer.php"); ?>