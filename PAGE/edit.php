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
	//id mida muudame
	//echo $_GET["edit"];
	//vaja saada kätte kõige uuemad andmed id kohta
	
?>

<h2>Change Post</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>">
  	<label for="post_title" >Title</label><br>
	<input id="post_title" name="post_title" type="text" value="<?=$post_object->post_title;?>"><br><br>
  	<label for="post">Text</label><br>
	<textarea rows="6" cols="52" id="post" name="post"><?=$post_object->post;?></textarea><br><br>
  	<input type="submit" name="update" value="Save">
  </form>