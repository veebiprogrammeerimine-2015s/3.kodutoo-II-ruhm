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
		<th>Retsepti Nimi</th>
		<th>Koostisosad</th>
		<th>Valmistamine</th>
		
	</tr>
	
	<?php
	
		for($i = 0; $i < count($retsept_list); $i++){



			if(isset($_GET["edit"]) && $retsept_list[$i]->id == $_GET["edit"]){
				// kasutajale muutmiseks
				echo "<tr>";
					echo "<form action='table.php' method='post'>";
						echo "<td>".$retsept_list[$i]->id."</td>";
						echo "<td><input type='hidden' name='id' value='".$retsept_list[$i]->id."'><input name='title' value='".$retsept_list[$i]->title."'></td>";
						echo "<td><input name='ingredients' value='".$retsept_list[$i]->ingredients."'></td>";
						echo "<td><input name='preparation' value='".$retsept_list[$i]->preparation."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
				
			}else{



			echo "<tr>";
			
			echo "<td>".$retsept_list[$i]->id."</td>";
			echo "<td>".$retsept_list[$i]->title."</td>";
			echo "<td>".$retsept_list[$i]->ingredients."</td>";
			echo "<td>".$retsept_list[$i]->preparation."</td>";


			if(isset($_SESSION["id_from_db"])){

	
			
				echo "<td><a href='?delete=".$retsept_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$retsept_list[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit=".$retsept_list[$i]->id."'>edit.php</a></td>";
			
			}

			echo "</tr>";

			}
			
		}
	
	
?>
</table>

