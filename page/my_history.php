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


// Rääma mängu kustutamiseks	
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteGame($_GET["delete"]);
	}
	
// Jõekääru mängu kustutamiseks
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteGameJoekaaru($_GET["delete"]);
	}
	
// Rääma pargis mängitud mängude muutmine
	if(isset($_POST["edit"])){
		
		editGame($_POST["id"], $_POST["game_name"], $_POST["comment"]);
	}
	
// Jõekääru pargis mängitud mängude muutmine
	if(isset($_POST["edit"])){
		
		editGameJoekaaru($_POST["id"], $_POST["game_name"], $_POST["comment"]);
	}
	
	
	
	$game_history = getGameHistory();
	
	$game_history_joekaaru = getGameHistoryJoekaaru();
	
	

	


	
?>

<p>
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Minu mängitud mängud Rääma Pargis</h1>

<table border=1 >
<tr>
	<th>Id</th>
	<th>Kuupäev</th>
	<th>Mängu nimi</th>
	<th>Kommentaar</th>
</tr>

<?php
	for($i = 0; $i < count($game_history); $i++){
		
		if(isset($_GET["edit"]) && $game_history[$i]->game_name == $_GET["edit"]){
			
			echo "<tr>";
			echo "<form action=my_history.php method='post'>";
				
				echo "<td><input type='hidden' name='id' value='".$game_history[$i]->id."'</td>";
				echo "<td>".$game_history[$i]->date."</td>";
				echo "<td><input name='game_name' value='".$game_history[$i]->game_name."'</td>";
				echo "<td><input name ='comment' value='".$game_history[$i]->comment."'</td>";
				echo "<td><a href='my_history.php'>cancel</a></td>";
				echo "<td><input type='submit' name='edit' value='muuda' ></td>";
			echo "</tr>";
		
		}else{
			echo "<tr>";
				echo "<td>".$game_history[$i]->id."</td>";
				echo "<td>".$game_history[$i]->date."</td>";
				echo "<td>".$game_history[$i]->game_name."</td>";
				echo "<td>".$game_history[$i]->comment."</td>";
				echo "<td><a href='?delete=".$game_history[$i]->id."'>kustuta</a></td>";
				echo "<td><a href='?edit=".$game_history[$i]->game_name."'><input type='submit' name='edit' value='muuda'></a></td>";
			echo "</tr>";
		}
		
	}
	
	?>
</table>

<h1>Minu mängitud mängud Jõekääru Pargis</h1>

<table border=1 >
<tr>
	<th>Id</th>
	<th>Kuupäev</th>
	<th>Mängu nimi</th>
	<th>Kommentaar</th>
</tr>

<?php
	
	for($i = 0; $i < count($game_history_joekaaru); $i++){
		
		if(isset($_GET["edit"]) && $game_history_joekaaru[$i]->game_name == $_GET["edit"]){
			
			echo "<tr>";
			echo "<form action=my_history.php method='post'>";
				
				echo "<td><input type='hidden' name='id' value='".$game_history_joekaaru[$i]->id."'</td>";
				echo "<td>".$game_history_joekaaru[$i]->date."</td>";
				echo "<td><input name='game_name' value='".$game_history_joekaaru[$i]->game_name."'</td>";
				echo "<td><input name='comment' value='".$game_history_joekaaru[$i]->comment."'</td>";
				echo "<td><a href='my_history.php'>cancel</a></td>";
				echo "<td><input type='submit' name='edit' value='muuda' ></td>";
			echo "</tr>";
		
		}else{
			echo "<tr>";
				echo "<td>".$game_history_joekaaru[$i]->id."</td>";
				echo "<td>".$game_history_joekaaru[$i]->date."</td>";
				echo "<td>".$game_history_joekaaru[$i]->game_name."</td>";
				echo "<td>".$game_history_joekaaru[$i]->comment."</td>";
				echo "<td><a href='?delete=".$game_history_joekaaru[$i]->id."'>kustuta</a></td>";
				echo "<td><a href='?edit=".$game_history_joekaaru[$i]->game_name."'><input type='submit' name='edit' value='muuda'></a></td>";
			echo "</tr>";
		}
		
	}
	
	?>
</table>

<a href="data.php"> Avalehele</a>

