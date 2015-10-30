<?php
	//muutujad
	$post_title = $post = $post_title_error = $post_error = "";	
	//lisame functions faili
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisse loginud
	if(!isset($_SESSION["id_from_db"])){
		//suuname login lehele kui ei ole sisseloginud
		header("Location: login.php");
	}

	
	if(isset($_POST["create"])){
		
		//kas on tühi
		if(empty($_POST["post_title"])){
			//jah oli tühi
			$post_title_error = "Title is needed";
		}else{
			$post_title = test_input($_POST["post_title"]);
		}
			
		//kas on tühi
		if(empty($_POST["post"])){
			//jah oli tühi
			$post_error= "Text is needed";
		}else{
			$post = test_input($_POST["post"]);
		}
		
		//kui errorit ei ole
		if($post_title_error == "" && $post_error == ""){
				$msg = createPost($post_title, $post);
				if($msg != ""){
					//salvestamine õnnestus, teen väljad tühjaks
					$post_title = "";
					$post = "";
					echo $msg;
				}
		}
	}
	function test_input($data) {
		$data = trim($data);                // võtab tühikud, tabid ja enterid ära
		$data = stripslashes($data);        // võtab \\ ära
		$data = htmlspecialchars($data);    // muudab asjad tekstiks
		return $data;	
	}
?>

<?php
$page_title = "data";
$file_name = "data.php";
?>	

<?php require_once("../header.php");?>



<h2>New post</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="post_title" >Title</label><br>
	<input size="50" id="post_title" name="post_title" type="text" value="<?=$post_title; ?>"> <?=$post_title_error; ?><br><br>
  	<label>Text</label><br>
	<textarea rows="6" cols="52" name="post" value="<?=$post; ?>"></textarea><?=$post_error; ?><br><br>
  	<input type="submit" name="create" value="Submit">
  </form>
  
<?php require_once("../footer.php");?>