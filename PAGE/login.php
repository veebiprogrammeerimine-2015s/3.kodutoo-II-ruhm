<?php

	//laeme functions faili
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisse loginud
	if(isset($_SESSION["id_from_db"])){
		//suuname data lehele kui on sisseloginud
		header("Location: data.php");
	}
	
	//errorid
	$email_error = "";
	$password_error = "";
	$create_emailerror = "";
	$create_passworderror = "";
	$create_passwordAerror = "";
	$create_usererror = "";
	
	//väärtused
	$email = "";
	$password = "";
	$Cpassword = "";
	$Cusername = "";
	$Cemail = "";
	
	//kontrollin kas keegi vajutas nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["Login"])){
			//kas e-post on tühi
			if(empty($_POST["email"])){
				//jah oli tühi
				$email_error = "E-mail is required";
			}else{
				$email = test_input($_POST["email"]);
			}
			//kas password on tühi
			if(empty($_POST["password"])){
				//jah oli tühi
				$password_error = "Password is required";
			}else{
				$password = test_input($_POST["password"]);
			}
			if($password_error == "" && $email_error == ""){
				echo "parool on ".$password;
				$password_hash = hash("sha512", $password);
				loginUser($email, $password_hash);
			}
		}
		if(isset($_POST["Create"])){
			//kas create email on tühi
			if(empty($_POST["Cemail"])){
				//jah oli tühi
				$create_emailerror = "E-mail is required";
			}else{
				$Cemail = test_input($_POST["Cemail"]);
			}
			if(empty($_POST["Cusername"])){
				//username väli on tühi
				$create_usererror = "Username is required";
			}else{
				$Cusername = test_input($_POST["Cusername"]);
			}
			//kas create password on tühi
			if(empty($_POST["Cpassword"])){
				//jah oli tühi
				$create_passworderror = "Password is required";
			}else{
				//kontrollib et parool oleks rohkem kui 8 sümbolit
				if(strlen($_POST["Cpassword"]) < 8 ){
					$create_passworderror = "Must be longer than 8 symbols";
				}else{
					$Cpassword = test_input($_POST["Cpassword"]);
				}
			}
			if($_POST["Cpassword"] !== $_POST["repassword"]){
				//kui parool ei võrdu kordusparooliga lükkab errori ette
				$create_passwordAerror = "Your password does not match the password entered above";
			}
			if($create_emailerror == "" && $create_usererror == "" && $create_passworderror == "" && $create_passwordAerror == ""){
				echo "Email is ".$Cemail." Username is ".$Cusername." and password is ".$Cpassword;
				
				$password_hash = hash("sha512", $Cpassword);
				echo "<br>";
				echo $password_hash;
				createUser($Cemail, $password_hash, $Cusername);
			}

			
		}
	}
	// funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
	function test_input($data) {
		$data = trim($data);                // võtab tühikud, tabid ja enterid ära
		$data = stripslashes($data);        // võtab \\ ära
		$data = htmlspecialchars($data);    // muudab asjad tekstiks
		return $data;	
	}
?>

<?php
$page_title = "Login";
$file_name = "login.php";
?>	

<?php require_once("../header.php");?>


	<h3>Mõtlesin siis teha lehe kuhu inimesed saavad teha postitusi erinevate teemade alla ja teised saavad siis kommenteerida, põhimõtteliselt väga lihtsustatud reddit</h3>
	<h2>Login</h2>
	<p>* required field.</p>
	<form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<input name="email" type="email" placeholder="E-mail" value="<?php echo $email ?>"> * <?=$email_error?><br><br>
	<input name="password" type="password" placeholder="password"> * <?=$password_error?><br><br>
	<input name="Login" type="submit" value="Login"> <br><br>
	</form>

	<h2>Create user</h2>
	<p>* required field.</p>
	<form action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<input name="Cusername" type="text" placeholder="Username" value="<?php echo $Cusername ?>"> * <?=$create_usererror?><br><br>
	<input name="Cemail" type="email" placeholder="E-mail" value="<?php echo $Cemail ?>"> * <?=$create_emailerror?><br><br>
	<input name="Cpassword" type="password" placeholder="password"> * <?=$create_passworderror?><br><br>
	<input name="repassword" type="password" placeholder="password again"> * <?=$create_passwordAerror?><br><br>
	<input name="Create" type="submit" value="Create"><br><br>
	</form>
	
<?php require_once("../footer.php");?>