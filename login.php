<?php
	require_once("../config.php");
	$database = "if15_sizen";
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	//Defineerime muutujad
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_name_error = "";
	$create_age_error = "";

	
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_age = "";
	$create_name = "";

	
	//kontrollin kas keegi vajutas nuppu
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["login"])){
		
			//echo "jah";
		
			// kas e-post on tühi
			if( empty($_POST["email"]) ) {
			
			// jah oli tühi
				$email_error = "See väli on kohustuslik";
			}else{
				//puhastame üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			
		
			// kas parool on tühi
			if( empty($_POST["password"]) ) {
			
				// jah oli tühi
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			if($password_error == "" && $email_error == ""){
				echo "võib sisse logida! User on ".$email." ja pw on ".$password;
				
				$password_hash = hash("sha512", $password);
				$stmt = $mysqli->prepare("SELECT id, email, name, age FROM users WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $password_hash);
				$stmt->bind_result($id_from_db, $email_from_db, $name_from_db, $age_from_db);

				$stmt->execute();
				
				//vaatame kas saime andmebaasist kätte
				if($stmt->fetch()){
					
					echo "  kasutaja id=".$id_from_db;
					
					echo ". Nimi on:  ".$name_from_db;
					echo ". Vanus on: ".$age_from_db;
				}else{
					echo "wrong password or email";
					//siis kui ei leidnud vastust tabelist
				}
				
				 $stmt->close();
			}
			
		}
		
		
		if(isset($_POST["create"])){
			if(empty($_POST["create_email"])){
				$create_email_error = "see väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
	
			if(empty($_POST["create_password"])){
				$create_password_error = "see väli on kohustuslik";
			}else{
				if(strlen($_POST["create_password"]) > 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
						$create_password = cleanInput($_POST["create_password"]);
					}
			
			}
			if(empty($_POST["create_name"])){
				$create_name_error = "see väli on kohustuslik";
			}else{
				$create_name = cleanInput($_POST["create_name"]);
			}
		
		
			if(empty($_POST["create_age"])){
				$create_age_error = "see väli on kohustuslik";
			}else{
				var_dump($_POST["create_age"]);
				var_dump(intval($_POST["create_age"]));
				if ((intval($_POST["create_age"])) == 0){
					$create_age_error = "Peab sisestama arvu";
						}else{
							$create_age = cleanInput($_POST["create_age"]);
						}
			}
			if($create_email_error == "" && $create_password_error == "" && $create_name_error == "" && $create_age_error == ""){
				echo "Võib kasutajat luua!. user on ".$create_email." j parool on ".$create_password;
				
				$password_hash = hash("sha512", "$create_password");
				echo "<br>";
				echo $password_hash;
				
				$stmt = $mysqli->prepare("INSERT INTO users (email, password, name, age) VALUES (?, ?, ?, ?)");
				$stmt->bind_param("sssi", $create_email, $password_hash, $create_name, $create_age);
				$stmt->execute();
				$stmt->close();
				
			}
		}
		
		
	}
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
  $mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login page</title>
</head>
<body>
	
	<h2>Login</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input name="email" type="email" placeholder="E-post" > <?php echo $email_error; ?><br><br>
		<input name="password" type="password" placeholder="Parool" > <?php echo $password_error; ?> <br><br>
		<input name="login" type="submit" value="Logi sisse" > <br><br>
	</form>
	
	
	<h2>Create user</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool" value="<?php echo $create_password; ?>"> <?php echo $create_password_error; ?> <br><br>
	<input name="create_name" type="string" placeholder="kasutajanimi" value="<?php echo $create_name; ?>"> <?php echo $create_name_error; ?> <br><br>
	<input name="create_age" type="integer" placeholder="vanus" value="<?php echo $create_age; ?>"> <?php echo $create_age_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
	</form>
	
	
	
</body>
</html>




