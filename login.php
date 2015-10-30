<?php
	
	//ma tahaksin tegeleda kunstitarbete e-poega, kus on registreerimissüsteem, 
	//tarbete nimikiri, iga tarbete kirjeldus, on võimalik tarbed tellida, ja tellimise vorm
	
	// ühenduse loomiseks kasuta
 	require_once("../config.php");
 	$database = "if15_tanjak";
 	$mysqli = new mysqli($servername, $username, $password, $database);
	
	//Defineerime muutujad vigased
	$email_error = "";
	$password_error = "";
	$createuserlogin_error = "";
	$createuseremail_error = "";
	$createuserpassword_error = "";
	$createuseradress_error = "";
	$createusertelephone_error = "";
	//Defineerime muutujad õiged
	$email = "";
	$password = "";
	$createuserlogin = "";
	$createuseremail = "";
	$createuserpassword = "";
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
				
				$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $password_hash);
				
				//paneme vastuse muutujatesse
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				//küsima kas AB'ist saime kätte
				if($stmt->fetch()){
					//leidis
					echo "kasutaja id=".$id_from_db;
				}else{
					// tühi, ei leidnud , ju siis midagi valesti
					echo "Wrong password or email!";
					
				}
				
				$stmt->close();
			}	
	}//login if end
	
	
		//*************
		//LOO KASUTAJA*
		//*************
		//kas kasutajanime loomine on tühi
	if(isset($_POST["create"])){
		
		if(empty($_POST["createuserlogin"])){
			$createuserlogin_error = "See väli on kohustuslik";
		}else {
				$createuserlogin = CleanInput($_POST["createuserlogin"]);
			}
			
			if($createuserlogin_error == ""){
				
				echo "salvestan ab'i ".$login;
				
 			}
	
		//kas emaili loomine on tühi
		if(empty($_POST["createuseremail"])){
			$createuseremail_error = "See väli on kohustuslik";
		}else{
				$createuseremail = CleanInput($_POST["createuseremail"]);
		}
	
		
		//kas parooli loomine on tühi
		if(empty($_POST["createuserpassword"])){
			$createuserpassword_error = "See väli on kohustuslik";
		}else {
 				if(strlen($_POST["createuserpassword"]) < 8) {
 					$createuserpassword_error = "Peab olema vähemalt 8 tähemärki pikk!";
 				}else{
 					$createuserpassword = cleanInput($_POST["createuserpassword"]);
 				}
	
		
		//kas aadressi loomine on tühi
		if(empty($_POST["createuseradress"])){
			$createuseradress_error = "See väli on kohustuslik";
		}else {
				$createuseradress = CleanInput($_POST["createuseradress"]);
		}
		}
		if(empty($_POST["createusertelephone"])){
			$createusertelephone_error = "See väli on kohustuslik";
		}else {
				$createusertelephone = CleanInput($_POST["createusertelephone"]);
	}
		}
		if(	$createuserlogin_error = "" && $createuseremail_error == "" && $createuserpassword_error == "" &&$createuseradress_error == "" && $createusertelephone_error = ""){
 				echo "Võib kasutajat luua! Kasutajanimi on ".$createuseremail." ja parool on ".$createuserpassword;
				$password_hash = hash("sha512", $createuserpassword);
 				echo "<br>";
 				echo $password_hash;
 				
 				$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
 				
 				//echo $mysqli->error;
 				//echo $stmt->error;
 				//asendame ? märgid muutujate väärtuste
 				// ss - s tähendab string iga muutuja kohta
 				$stmt->bind_param("ss", $create_email, $password_hash);
 				$stmt->execute();
 				$stmt->close();
		}//create if end
		
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
	}	
	// paneme ühenduse kinni
   $mysqli->close();
	}
?>
<?php
	$page_title = "Login leht";
	$file_name = "login.php";
?>
<?php require_once("header.php"); ?>
	<h2>Login</h2>
	<form action="login.php" method="post">
		<input name="email" type="email" placeholder="E-post"> <?php echo $email_error; ?><br><br>
		<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?><br><br>
		<input type="submit" value="Logi sisse"><br><br>
	
	<h2>Create User</h2>
	<form action="login.php" method="post">
		<input name="create_login" type="text" placeholder="Kasutaja nimi"> <?php echo $createuserlogin_error; ?><br><br>
		<input name="create_email" type="email" placeholder="E-post" value="<?php echo $createuseremail; ?>"> <?php echo $createuseremail_error; ?><br><br>
		<input name="create_password" type="password" placeholder="Parool"> <?php echo $createuserpassword_error; ?><br><br>
		<input name="create_adress" type="text" placeholder="Aadress"> <?php echo $createuseradress_error; ?><br><br>
		<input name="create_telephone" type="telephone" placeholder="Telefon"> <?php echo $createusertelephone_error; ?><br><br>
		<input type="submit" value="Registreeri"><br><br>
<?php require_once("footer.php"); ?>