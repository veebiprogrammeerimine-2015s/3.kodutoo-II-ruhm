<?php

	require_once("functions.php");
	/*if(isset($_GET["delete"])){
		
		deleteTask($_GET["delete"]);
			
	}
	if(isset($_GET["edit"])){
		
		editTask($_GET["edit"]);
		
	}	*/	
	$ylesanded = deletedTasks();
	

?>
<link rel="stylesheet" type="text/css" href="disain/yldine.css">
<table border=1 >
	<tr>
		<th>Aine nimetus</th>
		<th>Õppejõud</th>
		<th>Ülesande kirjeldus</th>
		<th>Tähtaeg</th>
		<th>Raskus</th>
		<th>Olulisus</th>
	</tr>
	
	<?php
	
		//iga massiivis oleva elemendi kohta
		//count($ylesanded) - massiivi pikkus
		for($i = 0; $i < count($ylesanded); $i++)
		{
			echo "<tr>";
			
			//echo "<td>".$ylesanded[$i]->id."</td>";
			echo "<td align=center>".$ylesanded[$i]->aine."</td>";
			echo "<td align=center>".$ylesanded[$i]->opetaja."</td>";
			echo "<td align=center>".$ylesanded[$i]->ylesanne."</td>";
			echo "<td align=center>".$ylesanded[$i]->kuupaev."</td>";
			echo "<td align=center>".$ylesanded[$i]->raskus."</td>";
			echo "<td align=center>".$ylesanded[$i]->olulisus."</td>";
			//echo "<td><a href='?delete=".$car_list[$i]->id."'>X</a></td>";
			
			echo "</tr>";
		}
	
	
	?>
</table	><br>
<a href="ylesanded.php"> <button>TAGASI</button> </a>
<?php require_once("../footer.php") ?>