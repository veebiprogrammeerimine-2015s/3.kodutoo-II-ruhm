<h3>Menüü</h3>
<ul>




	<?php if ($file_name == "home.php") { ?>
	
		<li>Avaleht</li>
		
	<?php } else { ?>
	
		<li> <a href="home.php">Avaleht</a> </li>
	
	<?php } ?>
	
	<?php 
	
		if ($file_name == "login.php"){ 
		
			echo "<li>Logi sisse</li>";
		
		}else{
			
			echo '<li><a href="login.php">Logi Sisse</a></li>';
		}
		
	?>

	<?php 
	
		if ($file_name == "register.php"){ 
		
			echo "<li>Registreeri</li>";
		
		}else{
			
			echo '<li><a href="register.php">Registreeri</a></li>';
		}
		
	?>
	
	<?php 
	
		if ($file_name == "ylesanded.php"){ 
		
			echo "<li>Ülesanded</li>";
		
		}else{
			
			echo '<li><a href="ylesanded.php">Ülesanded</a></li>';
		}
		
	?>
	

	
</ul>