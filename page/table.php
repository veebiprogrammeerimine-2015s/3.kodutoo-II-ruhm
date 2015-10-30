<?php
	
	// table.php
	require_once("funtions.php");
	require_once("edit_functions.php");


	if(isset($_POST["update"])){
		
		updateRetsept($_POST["id"], $_POST["title"], $_POST["ingredients"], $_POST["preparation"]);
		
	}
	
	if(isset($_GET["delete"])){
		//saadan kaasa id mida kustutada
		
		deleteRetsept($_GET["delete"]);
		
	}
	
	$retsept_list = getRetseptData();
?>

<table border=1 >
	<tr>
		<th>ID</th>
		<th>user_ID</th>
		<th>Retsepti Nimi</th>
		<th>Koostisosad</th>
		<th>Valmistamine</th>
		
	</tr>
	
	<?php
	
		for($i = 0; $i < count($retsept_list); $i++){







			echo "<tr>";
			
			echo "<td>".$retsept_list[$i]->id."</td>";
			echo "<td>".$retsept_list[$i]->user_id."</td>";
			echo "<td>".$retsept_list[$i]->title."</td>";
			echo nl2br("<td>".$retsept_list[$i]->ingredients."</td>");
			echo nl2br("<td>".$retsept_list[$i]->preparation."</td>");


			if(isset($_SESSION["id_from_db"])) {

		
					
				
			
				echo "<td><a href='?delete=".$retsept_list[$i]->id."'>X</a></td>";

				echo "<td><a href='edit.php?edit=".$retsept_list[$i]->id."'>edit</a></td>";
				
			}

			echo "</tr>";

			
			
		}
	
	
?>
</table>

