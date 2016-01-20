<?php require_once("functions.php");
	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}

?>  

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>


<html>
<h1>Olete sisselogitud!</h1>
<p>Siin sa võiks kustuda ära või parandada oma kuulutust!
<br> Vaata kõik kasutajad <a href="table.php"> siin!</a>
<br> Vaata sinu postitusi <a href="Single_post.php"> siin!</a>
<br> Data lehele! <a href="data.php"> siin!</a>

</body>
</html>
<?php
	
	// table.php
	require_once("User.class.php");
	
	// table.php
	require_once("functions.php");
	require_once("header.php");
	
	$user_table = getSelfData();
	
	
	
	//kasutaja tahab midagi muuta
	if(isset($_POST["update"])){
		
		updateCar($_POST["id"], $_POST["number_plate"], $_POST["color"]);
		
	}
	
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deletePost($_GET["delete"]);
		
	}
	
	
	
?>

<table border=1 align="center" >
	<tr>
		<th>ID</th>
		<th>user_id</th>
		<th>text</th>
		<th>text</th>
		<th>Delete kuulutus!</th>
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($user_table); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$user_table[$i]->post_kd."</td>";
				echo "<td>".$user_table[$i]->user_kd_id."</td>";
				echo "<td>".$user_table[$i]->user_kd_email."</td>";
				echo "<td>".$user_table[$i]->text."</td>";
				echo "<td><a href='?delete=".$user_table[$i]->post_kd."'>X</a></td>";
				
				echo "</tr>";
			}
			
			
		
	
	?>

</table>
