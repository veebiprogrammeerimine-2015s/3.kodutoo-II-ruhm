<?php
     	
	require_once("functions.php");
	require_once("edit_functions.php");
		
	if(isset($_GET["delete"])){
		
		deleteTask($_GET["delete"]);
		
	}
	
	if(isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
		
	if(isset($_POST["update"])){
		
		updatetasks($_POST["id"], $_POST["day"], $_POST["d_time"], $_POST["d_task"]);
		
	}
	
	$task_list = getTaskData();
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h2>Minu ülesanded</h2>

<table border=1 >
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>päev</th>
		<th>kellaaeg</th>
		<th>ülesanne</th>
		<th>X</th>
	</tr>



	<?php
	
		for($i = 0; $i < count($task_list); $i++){
						
			
			if(isset($_GET["edit"]) && $task_list[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
					echo "<form action='table.php' method='post'>";
						echo "<td>".$task_list[$i]->id."</td>";
						echo "<td>".$task_list[$i]->user_id."</td>";
						echo "<input type='hidden' name='id' value='".$task_list[$i]->id."'>";
						echo "<td><select name='day' value='".$task_list[$i]->day."'>";
												
												
				        if($task_list[$i]->day == "esmaspäev"){
							echo '<option value="esmaspäev" selected>Esmaspäev</option>';
						}else{
							echo '<option value="esmaspäev">Esmaspäev</option>';
						}
						if($task_list[$i]->day == "teisipäev"){
							echo '<option value="teisipäev" selected>Teisipäev</option>';
						}else{
							echo '<option value="teisipäev">Teisipäev</option>';
						}
						if($task_list[$i]->day == "kolmapäev"){
							echo '<option value="kolmapäev" selected>Kolmapäev</option>';
						}else{
							echo '<option value="kolmapäev">Kolmapäev</option>';
						}
						if($task_list[$i]->day == "neljapäev"){
							echo '<option value="neljapäev" selected>Neljapäev</option>';
						}else{
							echo '<option value="neljapäev">Neljapäev</option>';
						}
						if($task_list[$i]->day == "reede"){
							echo '<option value="reede" selected>Reede</option>';
						}else{
							echo '<option value="reede">Reede</option>';
						}
						if($task_list[$i]->day == "laupäev"){
							echo '<option value="laupäev" selected>Laupäev</option>';
						}else{
							echo '<option value="laupäev">Laupäev</option>';
						}
						if($task_list[$i]->day == "pühapäev"){
							echo '<option value="pühapäev" selected>Pühapäev</option>';
						}else{
							echo '<option value="pühapäev">Pühapäev</option>';
						}
						
						echo "</td>";
						echo "<td><input type='time' name='d_time' value='".$task_list[$i]->d_time."'></td>";
						echo "<td><input name='d_task' value='".$task_list[$i]->d_task."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
			
				echo "<td>".$task_list[$i]->id."</td>";
				echo "<td>".$task_list[$i]->user_id."</td>";
				echo "<td>".$task_list[$i]->day."</td>";
				echo "<td>".$task_list[$i]->d_time."</td>";
				echo "<td>".$task_list[$i]->d_task."</td>";
				echo "<td><a href='?delete=".$task_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$task_list[$i]->id."'>edit</a></td>";
			
				echo "</tr>";
			}
			
			
		}
	
	?>

</table> 

<p>
	<a href="data.php"> Lisa uus ülesanne</a>
</p>
