
<?php

	$page_title = "Andmete leht";
	$file_name = "data.php";
	
?>

<?php require_once("menu.php")?>

<?php
	
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";
	
	//Laeme funktsiooni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
		
	}
	
	//Login välja kui aadressi real on ?logout=1
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}

	$tournament = $team_one = $team_two = $time = $tournament_error = $team_one_error = $team_two_error = $time_error = "";
	
	if(isset($_POST["create"])){

			if ( empty($_POST["tournament"]) ) {
				$tournament_error = "See väli on kohustuslik";
			}else{
				$tournament = cleanInput($_POST["tournament"]);
			}

			if ( empty($_POST["team_one"]) ) {
				$team_one_error = "See väli on kohustuslik";
			} else {
				$team_one = cleanInput($_POST["team_one"]);
			}
			
			if ( empty($_POST["team_two"]) ) {
				$team_two_error = "See väli on kohustuslik";
			} else {
				$team_two = cleanInput($_POST["team_two"]);
			}
			
			if ( empty($_POST["time"]) ) {
				$time_error = "See väli on kohustuslik";
			} else {
				$time = cleanInput($_POST["time"]);
			}
			
			if($team_one_error == "" && $tournament_error == "" && $team_two_error == "" && $time_error == ""){
				echo "Turniiri nimi on ".$tournament." Turniiris osalevad tiimid ".$team_one." ja ".$team_two. ". Turniir toimub: ".$time;
				
				$msg = createTournament($tournament, $team_one, $team_two, $time);
				
				if($msg != ""){
					$tournament = "";
					$team_one = "";
					$team_two = ""; //vaata üle time ja muu see asi
					$time = "";
					
					echo $msg;
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
 
 <p>
	Tere, <?=$_SESSION["user_email"]; ?>
	<a href="?logout=1"> Logi välja </a>
</p>

<h2>Lisa turniir</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="tournament" >Turniiri nimi</label><br>
	<input id="tournament" name="tournament" type="text" value="<?=$tournament; ?>"> <?=$tournament_error; ?><br><br>
  	<label for="team_one" >Esimene tiim</label><br>
	<input id="team_one" name="team_one" type="text" value="<?=$team_one; ?>"> <?=$team_one_error; ?><br><br>
	<label for="team_two" >Teine tiim</label><br>
	<input id="team_two" name="team_two" type="text" value="<?=$team_two; ?>"> <?=$team_two_error; ?><br><br>
	<label for="time" >Turniiri toimumisaeg</label><br>
	<input id="time" name="time" type="text" placeholder="YYYY-DD-MM HH-MM-SS" value="<?=$time; ?>"> <?=$time_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>