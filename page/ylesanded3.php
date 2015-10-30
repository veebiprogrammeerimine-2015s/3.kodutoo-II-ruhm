<?php
	$page_title = "Lõpetatud ülesanded";
	$file_name = "ylesanded3.php";
	require_once("../header.php")
?>
<?php

	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}	
	$ylesanded = doneTasks();
	

?>
<h3>Lõpetatud ülesanded</h3>
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
			echo "<td align=center>".$ylesanded[$i]->subject."</td>";
			echo "<td align=center>".$ylesanded[$i]->lecturer."</td>";
			echo "<td align=center>".$ylesanded[$i]->task."</td>";
			echo "<td align=center>".$ylesanded[$i]->datee."</td>";
			echo "<td align=center>".$ylesanded[$i]->difficulty."</td>";
			echo "<td align=center>".$ylesanded[$i]->importance."</td>";
			//echo "<td><a href='?delete=".$car_list[$i]->id."'>X</a></td>";
			
			echo "</tr>";
		}
	
	
	?>
</table	><br>
<a href="ylesanded.php"> <button>TAGASI</button> </a>
<?php require_once("../footer.php") ?>