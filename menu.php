<h3>Menüü</h3>
<?php

	echo $file_name;

?>

<ul>
	<?php if($file_name == "home.php"){ ?>
		
	<li>
		Avaleht
	</li>
		
	<?php } else { ?>
		
	<li>
		<a href="home.php">Avaleht</a>
	</li>
		
		
	<?php } ?>
	
	
	<?php if($file_name == "home.php"){ 
	
	echo '<li>Logi Sisse</li>';
	
	
	}else{
		
		echo '<li><a href="login.php">Logi Sisse</a></li>';
		
	}
	
	
	
	
	?>
	
	
	

</ul>