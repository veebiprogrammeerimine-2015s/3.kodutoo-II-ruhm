<?php
require_once("functions.php");
$create = "";
$someError = "";
$subject_error = $lecturer_error = $task_error = $date_error = $difficulty_error = $importance_error = "";
$subject = $lecturer = $task = $date = $difficulty = $importance = "";
if(isset($_POST["create"]))
{	
	if(isset($_POST['formSubmit']) )
	{
		$subject_error = "*";
	}
	else
	{
		$subject = $_POST['subject'];
	}
	//if ( empty($_POST["lecturer"]) ) 
	//{
	//	$lecturer_error = "*";
	//} 
	//else 
	//{
	//	$lecturer = cleanInput($_POST["lecturer"]);
	//}
	if ( empty($_POST["task"]) ) 
	{
		$task_error = "See väli on kohustuslik";
	}
	else 
	{
		$task = cleanInput($_POST["task"]);
	}
	if ( empty($_POST["date"]) ) 
	{
		$date_error = "See väli on kohustuslik";
	} 
	else 
	{
		$date = cleanInput($_POST["date"]);
	}
	if ( empty($_POST["difficulty"]) ) 
	{
		$difficulty_error = "See väli on kohustuslik";
	} 
	else 
	{
		$difficulty = cleanInput($_POST["difficulty"]);
	}
	if ( empty($_POST["importance"]) ) 
	{
		$importance_error = "See väli on kohustuslik";
	} 
	else 
	{
		$importance = cleanInput($_POST["importance"]);
	}
	if($subject_error != "" || $lecturer_error != "" || $task_error != "" || $date_error != "" || $difficulty_error != "" || $importance_error != "")
	{
		$someError = "<font color='red'> Kõik väljad peavad täidetud olema!</font>";
	}
	if($subject == "Arvuti töövahendina")
	{
		$lecturer = "Kalle Kivi";
	}
	if($subject == "Andmebaaside projekteerimine")
	{
		$lecturer = "Jaagup Kippar";
	}
	if($subject == "MS Windows")
	{
		$lecturer = "Tanel Toova";
	}
	if($subject == "Veebilehtede loomine")
	{
		$lecturer = "Andrus Rinde";
	}
	if($subject == "ITSPEA")
	{
		$lecturer = "Kaido Kikkas";
	}
	if($subject == "Intelligentne arvutikasutus")
	{
		$lecturer = "Andrus Rinde";
	}
	if($subject == "Programmeerimise alused")
	{
		$lecturer = "Inga Petuhhov";
	}
	if($subject == "Veebiprogrammeerimine")
	{
		$lecturer = "Romil Rõbtšenkov";
	}
	if($subject == "Arvutiriistvara")
	{
		$lecturer = "Teet Evartson";
	}
	if($subject == "Suuline ja kirjalik kommunikatsioon")
	{
		$lecturer = "Krista Kerge";
	}
	if($subject_error == "" && $lecturer_error == "" && $task_error == "" && $date_error == "" && $difficulty_error == "" && $importance_error == "")
	{
		addTask($subject, $lecturer, $task, $date, $difficulty, $importance);
		echo "Salvestatud!";
		echo $lecturer;
		echo $date;
	}
}
	function cleanInput($data) 
	{
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
	}
?>
<html>
<head>
  <title>Ülesande lisamine</title>
</head>
<body>

  <h2>Lisa kodune töö</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="subject">Aine</label><br>
  	<select name = "subject">
		<option value="Arvuti töövahendina">Arvuti töövahendina</option> 
		<option value="Andmebaaside projekteerimine">Andmebaaside projekteerimine</option>
		<option value="MS Windows">MS Windows</option>
		<option value="Veebilehtede loomine">Veebilehtede loomine</option>
		<option value="ITSPEA">ITSPEA</option>
		<option value="Intelligentne arvutikasutus">Intelligentne arvutikasutus</option>
		<option value="Programmeerimise alused">Programmeerimise alused</option>
		<option value="Veebiprogrammeerimine">Veebiprogrammeerimine</option>
		<option value="Arvutiriistvara">Arvutiriistvara</option>
		<option value="Suuline ja kirjalik kommunikatsioon">Suuline ja kirjalik kommunikatsioon</option>
	</select><br><br>
	<label for="task">Ülesande kirjeldus</label><br>
	<input name="task" type="text" placeholder="Ülesande kirjeldus"  value="<?=$task; ?>"> <br><br>
	<label for="date">Tähtaeg</label><br>
	<input name="date" type="date" placeholder="Kuupäev"  value="<?=$date; ?>"> <br><br>
	<label for="difficulty">Ülesande keerukus</label><br>
	<input name="difficulty" type="number" min="1" max="3" value="1"><br><br>
	<label for="importance">Ülesande olulisus</label><br>
	<input name="importance" type="number" min="1" max="3" value="1"><br><br>
	<input type="submit" name="create" value="Lisa" value="<?=$create; ?>"><?=$someError; ?>	
  </form>
	<br><a href="ylesanded.php"><button>Tagasi</button></a>
<body>
<html>
<?php require_once("../footer.php") ?>