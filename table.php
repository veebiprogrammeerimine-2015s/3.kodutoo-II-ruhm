<?php
	
	require_once("functions.php");
	
	if(isset($_GET["delete"])){
		
		deleteTournament($_GET["delete"]);
		
	}
	
	
	$tournament_list = getTournamentData();


?>

<table border=1 >
	<tr>
		<th>id</th>
		<th>Kasutaja id</th>
		<th>Turniiri nimi</th>
		<th>Esimene tiim</th>
		<th>Teine tiim</th>
		<th>Toimumise aeg</th>
		<th>X</th>
		<th>edit</th>
	</tr>
	
	<?php
	
		for($i = 0; $i < count($tournament_list); $i++){
			
			if(isset($_GET["edit"]) && $tournament_list[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<td>".$tournament_list[$i]->id."</td>";
				echo "<td>".$tournament_list[$i]->user_id."</td>";
				echo "<td><input name='tournament' value='".$tournament_list[$i]->tournament."'></td>";
				echo "<td><input name='team_one' value='".$tournament_list[$i]->team_one."'></td>";
				echo "<td><input name='team_two' value='".$tournament_list[$i]->team_two."'></td>";
				echo "<td><input name='time' value='".$tournament_list[$i]->time."'></td>";
				echo "<td><input type='submit' name='update'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
			
				echo "<tr>";
				
				echo "<td>".$tournament_list[$i]->id."</td>";
				echo "<td>".$tournament_list[$i]->user_id."</td>";
				echo "<td>".$tournament_list[$i]->tournament."</td>";
				echo "<td>".$tournament_list[$i]->team_one."</td>";
				echo "<td>".$tournament_list[$i]->team_two."</td>";
				echo "<td>".$tournament_list[$i]->time."</td>";
				echo "<td><a href='?delete=".$tournament_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$tournament_list[$i]->id."'>edit</a></td>";
				
				echo "</tr>";
			}
		}
	
	?>

</table>