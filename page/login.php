<?php
	require_once("../../../config.php");
	$database = "if15_koidkan";
	$mysqli = new mysqli($servername, $username, $password, $database);


	// errorite muutujad
	$email_error = "";
	$password_error = "";
	$create_first_name_error = "";
	$create_last_name_error = "";
	$create_email_error = "";
	$create_password_error = "";

	// väärtuste muutujad
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_first_name = "";
	$create_last_name = "";
	
	
	// kontrollin, kas keegi vajutas nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// kontrollin mis nuppu vajutat
		if(isset($_POST["login"])){
				
		
			// kas e-post on tühi
			if(empty($_POST["email"])) {
			
			// jah oli tühi
				$email_error = "See väli on kohustuslik";
			}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
						
			if(empty($_POST["password"])) {
				
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}	
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$password_hash = hash("sha512", $password);
				
				$stmt=$mysqli->prepare("SELECT id, email FROM user WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $password_hash);
				
				// paneme vastuse muutujatesse
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				if($stmt->fetch()){
					echo "kasutaja id=".$id_from_db;
				} else{
					echo"Wrong password or email!";
				}			
				$stmt->close();			
				
			}
		}
		
				
	// Kasutaja loomine
	if(isset($_POST["create"])){
		
			if(empty($_POST["create_first_name"])) {
			
				$create_first_name_error ="See väli on kohustuslik";
			}else{
				$create_first_name = cleanInput($_POST["create_first_name"]);
				
			}
			
			
			if(empty($_POST["create_last_name"])) {
			
				$create_last_name_error ="See väli on kohustuslik";
			}else{
				$create_last_name = cleanInput($_POST["create_last_name"]);
				
			}
			
						
			if(empty($_POST["create_email"])) {
			
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
						
			}
						
						
			
			if(empty($_POST["create_password"])) {
			
				$create_password_error = "See väli on kohustuslik";
			}else{
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				
				}
			}
			
			
												
			
			if(	$create_email_error == "" && $create_password_error == "" && $create_last_name_error == "" && $create_first_name_error == ""){
				echo "Võib kasutajat luua! Teie nimi on ".$create_first_name." ,kasutajanimi on ".$create_email." ja parool on ".$create_password;
				
				$password_hash = hash("sha512", $create_password);
				echo "<br>";
				echo $password_hash;
				
				$stmt = $mysqli->prepare("INSERT INTO user (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
				
				echo $mysqli->error;
				
		
				$stmt->bind_param("ssss", $create_first_name, $create_last_name, $create_email, $password_hash);
				$stmt->execute();
				echo $stmt->error;
				$stmt->close();

			}
		
	}
		}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data); //võtab ära tühjad enterid, tühikud ja tab´is
  	$data = stripslashes($data); // võtab ära vastupidised kaldkriipsud ehk \
  	$data = htmlspecialchars($data); // muudab tekstiks
  	return $data;
  }
  
  // paneme ühenduse kinni
  $mysqli->close();	

?>
<?php
	$page_title = "Login leht";
	$file_name = "login.php";
?>
<?php require_once("../header.php");?>	
	
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>	
		
	<h2>Login</h2>
		<form action="login.php" method="post">
		<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error ?> <br><br>
		<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error ?> <br><br>
		<input name ="login" type="submit" value="Logi sisse"> <br><br>
	</form>
	<h2>Create user</h2>
	<form action="login.php" method="post">
		<input name="create_first_name" type="text" placeholder="Eesnimi" value="<?php echo $create_first_name; ?>"> <?php echo $create_first_name_error ?> <br><br>
		<input name="create_last_name" type="text" placeholder="Perekonnanimi"value="<?php echo $create_last_name; ?>"> <?php echo $create_last_name_error ?> <br><br>
		<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>" > <?php echo $create_email_error ?> <br><br>
		<input name="create_password" type="password" placeholder="Parool" value="<?php echo $create_password; ?>"> <?php echo $create_password_error ?> <br><br>
		<input type="submit" name ="create" value="Loo konto"> <br><br>
	</form>
<?php 
require_once("../footer.php"); 
?>