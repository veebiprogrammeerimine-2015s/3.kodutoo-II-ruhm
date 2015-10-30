<h3>Menu</h3>
<?php require_once("functions.php");?>
<ul>
	<?php if($file_name == "home.php"){
		echo "<li>Home Page</li>";
	}else{
		echo '<li><a href="home.php">Home Page</a></li>';}
	?>

	<?php if($file_name == "login.php"){
		echo "<li>Login</li>";
	}else{
		echo '<li><a href="login.php">Login</a></li>';}
		?>
	
	<?php if($file_name == "data.php"){
		echo "<li>New Post</li>";
	}else{
		echo '<li><a href="data.php">New Post</a></li>';}
	?>
	
	<?php if($file_name == "table.php"){
		echo "<li>Your Posts</li>";
	}else{
		echo '<li><a href="table.php">Your Posts</a></li>';}
	?>
	
	<?php if($file_name == "table2.php"){
		echo "<li>Posts</li>";
	}else{
		echo '<li><a href="table2.php">Posts</a></li>';}
	?>
</ul>

<?php
	//logni välja
	if(isset($_GET["logout"])){
		//kustutab kõik session muutujad
		session_destroy();
		header("Location: login.php");
	}
?>

<p>
<?php if(!isset($_SESSION["id_from_db"])){
	}else{
		echo '<a href="?logout=1"> Logout</a>';}
	?>
</p>