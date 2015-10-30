<?php




	//table php
	require_once("1functions.php");
	require_once("edit_function.php");
	
	
	//kasutaja tahab midagi muuta 
	if(isset($_POST["uptade"])){
		
		updateKUL($_POST["id"], $_POST["kuulutus_name"], $_POST["nimi"]);
		
		
	}

	//kas kasutaja tahab kustuda
	//kas aadressireal on ?delete=???!???!!?
	
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustuda
		deleteCar($_GET["delete"]);
		
	}
	
	
	$kuulutus_list = getKULdata();
	//var_dump($car_list);


?>
<table border=1 >
	<tr>

		<th>id</th>
		<th>user id</th>
		<th>kulutus nimi</th>
		<th>nimi</th>
		<th>X</th>

	</tr>

	<?php
	
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($car_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			if(isset($_GET["edit"]) && $car_list[$i]->id == $_GET["edit"]){
				// kasutajale muutmiseks
				echo "<tr>";
					echo "<form action='table.php' method='post'>";
						echo "<td>".$car_list[$i]->id."</td>";
						echo "<td>".$car_list[$i]->user_id."</td>";
						echo "<input type='hidden' name ='id' value='".$car_list[$i]->id."'>";
						echo "<td><input name='number_plate' value='".$car_list[$i]->number_plate."'></td>";
						echo "<td><input name='color' value='".$car_list[$i]->color."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
				
			}else{
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$car_list[$i]->id."</td>";
				echo "<td>".$car_list[$i]->user_id."</td>";
				echo "<td>".$car_list[$i]->number_plate."</td>";
				echo "<td>".$car_list[$i]->color."</td>";
				echo "<td><a href='?delete=".$car_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$car_list[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit=".$car_list[$i]->id."'>edit.php</a></td>";
			
				echo "</tr>";
			}
			
			
		}
	
			
		
	?>	
		
		
</table>
