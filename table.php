<?php
	require_once("functions.php");
	
	$add_name_error = "";
	$add_description_error = "";
	$add_rating_error = "";
	
	$add_name = "";
	$add_description = "";
	$add_rating = "";
	$add_username = $_SESSION["name"];
	
	
	if(isset($_POST["add"])){
		
		if(empty($_POST["book_name"])){
				$add_name_error = "raamatu nimi on kohustuslik! ";
				echo $add_name_error;
			}else{
				$add_name = $_POST["book_name"];
			}
		if(empty($_POST["book_description"])){
				$add_description_error = "raamatu kirjeldus on kohustuslik! ";
				echo $add_description_error;
			}else{
				$add_description = $_POST["book_description"];
			}
		if(empty($_POST["book_rating"])){
				$add_rating_error = "raamatu hinnang on kohustuslik! ";
				echo $add_rating_error;
			}else{
				$add_rating = $_POST["book_rating"];
			}
		if($add_name_error == "" && $add_description_error == "" && $add_rating_error == ""){
				echo "diin";
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				$stmt = $mysqli->prepare("INSERT INTO book_list (user_name, book_name, book_description, book_rating) VALUES (?, ?, ?, ?)");
				$stmt->bind_param("sssd", $add_username, $add_name, $add_description, $add_rating);
				
				$stmt->execute();
				echo "Raamatu lisamine õnnestus!";
				$stmt->close();
				$mysqli->close();
				
			}
	}
	
	$book_list = getBookData();
	
	
	
	
	if(!isset($_SESSION["id"])){
		//suunan  login lehele
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		//suunan  login lehele
		session_destroy();
		header("Location: login.php");
	}
	
	echo "<h1>Tere ".$_SESSION["name"]."<form><input type='submit' name='logout' value='Logi välja'></form></h1>";
	
?>

<h2>Lugesid raamatu läbi? Lisa siia loetud raamat, kirjelda seda paari sõnaga, anna raamatule hinnang.</h2>
<table border= 1>
	<tr>
		<th>id</th>
		<th>username</th>
		<th>book name</th>
		<th>description(max 30char)</th>
		<th>rating(0.0-5.0)</th>
		<th>X</th>
		<th>Edit</th>
	</tr>
	
	
	<?php
		for($i = 0; $i < count($book_list); $i++){
			
			if(isset($_GET["edit"]) && $book_list[$i]->id == $_GET["edit"]){
				//kasutajale muutmiseks
				echo "<tr>";
					echo "<form action=table.php method='get'>";
						echo "<td>".$book_list[$i]->id."</td>";
						echo "<td>".$book_list[$i]->user_name."</td>";
						echo "<td><input name='number_plate' value='".$book_list[$i]->book_name."'></td>";
						echo "<td><input name='number_plate' value='".$book_list[$i]->book_description."'></td>";
						echo "<td><input name='number_plate' value='".$book_list[$i]->book_rating."'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
						echo "<td><input type='submit' name='update' value='muuda' ></td>";
						

					echo "</form";
					
				echo "</tr>";
				
				
			}else{
			echo "<tr>";
			
				echo "<td>".$book_list[$i]->id."</td>";
				echo "<td>".$book_list[$i]->user_name."</td>";
				echo "<td>".$book_list[$i]->book_name."</td>";
				echo "<td>".$book_list[$i]->book_description."</td>";
				echo "<td>".$book_list[$i]->book_rating."</td>";
				echo "<td><a href='?delete=".$book_list[$i]->id."'>X</td>";
				echo "<td><a href='?edit=".$book_list[$i]->id."'>Edit</td>";
				
			echo "</tr>"; 
			}
		}
	
	echo "<tr>";
		echo "<form action=table.php method='post'>";
			echo "<td>"."</td>";
			echo "<td>".$_SESSION["name"]."</td>";
			echo "<td><input name='book_name'>"."</td>";
			echo "<td><input name='book_description'>"."</td>";
			echo "<td><input name='book_rating'>"."</td>";
			echo "<td>"."</td>";
			echo "<td><input type='submit' name='add' value='Add'>"."</td>";
		echo "</form";
	echo "</tr>";  
	
	
	
?>
</table>
