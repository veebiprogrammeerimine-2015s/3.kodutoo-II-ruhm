<?php

//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}
	$results_list = getGameData();
?>
<p>
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Rääma Discgolf</h1>
<p>Mäng lõpetatud</p>

<table border=1 >
<tr>
	<th>Korv</th>
	<th>Par</th>
	<th>Tulemus</th>
	<th>Kommentaar</th>
</tr>

	<?php
	
	for($i = 0; $i < count($results_list); $i++){
		
		echo "<tr>";
			echo "<td>".'1'."</td>";
			echo "<td>".$results_list[$i]->basket1_par."</td>";
			echo "<td>".$results_list[$i]->basket1_result."</td>";
			echo "<td>".$results_list[$i]->comment."</td>";
		echo "</tr>";	
		
	}


	?>
</table>