<h3>Menüü</h3>

<ul>
<?php
	require_once("functions.php");
?>



	<?php if ($file_name == "home.php") { ?>
	
		<li>Avaleht</li>
		
	<?php } else { ?>
	
		<li> <a href="home.php">Avaleht</a> </li>
	
	<?php } ?>
	
	<?php 
	if(!isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "login.php"){ 
		
			echo "<li>Logi sisse</li>";
		
		}else{
			
			echo '<li><a href="login.php">Logi Sisse</a></li>';
		}
	}	
	?>

	<?php 
	if(!isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "register.php"){ 
		
			echo "<li>Registreeri</li>";
		
		}else{
			
			echo '<li><a href="register.php">Registreeri</a></li>';
		}
	}	
	?>
	
	<?php 
	if(isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "ylesanded.php"){ 
		
			echo "<li>Ülesanded</li>";
		
		}else{
			
			echo '<li><a href="ylesanded.php">Ülesanded</a></li>';
		}
	}
	else
	{
		echo "";
	}
	?>
	<?php 
	if(isset($_SESSION["logged_in_user_id"]))
	{
		if ($file_name == "data.php"){ 
		
			echo "<li>Numbrimärgid</li>";
		
		}else{
			
			echo '<li><a href="data.php">Numbrimärgid</a></li>';
		}
	}
	else
	{
		echo "";
	}	
	?>
	

	
</ul>