<?php
	
	// table.php
	require_once("funtions.php");
	
	if(isset($_GET["delete"])){
		//saadan kaasa id mida kustutada
		
		deleteRetsept($_GET["delete"]);
		
	}
	
	$retsept_list = getRetseptData();
?>

<table border=1 >
	<tr>
		<th>ID</th>
		<th>Retsepti Nimi</th>
		<th>Koostisosad</th>
		<th>Valmistamine</th>
		
	</tr>
	
	<?php
	
		for($i = 0; $i < count($retsept_list); $i++){
			echo "<tr>";
			
			echo "<td>".$retsept_list[$i]->id."</td>";
			echo "<td>".$retsept_list[$i]->title."</td>";
			echo "<td>".$retsept_list[$i]->ingredients."</td>";
			echo "<td>".$retsept_list[$i]->preparation."</td>";


				if(isset($_SESSION["id_from_db"])){
			
		
		
		
	
			
			echo "<td><a href='?delete=".$retsept_list[$i]->id."'>X</a></td>";
			
			}
			echo "</tr>";
			
		}
	
	
?>
</table>

