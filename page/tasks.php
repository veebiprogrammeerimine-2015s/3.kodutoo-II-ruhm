<?php
	$page_title = "Ülesanded";
	$file_name = "tasks.php";
?>
<?php
	//kopeerime header.php sisu
	// ../ -tähistab, et fail asub ühe võrra kõrgemal kaustas
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

	if(isset($_GET["delete"])){
		
		deleteTask($_GET["delete"]);
			
	}
	if(isset($_GET["done"])){
		
		doneTask($_GET["done"]);
			
	}
	if(isset($_GET["edit"])){
		
		editTask($_GET["edit"]);
		
	}		
	$tasks = tasks();
	

?>
<html>
<table border=1 >
	<tr>
		<th>Aine nimetus</th>
		<th>Õppejõud</th>
		<th>Ülesande kirjeldus</th>
		<th>Tähtaeg</th>
		<th>Raskus</th>
		<th>Olulisus</th>
		<!--<th>Muuda</th>-->
		<th>Tehtud</th>
		<th>Eemalda</th>
	</tr>
	
	<?php
	
		//iga massiivis oleva elemendi kohta
		//count($tasks) - massiivi pikkus
		for($i = 0; $i < count($tasks); $i++)
		{
			echo "<tr>";
			
			//echo "<td>".$tasks[$i]->id."</td>";
			echo "<td align=center>".$tasks[$i]->subject."</td>";
			echo "<td align=center>".$tasks[$i]->lecturer."</td>";
			echo "<td align=center>".$tasks[$i]->task."</td>";
			echo "<td align=center>".$tasks[$i]->datee."</td>";
			echo "<td align=center>".$tasks[$i]->difficulty."</td>";
			echo "<td align=center>".$tasks[$i]->importance."</td>";
			//echo "<td align=center><a href='?edit=".$tasks[$i]->id."'><input type='submit' name='edit' value='Muuda'></a></td>";
			echo "<td align=center><a href='?done=".$tasks[$i]->id."'><input type='submit' name='done' value='Tehtud'></a></td>";
			echo "<td align=center><a href='?delete=".$tasks[$i]->id."'><input type='submit' name='delete' value='X'></a></td>";
			//echo "<td align=center><a href='?delete=".$tasks[$i]->id."'>X</a></td>";
			echo "</tr>";
		}
	
	
	?>
</table	>
<br>
<input type=button onClick="location.href='task.php'" value='Lisa ülesanne'>
<input type=button onClick="location.href='deleted.php'" value='Eemaldatud ülesanded'>
<input type=button onClick="location.href='done.php'" value='Lõpetatud ülesanded'>
</body>
</html><br>
<?php require_once("../footer.php") ?>