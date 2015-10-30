<?php
	require_once("edit_functions.php");
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		updatePost($_POST["id"],$_POST["post_title"],$_POST["post"]);
	}
	if(!isset($_GET["view"])){
		//kui aadressi real ei ole ?view=, suuname table lehele
		header("location: table2.php");
	}else{
		//küsime andmebaasist andmed id järgi
		$post_object = getSinglePostData($_GET["view"]);
		//var_dump($post_object);
	}

?>

<?php
$page_title = "view";
$file_name = "view.php";
?>

<?php require_once("../header.php");?>

<h2><?=$post_object->post_title;?></h2>
<p style="width: 500px; padding: 10px; border: 1px solid gray;"><?=$post_object->post;?></p><br><br>

<?php require_once("../footer.php");?>