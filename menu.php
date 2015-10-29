<h3>Menüü</h3>
<?php

	echo $file_name;

?>

<ul>
	<?php if($file_name == "index.php"){ ?>
		
	<li>
		Avaleht
	</li>
		
	<?php } else { ?>
		
	<li>
		<a href="index.php">Avaleht</a>
	</li>
		
		
	<?php } ?>
	
	
	<?php if($file_name == "login.php"){ 
	
	echo '<li>Logi Sisse</li>';
	
	
	}else{
		
		echo '<li><a href="login.php">Logi Sisse</a></li>';
		
	}
	
	
	
	
	?>
	
	
	

</ul>