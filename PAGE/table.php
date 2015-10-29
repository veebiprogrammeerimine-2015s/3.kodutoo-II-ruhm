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
	//sisse loginud?
	if(!isset($_SESSION["id_from_db"])){
	//suuname login lehele kui ei ole sisseloginud
	header("Location: login.php");
	}
	
	$post_list = getPostData();
	
?>

<?php
$page_title = "table";
$file_name = "table.php";
?>

<?php require_once("../header.php");?>

<h2>Posts</h2>
<table border=1>
	<tr>
		<th>id</th>
		<th>User id</th>
		<th>post title</th>
		<th>Delete</th>
		<th>Edit</th>
	</tr>
	<?php
			//iga massiivis oleva elemendi kohta, masiivi pikkus, $i++ = $i=$i+1
		for($i = 0; $i<count($post_list); $i++){
			//kui kasutaja tahab muuta kuvan imput välja
				echo"<tr>";
				echo"<td>".$post_list[$i]->id."</td>";
				echo"<td>".$post_list[$i]->user_id."</td>";
				echo"<td>".$post_list[$i]->post_title."</td>";
				echo"<td><a href='?delete=".$post_list[$i]->id."'>X</a></td>";
				echo"<td><a href='edit.php?edit=".$post_list[$i]->id."'>X</a></td>";
				echo"</tr>";
			}
	?>
</table>

<?php require_once("../footer.php");?>