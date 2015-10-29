<?php
	require_once("edit_functions.php");
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		updatePost($_POST["id"],$_POST["post_title"],$_POST["post"]);
	}
	if(!isset($_GET["edit"])){
		//kui aadressi real ei ole ?edit=, suuname table lehele
		header("location: table.php");
	}else{
		//küsime andmebaasist andmed id järgi
		$post_object = getSinglePostData($_GET["edit"]);
		//var_dump($post_object);
	}

?>

<?php
$page_title = "view";
$file_name = "view.php";
?>

<?php require_once("../header.php");?>

<h2><?=$post_object->post_title;?></h2>
<p style="margin-right: 1000px;"><?=$post_object->post;?></p><br><br>

<?php require_once("../footer.php");?>