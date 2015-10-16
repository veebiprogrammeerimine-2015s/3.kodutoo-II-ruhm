<h3>Menu</h3>
<ul>
	<?php if($file_name == "home.php"){
		echo "<li>Avaleht</li>";
	}else{
		echo '<li><a href="home.php">Avaleht</a></li>';}
	?>

	<?php if($file_name == "login.php"){
		echo "<li>Login</li>";
	}else{
		echo '<li><a href="login.php">Login</a></li>';}
	?>
	
	<?php if($file_name == "data.php"){
		echo "<li>Data</li>";
	}else{
		echo '<li><a href="data.php">Data</a></li>';}
	?>
</ul>