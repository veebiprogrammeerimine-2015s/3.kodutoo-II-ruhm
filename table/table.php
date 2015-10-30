<?php
 	
 	// table.php
	require_once("1functions.php");
	
	$kuulutus = getKULUTUS();
 
 ?> 
 
<table border=1 >
	<tr>
		<th>id</th>
		<th>name</th>
		<th>secondname</th>
		<th>age</th>
		<th>eriala</th>
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
			
			echo "</tr>";
		}
	
	?>

</table>