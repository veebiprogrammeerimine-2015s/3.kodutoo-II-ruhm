<?php

	//laeme funktsiooni failis
	require_once("functions.php");
	require_once("header.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: data.php");
	}
	
  // muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";

  // muutujad v��rtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {

    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){

			if ( empty($_POST["email"]) ) {
				$email_error = "See v�li on kohustuslik";
			}else{
        // puhastame muutuja v�imalikest �leliigsetest s�mbolitest
				$email = cleanInput($_POST["email"]);
			}

			if ( empty($_POST["password"]) ) {
				$password_error = "See v�li on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}

      // Kui oleme siia j�udnud, v�ime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				echo "V�ib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				// User klassi sees olev funktsioon
				$login_response = $User->loginUser($email, $password);
				
				//kasutaja on sisse logitud
				if(isset($login_response->success)){
					
					//echo "<pre>";
					//var_dump($login_response);
					//echo "</pre>";
					// l�ks edukalt, n��d peaks kasutaja sessiooni salvestama
					$_SESSION["id_from_db"] = $login_response->success->user->id;
					$_SESSION["user_email"] = $login_response->success->user->email;
					
					header("Location: data.php");
					
					//******************************
					//********* OLULINE ************
					//******************************
					
					// l�petame PHP laadimise
					exit();
					
					
				}
				

			}

		} // login if end

    // *********************
    // ** LOO KASUTAJA *****
    // *********************
    if(isset($_POST["create"])){

			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See v�li on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}

			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See v�li on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema v�hemalt 8 t�hem�rki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}

			if(	$create_email_error == "" && $create_password_error == ""){
				echo "V�ib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
				
				// User klassi sees olev funktsioon
				$create_response = $User->createUser($create_email, $create_password);
				
			}

    } // create if end

	}

  // funktsioon, mis eemaldab k�ikv�imaliku �leliigse tekstist
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
  
  
<h1>Kuulutusleht</h1>
<p>Enne saada ja vaatama kuulutused, palun logi sisse voi registreeri kasutaja!</p>

</head>
<body>

<!DOCTYPE html>
  <h2>Log in</h2>
  
  <?php if(isset($login_response->error)): ?>
  
	<p style="color:red;">
		<?=$login_response->error->message;?>
	</p>
  
  <?php elseif(isset($login_response->success)): ?>
  
	<p style="color:green;">
		<?=$login_response->success->message;?>
	</p>
  
  <?php endif; ?>  
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
  </form>

  <h2>Create user</h2>
  
  <?php if(isset($create_response->error)): ?>
  
	<p style="color:red;">
		<?=$create_response->error->message;?>
	</p>
  
  <?php elseif(isset($create_response->success)): ?>
  
	<p style="color:green;">
		<?=$create_response->success->message;?>
	</p>
  
  <?php endif; ?>  
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>
