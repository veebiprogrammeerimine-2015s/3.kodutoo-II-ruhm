 <?php
 
	require_once("../../konfig_global.php");
	$database = "if13_rene_p";
	
	//paneme sessiooni k2ima, saame kasutada $_session muutujaid
	session_start();
	
	function createUser($create_email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO create_user (username, email, firstname, lastname, tel, amet, password) VALUES (?, ?, ?, ?, ?, 'Talupoeg', ?)");
				
				//asendame ? muutujate v22rtustega
				
				//echo $mysqli->error;
				//echo $stmt->error;
				
				$stmt->bind_param("ssssss",$create_username, $create_email, $create_firstname, $create_lastname, $create_tel, $password_hash);
				$stmt->execute();
				$stmt->close();
				
				$mysqli->close();
		
		
	}

	function loginUser($email, $password_hash){
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				$stmt = $mysqli->prepare("SELECT id, username, email, firstname, lastname, tel, amet FROM create_user WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $password_hash); //asnendab küsimärgid
				
				//paneme vastused muutujatesse
				
				$stmt->bind_result($id_from_db, $username_from_db, $email_from_db, $firstname_from_db, $lastname_from_db, $tel_from_db, $amet_from_db);
				$stmt->execute();

				
				if($stmt->fetch()){
					
					
					
					$_SESSION["id_from_db"] = $id_from_db;
					$_SESSION["user_email"] = $email_from_db;
					
					//suunan kasutaja
					
					header("Location: data.php");
					
				}
				else{
					//tühi, ei leidnud
					echo "Wrong password or email";
				}
				$stmt->close();
				$mysqli->close();
		
		
	}
		function addRetsept($title, $ingredients, $preparation) {
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO create_retsept (user_id, title, ingredients, preparation) VALUES (?,?,?,?)");
		$stmt->bind_param("isss", $_SESSION["id_from_db"], $title, $ingredients, $preparation);
		
		$message = "";
		if($stmt->execute()){
			
		$message = "Eduklat edastatud anbmebaasi";	
		}else{
			echo $stmt->error;
			
		}
		
		$stmt->close();
		
		$mysqli->close();
		
		return $message;
	}





		function getRetseptData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, title, ingredients, preparation  FROM create_retsept WHERE deleted IS NULL");
		$stmt->bind_result($id_from_db, $user_id_from_db, $title_from_db, $ingredients_from_db, $preparation_from_db);
		$stmt->execute();
		
		
		
		$array = array();
		
		
		while($stmt->fetch()){
		
		//loon objekti
		$retsept = new StdClass();
		$retsept->id = $id_from_db;
		$retsept->user_id = $user_id_from_db;
		$retsept->title = $title_from_db;
		$retsept->ingredients = $ingredients_from_db;
		$retsept->preparation = $preparation_from_db;
		
		array_push($array, $retsept);
		
	
		//echo "<pre>";
		//var_dump($array);
		//echo "</pre>";
		
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		return $array;
		
	}
	
	
	
	function deleteRetsept($id_to_be_deleted){
		
	
		
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE create_retsept SET deleted=NOW() WHERE id=? AND user_id=?");
		$stmt->bind_param("ii", $id_to_be_deleted, $_SESSION["id_from_db"]);
		
		if(isset($_SESSION["id_from_db"])) {
			
				
				
					if($stmt->execute()){
						// sai edukalt kustutatud
						header("Location: table.php");
					}
				
			
		}
		$stmt->close();
		$mysqli->close();
		
	}



	
 ?>