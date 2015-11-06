<?php
	$page_title = "Logi sisse";
	$file_name = "";
?>
<?php require_once("../header.php"); ?>
<?php
		
	//ühenduse loomiseks kasuta
	require_once("function.php");
///$database = "if15_koitkor_2";
///$mysqli = new mysqli($servername, $server_username, $server_password, $database);

//kontrollin, kas kasutaja on sisse loginud
	if(isset($_SESSION["id_from_db"])){
		//suunan data lehele
		header("Location: data.php");
	}
	
	// muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	
	// muutujad väärtuste jaoks
	$email = "";
	$password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	//Kontrollin kas keegi vajutas login
		if(isset($_POST["login"])){

			if(empty($_POST["email"])){
			//jah oli tühi
			$email_error = "See väli on kohustuslik";
			}else{
			//puhastame muutuja üleliigsetest sümbolitest
			$email = cleanInput($_POST["email"]);
			}
			//kontrollime kas parool on tühi
			if(empty($_POST["password"])){
				$password_error = "See väli on kohustuslik";
			}else{	
			$password = cleanInput($_POST["password"]);
			}
			//võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				$password_hash = hash("sha512", $password);
				loginUser($email, $password_hash);
			}
	
		}
	}	
	
	// funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
  
	// paneme ühenduse kinni
	//$mysqli->close();
?>

<html>
<head>
	<title>Logi sisse</title>
</head>
<body>
	<h2>Logi sisse</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input name="email" type="email" placeholder="E-post"> <?php echo $email_error;?> <br> <br> 
	<input name="password" type="password" placeholder="Parool"> <?php echo $password_error;?> <br> <br> 
	<input name="login" type="submit" value="Logi sisse"> <br> <br>
	</form>
	<h2> <a href="../leht/Create user">Kasutaja loomine!<br> </a> </h2>
</body>

</html>