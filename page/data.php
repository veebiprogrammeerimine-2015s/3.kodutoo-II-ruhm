<?php
//Siia tuleb discgolfitabelid

//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}	
//mängu lisamise errorid
	$game_name = $baskets = $game_name_error = $baskets_error = "";	
	
	if(isset($_POST["create_game"])){
			if ( empty($_POST["game_name"]) ) {
				$game_name_error = "See väli on kohustuslik";
			}else{
				$game_name = cleanInput($_POST["game_name"]);
			}
			if ( empty($_POST["baskets"]) ) {
				$baskets_error = "See väli on kohustuslik";
			} else {
				$baskets = cleanInput($_POST["baskets"]);
			}
	if(	$game_name_error == "" && $baskets_error == ""){
		// functions.php failis käivina funktsiooni
				//msg on message
				$msg = createGame ($game_name, $baskets);
				
				if($msg != ""){
					//salvestamine õnnestus
					//teen tühjaks input väljad
					$game_name	= "";
					$baskets = "";
					
					echo $msg;
					
				}
			}
	}	// create if end
	
//tulemuse lisamise errorid	
	$par = $my_result = $par_error = $my_result_error = "";
	
	if(isset($_POST["create"])){
			if ( empty($_POST["par"]) ) {
				$par_error = "See väli on kohustuslik";
			}else{
				$par = cleanInput($_POST["par"]);
			}
			if ( empty($_POST["my_result"]) ) {
				$my_result_error = "See väli on kohustuslik";
			} else {
				$my_result = cleanInput($_POST["my_result"]);
			}
	if(	$par_error == "" && $my_result_error == ""){
		// functions.php failis käivina funktsiooni
				//msg on message
				$msg = createResult ($par, $my_result);
				
				if($msg != ""){
					//salvestamine õnnestus
					//teen tühjaks input väljad
					$par	= "";
					$my_result = "";
					
					echo $msg;
					
				}
			}
	}	// create if end
	
	//kas kasutaja tahab kustutada
	//kas aadressireal on ?delete=???
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteGame($_GET["delete"]);
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	  
	  
	  $game_list = getGameData();
?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h1>Discgolf</h1><br>
<h2>Mängu lisamine</h2><br>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="game_name" >Mängu nimetus</label> <input id="game_name" name="game_name" type="text" value="<?=$game_name; ?>"> <?=$game_name_error; ?>
  	<label for="baskets">Korvide arv</label> <input name="baskets" type="number" value="<?=$baskets; ?>"> <?=$baskets_error; ?>
  	<input type="submit" name="create_game" value="Salvesta">
  </form>
  <table border=1 >
<tr>
	<th>mängu id</th>
	<th>mängu nimetus</th>
	
</tr>
<?php for($i = 0; $i < count($game_list); $i++){
	
	
		
			

			
			echo "<tr>";
			
			echo "<td>".$game_list[$i]->id."</td>";
			echo "<td>".$game_list[$i]->name."</td>";
			echo "<td><a href='?add_result=".$game_list[$i]->id."&baskets=".$game_list[$i]->baskets."'>lisa tulemus</a></td>";
			echo "<td><a href='?delete=".$game_list[$i]->id."'>kustuta mäng</a></td>";
			
			echo "</tr>";
			
		
}			
?>
</table>
<?php 

if(isset($_GET["add_result"])){

?>

	<h2>Tulemuse lisamine</h2>
	Korv/Par/My result

	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<?php for($i=1; $i <= $_GET["baskets"]; $i++){ ?>
		<label>Korv <?=$i;?></label>  <input id="par" name="par" type="number" value="<?=$par;?>"><?=$par_error; ?><input id="my_result" name="my_result" type="number" value="<?=$my_result;?><?=$my_result_error; ?>"><input type="submit" name="add_result" value="Salvesta"><br>
		
	
		
	  
		<?php 
		}
		?>  
		</form>
	  
<?php 
}
?>  