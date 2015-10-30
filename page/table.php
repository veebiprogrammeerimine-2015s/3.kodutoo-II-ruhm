<?php
//table.php
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
	
	//kasutaja tahab midagi muuta
	if(isset($_POST["update"])){
		
		updateResult($_POST["id"], $_POST["par"], $_POST["result"]);
		
	}
	//kas kasutaja tahab kustutada
	//kas aadressireal on ?delete=???
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteResult($_GET["delete"]);
		
		
	}
	$result_list = getResultData();
	//var_dump($array);
?>
<p>
	<?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<table border=1 >
<tr>
	<th>id</th>
	<th>kasutaja id</th>
	<th>raja par</th>
	<th>tulemus</th>
</tr>

	<?php
		
		
		for($i = 0; $i < count($result_list); $i++){
			
			//kui on see rida, mida kasutaja tahab muuta, siis kuvan input v'ljad
		if(isset($_GET["edit"]) && $result_list[$i]->id == $_GET["edit"]){
			
			echo "<tr>";
			echo "<form>";
			echo "<td>".$result_list[$i]->id."</td>";
			echo "<td>".$result_list[$i]->user_id."</td>";
			echo "<td><input name='par' value='".$result_list[$i]->par."'></td>";
			
			echo "<td><input name='result' value='".$result_list[$i]->result."'></td>";
			echo "<td><input type='submit' name='update'></td>";
			echo "<td><a href='table.php'>cancel</a></td>";			
						
			
			echo "</form>";
			echo "</tr>";
			
		}else{
			
			echo "<tr>";
			
			echo "<td>".$result_list[$i]->id."</td>";
			echo "<td>".$result_list[$i]->user_id."</td>";
			echo "<td>".$result_list[$i]->par."</td>";
			echo "<td>".$result_list[$i]->result."</td>";
			echo "<td><a href='?delete=".$result_list[$i]->id."'>X</a></td>";
			echo "<td><a href='?edit=".$result_list[$i]->id."'>edit</a></td>";
			
			echo "</tr>";}
			
			
			
		}
		?>


</table>