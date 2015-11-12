<?php
//table.php
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
	
	//kasutaja tahab midagi muuta
	/* if(isset($_POST["update"])){
		
		updateResult($_POST["id"], $_POST["par"], $_POST["result"]); 
		
	}
	//kas kasutaja tahab kustutada
	//kas aadressireal on ?delete=???
	if(isset($_GET["delete"])){
		
		//saadan kaasa id, mida kustutada
		deleteResult($_GET["delete"]);
		
		
	}
	$result_list = getResultData();
	//var_dump($array);*/
?>
<p>
	<?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>



