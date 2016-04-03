<?php
	

	require_once("functions2.php");
	//require_once("edit_functions.php");
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	
	
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deleteToit($_GET["delete"]);
		
	}
	
	
	
	$toit_list = getToitData();
	//var_dump($toit_list);

?>
<table border=1 >
	<tr>
		<th>id</th>
		<th>Nimi</th>
		<th>Hind</th>
		<th>Kustuta</th>
		<th>Muuta</th>
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($toit_list) - massiivi pikkus
		for($i = 0; $i < count($toit_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			if(isset($_GET["edit"]) && $toit_list[$i]->id == $_GET["edit"]){
				// kasutajale muutmiseks
				echo "<tr>";
					echo "<form action='table.php' method='post'>";
						echo "<td>".$toit_list[$i]->id."</td>";
						//echo "<td>".$toit_list[$i]->user_id."</td>";
						echo "<td><input name='nimi' value='".$toit_list[$i]->nimi."'></td>";
						echo "<td><input name='hind' value='".$toit_list[$i]->hind."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
				
			}else{
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$toit_list[$i]->id."</td>";
				//echo "<td>".$toit_list[$i]->user_id."</td>";
				echo "<td>".$toit_list[$i]->nimi."</td>";
				echo "<td>".$toit_list[$i]->hind."</td>";
				echo "<td><a href='?delete=".$toit_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$toit_list[$i]->id."'>edit</a></td>";
			
				echo "</tr>";
			}
			
			
		}
	
	?>

</table>
