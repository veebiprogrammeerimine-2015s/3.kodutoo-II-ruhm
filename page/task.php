<?php
require_once("functions.php");
$create = "";
$someError = "";
$aine_error = $opetaja_error = $ylesanne_error = $kuupaev_error = $raskus_error = $olulisus_error = "";
$aine = $opetaja = $ylesanne = $kuupaev = $raskus = $olulisus = "";
if(isset($_POST["create"]))
{	
	if(isset($_POST['formSubmit']) )
	{
		$aine_error = "*";
	}
	else
	{
		$aine = $_POST['aine'];
	}
	//if ( empty($_POST["opetaja"]) ) 
	//{
	//	$opetaja_error = "*";
	//} 
	//else 
	//{
	//	$opetaja = cleanInput($_POST["opetaja"]);
	//}
	if ( empty($_POST["ylesanne"]) ) 
	{
		$ylesanne_error = "See väli on kohustuslik";
	}
	else 
	{
		$ylesanne = cleanInput($_POST["ylesanne"]);
	}
	if ( empty($_POST["kuupaev"]) ) 
	{
		$kuupaev_error = "See väli on kohustuslik";
	} 
	else 
	{
		$kuupaev = cleanInput($_POST["kuupaev"]);
	}
	if ( empty($_POST["raskus"]) ) 
	{
		$raskus_error = "See väli on kohustuslik";
	} 
	else 
	{
		$raskus = cleanInput($_POST["raskus"]);
	}
	if ( empty($_POST["olulisus"]) ) 
	{
		$olulisus_error = "See väli on kohustuslik";
	} 
	else 
	{
		$olulisus = cleanInput($_POST["olulisus"]);
	}
	if($aine_error != "" || $opetaja_error != "" || $ylesanne_error != "" || $kuupaev_error != "" || $raskus_error != "" || $olulisus_error != "")
	{
		$someError = "<font color='red'> Kõik väljad peavad täidetud olema!</font>";
	}
	if($aine == "Arvuti töövahendina")
	{
		$opetaja = "Kalle Kivi";
	}
	if($aine == "Andmebaaside projekteerimine")
	{
		$opetaja = "Jaagup Kippar";
	}
	if($aine == "MS Windows")
	{
		$opetaja = "Tanel Toova";
	}
	if($aine == "Veebilehtede loomine")
	{
		$opetaja = "Andrus Rinde";
	}
	if($aine == "ITSPEA")
	{
		$opetaja = "Kaido Kikkas";
	}
	if($aine == "Intelligentne arvutikasutus")
	{
		$opetaja = "Andrus Rinde";
	}
	if($aine == "Programmeerimise alused")
	{
		$opetaja = "Inga Petuhhov";
	}
	if($aine == "Veebiprogrammeerimine")
	{
		$opetaja = "Romil Rõbtšenkov";
	}
	if($aine == "Arvutiriistvara")
	{
		$opetaja = "Teet Evartson";
	}
	if($aine == "Suuline ja kirjalik kommunikatsioon")
	{
		$opetaja = "Krista Kerge";
	}
	if($aine_error == "" && $opetaja_error == "" && $ylesanne_error == "" && $kuupaev_error == "" && $raskus_error == "" && $olulisus_error == "")
	{
		addTask($aine, $opetaja, $ylesanne, $kuupaev, $raskus, $olulisus);
		echo "Salvestatud!";
		echo $opetaja;
		echo $kuupaev;
	}
}
	function cleanInput($data) 
	{
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
	}
	/*function editTask($id_to_be_edited)
	{
	header("Location: task.php");
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT aine, opetaja, ylesanne, kuupaev, raskus, olulisus FROM koolike WHERE id=?");
	$stmt->bind_param("i", $id_to_be_edited);
	$stmt->bind_result($eaine, $eopetaja, $eylesanne, $ekuupaev, $eraskus, $eolulisus);
	$stmt->execute();
	
	$aine = $eaine;
	$opetaja = $eopetaja;
	$ylesanne = $eylesanne;
	$kuupaev = $ekuupaev;
	$eraskus = $raskus;
	$eolulisus = $olulisus;
	
	$stmt->close();
	$mysqli->close();
	<?=$opetaja_error; ?>
	<?=$ylesanne_error; ?>
	<?=$kuupaev_error; ?>
	 <?=$raskus_error; ?>
	  <?=$olulisus_error; ?>
	  <input name="opetaja" type="text" placeholder="Õpetaja" value="<?=$opetaja; ?>"> 
	}*/
?>
<link rel="stylesheet" type="text/css" href="disain/yldine.css">
<!DOCTYPE html>
<html>
<head>
  <title>Ülesande lisamine</title>
</head>
<body>

  <h2>Lisa kodune töö</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="aine">Aine</label><br>
  	<select name = "aine">
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
	<label for="ylesanne">Ülesande kirjeldus</label><br>
	<input name="ylesanne" type="text" placeholder="Ülesande kirjeldus"  value="<?=$ylesanne; ?>"> <br><br>
	<label for="kuupaev">Tähtaeg</label><br>
	<input name="kuupaev" type="date" placeholder="Kuupäev"  value="<?=$kuupaev; ?>"> <br><br>
	<label for="raskus">Ülesande keerukus</label><br>
	<input name="raskus" type="number" min="1" max="3" value="1"><br><br>
	<label for="olulisus">Ülesande olulisus</label><br>
	<input name="olulisus" type="number" min="1" max="3" value="1"><br><br>
	<input type="submit" name="create" value="Lisa" value="<?=$create; ?>"><?=$someError; ?>	
  </form>
	<br><a href="ylesanded.php"><button>Tagasi</button></a>
<body>
<html>
<?php require_once("../footer.php") ?>