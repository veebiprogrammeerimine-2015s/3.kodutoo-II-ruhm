<?php
	$page_title = "Ülesanded";
	$file_name = "ylesanded.php";
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
	$ylesanded = koolike();
	

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
		<th>Muuda</th>
		<th>Tehtud</th>
		<th>Eemalda</th>
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
			echo "<td align=center><a href='?edit=".$ylesanded[$i]->id."'><input type='submit' name='edit' value='Muuda'></a></td>";
			echo "<td align=center><a href='?done=".$ylesanded[$i]->id."'><input type='submit' name='done' value='Tehtud'></a></td>";
			echo "<td align=center><a href='?delete=".$ylesanded[$i]->id."'><input type='submit' name='delete' value='X'></a></td>";
			//echo "<td align=center><a href='?delete=".$ylesanded[$i]->id."'>X</a></td>";
			echo "</tr>";
		}
	
	
	?>
</table	>
<br>
<input type=button onClick="location.href='task.php'" value='Lisa ülesanne'>
<input type=button onClick="location.href='ylesanded2.php'" value='Eemaldatud ülesanded'>
<input type=button onClick="location.href='ylesanded3.php'" value='Lõpetatud ülesanded'>
</body>
</html>
<a href="?logout=1"> Logi välja <a>
<?php require_once("../footer.php") ?>