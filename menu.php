<h3>Menüü</h3>


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
	
	
	<?php 


		if(isset($_SESSION["id_from_db"]) || $file_name == "login.php") {
		
		

			echo '<li>Logi Sisse</li>';


		} 
	

	
	
		else{
		
		echo '<li><a href="login.php">Logi Sisse</a></li>';
		
	}

	
	
	
	
	
	?>
	
	<?php if($file_name == "table.php"){ 
	
	echo '<li>Vaata retsepte</li>';
	
	
	}else{
		
		echo '<li><a href="table.php">Vaata retsepte</a></li>';
		
	}
	
	
	
	
	?>
	

</ul>