<?php
     
	 
	 require_once("functions.php");
	
	if(!isset($_SESSION["id_from_db"])){
		
		header("Location: login.php");
	}
	
	
	
	if(isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	$day = $time = $task = $day_error = $time_error = $task_error = "";
	
	
	
	if(isset($_POST["create"])){
		if ( empty($_POST["day"]) ) {
			$day_error = "See väli on kohustuslik";
		}else{
			$day = cleanInput($_POST["day"]);
		}
		if ( empty($_POST["time"]) ) {
			$time_error = "See väli on kohustuslik";
		} else {
			$time = cleanInput($_POST["time"]);
		}
		if ( empty($_POST["task"]) ) {
			$task_error = "See väli on kohustuslik";
		} else {
			$task = cleanInput($_POST["task"]);
		}
		
		
		
		if(	$day_error == "" && $time_error == "" && $task_error == ""){
			
			$msg = createDayPlanner($day, $time, $task);
			
			if($msg != ""){
				$day = "";
				$time = "";
				$task = "";
								
				echo $msg;
				
			}
			
		}
    } 
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	
	
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

 <h2>Lisa uus ülesanne</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="day" >päev</label><br>
	<input id="day" name="day" type="text" value="<?=$day; ?>"> <?=$day_error; ?><br><br>
  	<label>kellaaeg</label><br>
	<input name="time" type="time" value="<?=$time; ?>"> <?=$time_error; ?><br><br>
  	<label>ülesanne</label><br>
	<input name="task" type="text" value="<?=$task; ?>"> <?=$task_error; ?><br><br>
	<input type="submit" name="create" value="Salvesta">
  </form>

<p>
	<a href="table.php"> Vaata kõikide ülesannete tabelit</a>
</p>  
	 

