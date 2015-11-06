<?php
//table.php
	require_once("function.php");
	//kas kasutaja tahab kustutada
	//kas aadressireal on ?delete=???
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteResult($_GET["delete"]);
		
		
	}
	$result_list = getResultData();
	//var_dump($array);
?>
<table border=1 >
<tr>
	<th>id</th>
	<th>kasutaja id</th>
	<th>color</th>
	<th>Nr. märk</th>
	<th>Kuupäev</th>
	<th>Auto mark</th>
</tr>

	<?php
		
		
		for($i = 0; $i < count($result_list); $i++){
			
			//kui on see rida, mida kasutaja tahab muuta, siis kuvan input v'ljad
		if(isset($_GET["edit"]) && $result_list[$i]->id == $_GET["edit"]){
			
			echo "<tr>";
			echo "<form>";
			echo "<td><input name='kuupäev' value='".$result_list[$i]->kuupäev."'></td>";
			echo "<td><input name='mark' value='".$result_list[$i]->mark."'></td>";
			echo "<td>".$result_list[$i]->id."</td>";
			echo "<td><input name='color' value='".$result_list[$i]->color."'></td>";
			echo "<td>".$results_list[$i]->user_id."</td>";
			echo "<td><input name='nr. märk' value='".$result_list[$i]->nr. märk."'></td>";
			echo "<td><input type='submit' name='update'></td>";
			echo "<td><a href='table.php'>cancel</a></td>";			
						
			
			echo "</form>";
			echo "</tr>";
			
		}else{
			
			echo "<tr>";
			
			
			echo "<td>".$result_list[$i]->id."</td>";
			echo "<td>".$result_list[$i]->kuupäev."</td>";
			echo "<td>".$result_list[$i]->mark."</td>";
			echo "<td>".$result_list[$i]->user_id."</td>";
			echo "<td>".$result_list[$i]->color."</td>";
			echo "<td>".$result_list[$i]->nr. märk_from_db."</td>";
			echo "<td><a href='?delete=".$result_list[$i]->id."'>X</a></td>";
			echo "<td><a href='?edit=".$result_list[$i]->id."'>edit</a></td>";
			
			echo "</tr>";}
			
			
			$stmt->close();
		$mysqli->close();
		
		return $array;
		
		
	
		
		}
		?>


</table>