<?php
 	
 	// table.php
	require_once("1functions.php");
	
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deleteKULUTUS($_GET["delete"]);
	}
	
	$kuulutus = getKULUTUS();
 
 ?> 
 
<table border=1 >
	<tr>
		<th>id</th>
		<th>name</th>
		<th>secondname</th>
		<th>age</th>
		<th>eriala</th>
		<th>X</th
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($kuulutus); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			echo "<tr>";
			
			echo "<td>".$kuulutus[$i]->id."</td>";
			echo "<td>".$kuulutus[$i]->name."</td>";
			echo "<td>".$kuulutus[$i]->secondname."</td>";
			echo "<td>".$kuulutus[$i]->age."</td>";
			echo "<td>".$kuulutus[$i]->eriala."</td>";
			echo "<td><a href='?delete=".$kuulutus[$i]->id."'>X</a></td>";
			echo "</tr>";
		}
	
	?>

</table>