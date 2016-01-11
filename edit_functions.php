<?php
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";
	
	function getSingleTournamentData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("SELECT tournament, team_one, team_two, time FROM tournaments WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($tournament, $team_one, $team_two, $time);
		$stmt->execute();
		
		$tourney = new Stdclass();
		
		if($stmt->fetch()){
			//saan siin alles kasutada bind_result muutujaid
			$tourney->tounrament = $tournament;
			$tourney->team_one = $team_one;
			$tourney->team_one = $team_two;
			$tourney->time = $time;
			
			
			
		}else{
			header("Location: table.php");
		}
		
		return $tourney;
		
		$stmt->close();
		$mysqli->close();
	
	}
	
	
	
	function updateTournament($id, $tournament, $team_one, $team_two){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE tournaments SET tournament=?, team_one=?, team_two=?, time=? WHERE id=?");
		$stmt->bind_param("ssssi",$tournament, $team_one, $team_two, $time, $id );
		
		
		if($stmt->execute()){
			echo "jee";
			
		}
		
		
		$stmt->close();
		$mysqli->close();
	}
?>