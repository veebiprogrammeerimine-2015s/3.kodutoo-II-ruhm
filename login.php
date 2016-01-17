<?php
	$page_title = "Login leht";
	$file_name = "login.php";
	
?>
<?php require_once("menu.php")?>
<?php
	
	require_once("functions.php");
	if(isset($_SESSION["id_from_db"])){
		header("Location: data.php");	
	}
  
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_password_again_error = "";
  
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_password_again = "";
	
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["login"])){
		if ( empty($_POST["email"]) ) {
			$email_error = "This field is required";
		}else{
			$email = cleanInput($_POST["email"]);
		}
		if ( empty($_POST["password"]) ) {
			$password_error = "This field is required";
		}else{
			$password = cleanInput($_POST["password"]);
		}
		if($password_error == "" && $email_error == ""){
			echo "Success! Username is ".$email." and password is ".$password;
			$password_hash = hash("sha512", $password);
			loginUser($email, $password_hash);
		}
	} 
   if(isset($_POST["create"])){
		if ( empty($_POST["create_email"]) ) {
			$create_email_error = "This field is required";
		}else{
			$create_email = cleanInput($_POST["create_email"]);
		}
		if ( empty($_POST["create_password"]) ) {
			$create_password_error = "This field is required";
		} else {
			if(strlen($_POST["create_password"]) < 8) {
				$create_password_error = "Your password must be at least 8 characters long!";
			}else{
				$create_password = cleanInput($_POST["create_password"]);
			}
		}
		if ( empty($_POST["create_password_again"]) ) {
			$create_password_again_error = "This field is required";
		} else {
			if ($_POST["create_password"] != $_POST["create_password_again"] ) {
			$create_password_again_error = "Passwords do not match!";
			} else {	
				if(strlen($_POST["create_password_again"]) < 8) {
				$create_password_again_error = "This field is required!";
				}else{
				$create_password_again = cleanInput($_POST["create_password"]);
				}
			}
		}
		if(	$create_email_error == "" && $create_password_error == "" && $create_password_again_error == ""){
			echo "Success!";
			$password_hash = hash("sha512", $create_password);
			echo "<br>";
			createUser($create_email, $password_hash);
		}
    } 
	}
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
</head>
<body>
  <h2>Log in</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="email" type="email" placeholder="Email" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
  	<input name="password" type="password" placeholder="Password" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
  	<input type="submit" name="login" value="Log in">
	</form>

	<h2>Create user</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="Email" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Password"> <?php echo $create_password_error; ?> <br><br>
  	<input name="create_password_again" type="password" placeholder="Confirm password"> <?php echo $create_password_again_error; ?> <br><br>
	<input type="submit" name="create" value="Create user">
  </form>
</body>
</html>