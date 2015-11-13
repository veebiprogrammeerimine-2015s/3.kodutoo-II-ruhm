
<?php
// ühenduse loomiseks kasuta
	require_once("../../configglobal.php");
	$database = "if15_taunlai_";
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	

//echo $_POST["email"];

//defineerime muutujad
$first_name_error="";
$last_name_error="";
$user_name_error="";
$password_error="";
$email_error="";
//muutujad väärtuste jaoks
$first_name="";
$last_name="";
$user_name="";
$password ="";
$email="";
// kontrollin kas keegi vajutas nuppu
if($_SERVER["REQUEST_METHOD"] == "POST") {
//kontrollin kas keegi vajutas nuppu
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
				$email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if( empty($_POST["create_password"])) {
				//jah oli tyhi
				$password_error = "See väli on kohustuslik";
			}else {
				if(strlen($_POST["create_password"]) < 8) {
					$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$email_error == "" && $password_error == "" && $first_name_error == "" && $last_name_error == ""){
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
			$password_hash = hash("sha512", $create_password);
				echo "<br>";
				echo $password_hash;
			$stmt = $mysqli->prepare("INSERT INTO user (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
				echo $mysqli->error;
				echo $stmt->error;
				
			//asendame kysimärgid muutujate väärtustega
				$stmt->bind_param("ssss", $first_name, $last_name, $create_email, $password_hash);
				$stmt->execute();
				$stmt->close();
			}
		} // create if end
	
	
  
}
function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
	
}
  //paneme ühenduse kinni
  $mysqli->close();
?>

<?php
	$page_title = "Konto loomine";
	$file_name = "";
?>
<?php require_once("../header.php"); ?>
	 
	
	<h2> Konto loomine</h2>
	<form action="leht2.php" method="post" >
	<input name="first_name" type="text" placeholder="Eesnimi"><?php echo $first_name_error ?> <br><br>
	<input name="last_name" type="text" placeholder="Perekonnanimi"><?php echo $last_name_error ?> <br><br>
	<input name="create_email" type="email" placeholder="E-post"><?php echo $email_error ?> <br><br>
	<input name="create_password" type="password" placeholder="Parool"><?php echo $password_error ?> <br><br>
	
	<input name="create" type="submit" value="Registreeri">
	</form>
	<br><br>
	
	
	
<?php require_once("../footer.php"); ?>

