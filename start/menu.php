
<h2>Menu</h2>
<ul>
	
	<?php if($file_name == "home.php"){ ?>
	
		<li>Avaleht</li>
	
	<?php } else { ?>
	
		<li><a href="home.php">Avaleht</a></li>
	
	<?php } ?>
	
	<?php 
		
		if($file_name == "login.php"){ 
		
			echo "<li>Logi sisse</li>";
		
		}else{
	
			echo '<li><a href="login.php">Logi sisse</a></li>';
		}
		
	?>
	
	<?php 
		
		if($file_name == "../register.php"){ 
		
			echo "<li>Registreerimine</li>";
		
		}else{
	
			echo '<li><a href="register.php">Registreerimine</a></li>';
		}
		
	?>
	
	<?php 
		
		if($file_name == "data.php"){ 
		
			echo "<li>Lisa auto</li>";
		
		}else{
	
			echo '<li><a href="data.php">Lisa auto</a></li>';
		}
		
	?>
	
	
	
</ul> 