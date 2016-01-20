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
		
		updatePost($_POST["text"], $_POST["post_kd"]);
		
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
		<th>email</th>
		<th>text</th>
		<th>Delete kuulutus!</th>
		<th>EDIT!</th>
		
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($user_table); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			if(isset($_GET["edit"]) && $user_table[$i]->post_kd == $_GET["edit"]){
				// kasutajale muutmiseks
				echo "<tr>";
					echo "<form action='Single_post.php' method='post'>";
						echo "<td>".$user_table[$i]->post_kd."</td>";
						echo "<td>".$user_table[$i]->user_kd_id."</td>";
						echo "<td>".$user_table[$i]->user_kd_email."</td>";
						echo "<td><input name='text' value='".$user_table[$i]->text."'></td>";
						echo "<td><input type='hidden' name='post_kd' value='".$user_table[$i]->post_kd."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='Single_post.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
			
			
			}else{
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$user_table[$i]->post_kd."</td>";
				echo "<td>".$user_table[$i]->user_kd_id."</td>";
				echo "<td>".$user_table[$i]->user_kd_email."</td>";
				echo "<td>".$user_table[$i]->text."</td>";
				echo "<td><a href='?delete=".$user_table[$i]->post_kd."'>X</a></td>";
				echo "<td><a href='?edit=".$user_table[$i]->post_kd."'>edit</a></td>";
				echo "</tr>";
			}
			
			
		
		}
	?>

</table>
