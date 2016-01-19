<?php
	$page_title = "Tabeli leht";
	$file_name = "table.php";
	
?>

<?php require_once("menu.php")?>

<?php
	
	require_once("functions.php");
	require_once("edit_functions.php");
	
	if(isset($_POST["update"])){
		updateCars($_POST["id"], $_POST["year"], $_POST["make"], $_POST["model"], $_POST["horsepower"], $_POST["topspeed"], $_POST["transmission"]);
	}
	
	if(isset($_GET["delete"])){
		deleteCars($_GET["delete"]);	
	}
	
	
	$car_list = getCarsData();
?>

<table border=1 >
	<tr>
		<th>id</th>
		<th>User ID</th>
		<th>Year</th>
		<th>Make</th>
		<th>Model</th>
		<th>Horsepower</th>
		<th>Topspeed</th>
		<th>Transmission</th>
		<th>X</th>
		<th>edit</th>
	</tr>
	
	<?php
		for($i = 0; $i < count($car_list); $i++){
			if(isset($_GET["edit"]) && $car_list[$i]->id == $_GET["edit"]){
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<td>".$car_list[$i]->id."<input type='hidden' name='id' value='".$car_list[$i]->id."'></td>";
				echo "<td>".$car_list[$i]->user_id."</td>";
				echo "<td><input name='year' value='".$car_list[$i]->year."'></td>";
				echo "<td><input name='make' value='".$car_list[$i]->make."'></td>";
				echo "<td><input name='model' value='".$car_list[$i]->model."'></td>";
				echo "<td><input name='horsepower' value='".$car_list[$i]->horsepower."'></td>";
				echo "<td><input name='topspeed' value='".$car_list[$i]->topspeed."'></td>";
				echo "<td><input name='transmission' value='".$car_list[$i]->transmission."'></td>";
				echo "<td><input type='submit' name='update'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
			
				echo "<tr>";
				echo "<td>".$car_list[$i]->id."</td>";
				echo "<td>".$car_list[$i]->user_id."</td>";
				echo "<td>".$car_list[$i]->year."</td>";
				echo "<td>".$car_list[$i]->make."</td>";
				echo "<td>".$car_list[$i]->model."</td>";
				echo "<td>".$car_list[$i]->horsepower."</td>";
				echo "<td>".$car_list[$i]->topspeed."</td>";
				echo "<td>".$car_list[$i]->transmission."</td>";
				echo "<td><a href='?delete=".$car_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$car_list[$i]->id."'>edit</a></td>";
				echo "</tr>";
			}
		}
	?>
</table>