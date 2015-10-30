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

	<?php
		//iga massiivis oleva elemendi kohta, masiivi pikkus, $i++ = $i=$i+1
		for($i = 0; $i<count($post_list); $i++){ ?>
		
			<h2><?=$post_list[$i]->post_title;?></h2>
			<p><i>By: <?=$post_list[$i]->username;?></i></p>
			<p style="width: 500px; padding: 10px; border: 1px solid gray;"><?=$post_list[$i]->post;?></p>
			<?php
			echo"<a href='view.php?view=".$post_list[$i]->id."'>Read More</a>";
		}
	?>

<?php require_once("../footer.php");?>