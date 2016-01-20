<?php
//Siia tuleb discgolfitabelid
//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}
	
	$date = $track = $time = $distance = $time_error  = $distance_error =  $date_error =  $track_error = "";
	
	if(isset($_POST["create"])){
			if ( empty($_POST["aeg"]) ) {
				$time_error = "See väli on kohustuslik";
			}else{
				$time = cleanInput($_POST["aeg"]);
			}
			if ( empty($_POST["kuupaev"]) ) {
				$date_error = "See väli on kohustuslik";
			}else{
				$date = cleanInput($_POST["kuupaev"]);
			}
			if ( empty($_POST["rada"]) ) {
				$track_error = "See väli on kohustuslik";
			}else{
				$track = cleanInput($_POST["rada"]);
			}
			if ( empty($_POST["pikkus"]) ) {
				$distance_error = "See väli on kohustuslik";
			} else {
				$distance = cleanInput($_POST["pikkus"]);
			}
	if(	$time_error == "" && $distance_error == ""&& $track_error == ""&& $date_error == ""){
		// functions.php failis käivina funktsiooni
				//msg on message
				$msg = createResult ($time, $distance,$date,$track);
				
				if($msg != ""){
					//salvestamine õnnestus
					//teen tühjaks input väljad
					$time	= "";
					$distance = "";
					$track = "";
					$date="";
					echo $msg;
					
				}
			}
	}	// create if end
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Jooksu klubi</h1><br>
<h2>Tulemuse lisamine</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="aeg" >Jooksu aeg</label> <input id="aeg" name="aeg" type="text" value="<?=$time; ?>">Min  <?=$time_error; ?>
  	<label>Jooksu pikkus</label><input name="pikkus" type="text" value="<?=$distance; ?>">Km<?=$distance_error; ?><br><br>
	<label>Kuupäev</label>	<input name="kuupaev" type="text" value="<?=$date; ?>"> <?=$date_error; ?>
	<label>Rada</label>	<input name="rada" type="text" value="<?=$track; ?>"> <?=$track_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>
 <br><br>
 <h3>Eelnevad jooksud:</h3>
 <table border=1 >
<tr>
	<th>id</th>
	<th>kasutaja id</th>
	<th>Jooksu pikkus</th>
	<th>Jooksu aeg(H)</th>
	<th>Rada</th>
	<th>Kuupäev</th>
</tr>
 <?php
 $result_list = getResults();
 ?>
 
<?php
	
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($result_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			if(isset($_GET["edit"]) && $result_list[$i]->id == $_GET["edit"]){
				// kasutajale muutmiseks
				echo "<tr>";
					echo "<form action='table.php' method='post'>";
						echo "<td>".$result_list[$i]->id."</td>";
						echo "<td>".$result_list[$i]->user_id."</td>";
						echo "<td><input name='time' value='".$result_list[$i]->time."'></td>";
						echo "<td><input name='distance' value='".$result_list[$i]->distance_from_db."'></td>";
						echo "<td><input name='track' value='".$result_list[$i]->track_from_db."'></td>";
						echo "<td><input name='date' value='".$result_list[$i]->date."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
				
			}else{
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$result_list[$i]->id."</td>";
				echo "<td>".$result_list[$i]->user_id."</td>";
				echo "<td>".$result_list[$i]->time."</td>";
				echo "<td>".$result_list[$i]->distance_from_db."</td>";
				echo "<td>".$result_list[$i]->track_from_db."</td>";
				echo "<td>".$result_list[$i]->date."</td>";
				echo "<td><a href='?delete=".$result_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$result_list[$i]->id."'>edit</a></td>";
			
				echo "</tr>";
			}
			
			
		}
	
	?>

