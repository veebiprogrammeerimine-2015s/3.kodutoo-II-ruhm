<?php
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


//mängu kustutamiseks	
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteGame($_GET["delete"]);
	}
	
// detailsemalt vaatamiseks
	
	
	
	$game_history = getGameHistory();
	
	

	


	
?>

<p>
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Minu mängitud mängud</h1>

<table border=1 >
<tr>
	<th>Kuupäev</th>
	<th>Mängu nimi</th>
</tr>

<?php
	
	for($i = 0; $i < count($game_history); $i++){
		
		echo "<tr>";
			echo "<td>".$game_history[$i]->date."</td>";
			echo "<td>".$game_history[$i]->game_name."</td>";
			echo "<td><a href='?delete=".$game_history[$i]->id."'>kustuta</a></td>";
			echo "<td><a href='?details=".$game_history[$i]->id."'>vaata lähemalt</a></td>";
		echo "</tr>";
		
	}
	
	?>
</table>

<a href="data.php"> Avalehele</a>

