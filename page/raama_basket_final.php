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
//suunan ajaloo lehele
	if (isset($_GET["my_history"])){
		header("Location: my_history.php");
	}
//kommentaari jätmiseks
	$raama_comment =  $raama_comment_error =  "";

	if(isset($_POST["add_comment_raama"])){
		if ( empty($_POST["raama_comment"]) ) {
				$raama_comment_error = "Sisesta kõigepealt kommentaar!";
		}else{
				$raama_comment = cleanInput($_POST["raama_comment"]);
			}
	if(	$raama_comment_error == ""){
		//käivitan funktsiooni
				$msg = commentRaama($raama_comment);
				if($msg != ""){
					//salvestamine õnnestus
					
					echo $msg;
					
				}
		
		}
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	
	$results_list = getGameData();
	
	

?>
<p>
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Rääma Discgolf</h1>

<p>
Par =  <?php 
echo $total_par_raama;
?><br>
Sinu tulemus oli 
<?php 
echo $total_result_raama. '('.$difference_raama.')';
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
		
	}


	?>
</table>
<p>Siin saad mängule kommentaari jätta:</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
<label for="raama_comment" ></label> <input id="raama_comment" name="raama_comment" type="text" value="<?=$raama_comment; ?>"> <?=$raama_comment_error; ?><br>
<input type="submit" name="add_comment_raama" value="Lisa kommentaar"><br><br>
</form>

<a href="my_history.php"> Mängude ajalugu</a>