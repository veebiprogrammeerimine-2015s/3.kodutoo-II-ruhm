<?php
	
	// table.php
	require_once("functions.php");
	require_once("edit_functions.php");
	
	if(!isset($_SESSION["id_from_db"])){
		
		header("Location: login.php");
	}
	
	
	if(isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	//kasutaja tahab midagi muuta
	if(isset($_POST["update"])){
		
		updateFlower($_POST["id"], $_POST["flower"], $_POST["color"]);
	}
	
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deleteFlower($_GET["delete"]);
		
	}
	
	
	
	$flower_list = getFlowerData();
?>
<table border=1 >
	<tr>
		<th>id</th>
		<th>user id</th>
		<th>lill</th>
		<th>värv</th>
		<th>X</th>
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($flower_list) - massiivi pikkus
		for($i = 0; $i < count($flower_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			if(isset($_GET["edit"]) && $flower_list[$i]->id == $_GET["edit"]){
				// kasutajale muutmiseks
				echo "<tr>";
					echo "<form action='table.php' method='post'>";
						echo "<td>".$flower_list[$i]->id."</td>";
						echo "<td>".$flower_list[$i]->user_id."</td>";
						echo "<td><input type='hidden' name='id' value='".$flower_list[$i]->id."'><input name='flower' value='".$flower_list[$i]->flower."'></td>";
						echo "<td><input name='color' value='".$flower_list[$i]->color."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
				
			}else{
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$flower_list[$i]->id."</td>";
				echo "<td>".$flower_list[$i]->user_id."</td>";
				echo "<td>".$flower_list[$i]->flower."</td>";
				echo "<td>".$flower_list[$i]->color."</td>";
				echo "<td><a href='?delete=".$flower_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$flower_list[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit=".$flower_list[$i]->id."'>edit.php</a></td>";
			
				echo "</tr>";
			}
			
			
		}
	
	?>

</table>