<?php
	$page_title = "Konto loomine";
	$file_name = "";
?>
<?php require_once("../header.php"); ?>
<?php
// ühenduse loomiseks kasuta
	require_once("../../config.php");
	$database = "if15_koitkor_2";
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	

//echo $_POST["email"];

//defineerime muutujad
	$create_email_error = "";
	$create_password_error = "";
	$create_fname_error = "";
	$create_lname_error = "";
	$create_age_error = "";
//muutujad väärtuste jaoks
	$create_email = "";
	$create_password = "";
	$create_fname = "";
	$create_lname = "";
	$create_age = "";
// kontrollin kas keegi vajutas nuppu
if($_SERVER["REQUEST_METHOD"] == "POST") {
//kontrollin kas keegi vajutas nuppu
if(isset($_POST["create"])){
		
			if( empty($_POST["create_fname"])) {
				//tühi
				$first_name_error = "See väli on kohustuslik";
				}else{
				$create_fname = cleanInput($_POST["create_fname"]);				
			}
			
			if( empty($_POST["create_lname"])) {
				//tühi
				$last_name_error = "See väli on kohustuslik";
				}else{
				$create_lname = cleanInput($_POST["create_lname"]);
			}
			
			if( empty($_POST["create_age"])) {
				//tühi
				$email_error = "See väli on kohustuslik";
			}else{
				$create_age = cleanInput($_POST["create_age"]);
			}
			
			if( empty($_POST["create_email"])) {
				//tühi
				$email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if( empty($_POST["create_password"])) {
				//tühi
				$password_error = "See väli on kohustuslik";
			}else {
				if(strlen($_POST["create_password"]) < 8) {
					$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$create_email_error == "" && $create_password_error == "" && $create_fname_error == "" && $create_lname_error == "" && $create_age_error == ""){
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
			$password_hash = hash("sha512", $create_password);
				echo "<br>";
				echo $password_hash;
			$stmt = $mysqli->prepare("INSERT INTO user (fname, lname, email, password, age) VALUES (?, ?, ?, ?, ?)");
				echo $mysqli->error;
				echo $stmt->error;
				
			//asendame kysimärgid muutujate väärtustega
				$stmt->bind_param("sssss", $create_fname, $create_lname, $create_email, $password_hash, $create_age);
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
  //ühenduse kinni
  $mysqli->close();
?>


	 
	
	<h2>Konto loomine</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input name="create_fname" type="text" placeholder="Eesnimi" value="<?php echo $create_fname; ?>"> <?php echo $create_fname_error; ?><br><br>
	<input name="create_lname" type="text" placeholder="Perekonnanimi" value="<?php echo $create_lname; ?>"> <?php echo $create_lname_error; ?><br><br>
	<input name="create_age" type="int" placeholder="Vanus" value="<?php echo $create_age; ?>"> <?php echo $create_age_error; ?><br><br>


	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
  	<input name="create" type="submit" value="Registreeru">
	</form>
	<br><br>
	
	
	
<?php require_once("../footer.php"); ?>

