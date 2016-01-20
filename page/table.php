<?php
//table.php
	require_once("function.php");
	//kas kasutaja tahab kustutada
	//kas aadressireal on ?delete=???
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteResult($_GET["delete"]);
		
		
	}
	$result_list = getResults();
	//var_dump($array);
?>
<table border=1 >
<tr>
	<th>id</th>
	<th>kasutaja id</th>
	<th>Jooksu aeg</th>
	<th>Jooksu pikkus</th>
	<th>Kuupäev</th>
	<th>Rada</th>
</tr>

	<?php
		
		
		for($i = 0; $i < count($result_list); $i++){
			
			//kui on see rida, mida kasutaja tahab muuta, siis kuvan input v'ljad
		if(isset($_GET["edit"]) && $result_list[$i]->id == $_GET["edit"]){
			
			echo "<tr>";
			echo "<form>";
			echo "<td><input name='kuupäev' value='".$result_list[$i]->date."'></td>";
			echo "<td><input name='rada' value='".$result_list[$i]->track_from_db."'></td>";
			echo "<td>".$result_list[$i]->id."</td>";
			echo "<td><input name='aeg' value='".$result_list[$i]->time."'></td>";
			echo "<td>".$results_list[$i]->user_id."</td>";
			echo "<td><input name='pikkus' value='".$result_list[$i]->distance_from_db."'></td>";
			echo "<td><input type='submit' name='update'></td>";
			echo "<td><a href='table.php'>cancel</a></td>";			
						
			
			echo "</form>";
			echo "</tr>";
			
		}else{
			
			echo "<tr>";
			
			
			echo "<td>".$result_list[$i]->id."</td>";
			echo "<td>".$result_list[$i]->user_id."</td>";
			echo "<td>".$result_list[$i]->time."</td>";
			echo "<td>".$result_list[$i]->distance_from_db."</td>";
			echo "<td>".$result_list[$i]->track_from_db."</td>";
			echo "<td>".$result_list[$i]->date."</td>";
			echo "<td><a href='?delete=".$result_list[$i]->id."'>X</a></td>";
			echo "<td><a href='?edit=".$result_list[$i]->id."'>edit</a></td>";
			
			echo "</tr>";}
			
			
				$stmt->close();
				$mysqli->close();
		
		return $array;
		
		
	
		
		}
		?>


</table>