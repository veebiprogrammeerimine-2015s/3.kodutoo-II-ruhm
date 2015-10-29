<?php
	//table
	require_once("functions.php");
	require_once("edit_functions.php");
	$post_list = getPostData();
?>

<?php
$page_title = "table2";
$file_name = "table2.php";
?>

<?php require_once("../header.php");?>

<h2>Posts</h2>
<table border=1>
	<tr>
		<th>id</th>
		<th>User id</th>
		<th>post title</th>
		<th>Show Post</th>
	</tr>
	<?php
		//iga massiivis oleva elemendi kohta, masiivi pikkus, $i++ = $i=$i+1
		for($i = 0; $i<count($post_list); $i++){
			echo"<tr>";
			echo"<td>".$post_list[$i]->id."</td>";
			echo"<td>".$post_list[$i]->user_id."</td>";
			echo"<td>".$post_list[$i]->post_title."</td>";
			echo"<td style='text-align:center'><a href='view.php?edit=".$post_list[$i]->id."'>X</a></td>";
			echo"</tr>";
		}
	?>
</table>

<?php require_once("../footer.php");?>