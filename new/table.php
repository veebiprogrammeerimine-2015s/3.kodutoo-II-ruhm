<?php
	//table
	require_once("functions.php");
	require_once("edit_functions.php");
	//kasutaja tahab midagi muuta
	if(isset($_POST["update"])){
		updatePost($_POST["id"], $_POST["post_title"], $_POST["post"]);
	}
	//kas kasutaja tahab kustutada, kas aadressi real on ?delete=??
	if(isset($_GET["delete"])){
		deletePost($_GET["delete"]);
	}
	
	$post_list = getPostData();
	
?>

<table border=1>
	<tr>
		<th>id</th>
		<th>User id</th>
		<th>post title</th>
		<th>Text</th>
		<th>X</th>
		<th>Edit</th>
		<th>Edit file</th>
	</tr>
	<?php
			//iga massiivis oleva elemendi kohta, masiivi pikkus, $i++ = $i=$i+1
		for($i = 0; $i<count($post_list); $i++){
			//kui kasutaja tahab muuta kuvan imput välja
			if(isset($_GET["edit"]) && $post_list[$i]->id == $_GET["edit"]){
				echo"<tr>";
				echo"<form action='table.php' method='post'>";
				echo"<td>".$post_list[$i]->id."</td>";
				echo"<td>".$post_list[$i]->user_id."</td>";
				echo"<td><input type='hidden' name='id' value='".$post_list[$i]->id."'><input name='post_title' value='".$post_list[$i]->post_title."'></td>";
				echo"<td><input name='post' value='".$post_list[$i]->post."'></td>";
				echo"<td><input type='submit' name='update'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo"</form>";
				echo"</tr>";
			}else{
				echo"<tr>";
				echo"<td>".$post_list[$i]->id."</td>";
				echo"<td>".$post_list[$i]->user_id."</td>";
				echo"<td>".$post_list[$i]->post_title."</td>";
				echo"<td>".$post_list[$i]->post."</td>";
				echo"<td><a href='?delete=".$post_list[$i]->id."'>x</a></td>";
				echo"<td><a href='?edit=".$post_list[$i]->id."'>edit</a></td>";
				echo"<td><a href='edit.php?edit=".$post_list[$i]->id."'>edit.php</a></td>";
				echo"</tr>";
			}
		}
	?>
</table>