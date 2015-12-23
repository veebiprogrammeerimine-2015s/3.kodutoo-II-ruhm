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
	
	$results_list = getJoekaaruData();
?>
<p>
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Jõekääru Discgolf</h1>
<p>
Par =  <?php 
echo $total_par_joekaaru;
?><br>
Sinu tulemus oli 
<?php 
echo $total_result_joekaaru. '('.$difference_joekaaru.')';
?>
</p>

<table border=1 >
<tr>
	<th>Korv</th>
	<th>Par</th>
	<th>Tulemus</th>
	
</tr>

	<?php
	
	for($i = 0; $i < count($results_list); $i++){
		
		echo "<tr>";
			echo "<td>".'1'."</td>";
			echo "<td>".$results_list[$i]->basket1_par."</td>";
			echo "<td>".$results_list[$i]->basket1_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'2'."</td>";
			echo "<td>".$results_list[$i]->basket2_par."</td>";
			echo "<td>".$results_list[$i]->basket2_result."</td>";
		echo "</tr>";	
		echo "<tr>";
			echo "<td>".'3'."</td>";
			echo "<td>".$results_list[$i]->basket3_par."</td>";
			echo "<td>".$results_list[$i]->basket3_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'4'."</td>";
			echo "<td>".$results_list[$i]->basket4_par."</td>";
			echo "<td>".$results_list[$i]->basket4_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'5'."</td>";
			echo "<td>".$results_list[$i]->basket5_par."</td>";
			echo "<td>".$results_list[$i]->basket5_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'6'."</td>";
			echo "<td>".$results_list[$i]->basket6_par."</td>";
			echo "<td>".$results_list[$i]->basket6_result."</td>";
		echo "</tr>";	
		echo "<tr>";
			echo "<td>".'7'."</td>";
			echo "<td>".$results_list[$i]->basket7_par."</td>";
			echo "<td>".$results_list[$i]->basket7_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'8'."</td>";
			echo "<td>".$results_list[$i]->basket8_par."</td>";
			echo "<td>".$results_list[$i]->basket8_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'9'."</td>";
			echo "<td>".$results_list[$i]->basket9_par."</td>";
			echo "<td>".$results_list[$i]->basket9_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'10'."</td>";
			echo "<td>".$results_list[$i]->basket10_par."</td>";
			echo "<td>".$results_list[$i]->basket10_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'11'."</td>";
			echo "<td>".$results_list[$i]->basket11_par."</td>";
			echo "<td>".$results_list[$i]->basket11_result."</td>";
		echo "</tr>";	
		echo "<tr>";
			echo "<td>".'12'."</td>";
			echo "<td>".$results_list[$i]->basket12_par."</td>";
			echo "<td>".$results_list[$i]->basket12_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'13'."</td>";
			echo "<td>".$results_list[$i]->basket13_par."</td>";
			echo "<td>".$results_list[$i]->basket13_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'14'."</td>";
			echo "<td>".$results_list[$i]->basket14_par."</td>";
			echo "<td>".$results_list[$i]->basket14_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'15'."</td>";
			echo "<td>".$results_list[$i]->basket15_par."</td>";
			echo "<td>".$results_list[$i]->basket15_result."</td>";
		echo "</tr>";	
		echo "<tr>";
			echo "<td>".'16'."</td>";
			echo "<td>".$results_list[$i]->basket16_par."</td>";
			echo "<td>".$results_list[$i]->basket16_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'17'."</td>";
			echo "<td>".$results_list[$i]->basket17_par."</td>";
			echo "<td>".$results_list[$i]->basket17_result."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>".'18'."</td>";
			echo "<td>".$results_list[$i]->basket18_par."</td>";
			echo "<td>".$results_list[$i]->basket18_result."</td>";
		echo "</tr>";
		
	}


	?>
</table>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" >
<label for="comment" ></label> <input id="joekaaru_comment" name="joekaaru_comment" type="text" ><br>
<input type="submit" name="add_comment" value="Lisa kommentaar"><br><br>


<a href="my_history.php"> Mängude ajalugu</a>