<?php

	$page_title = "TOP KEK";
	$file_name = "index.php";


?>

<?php
	
	require_once("../header.php");
	require_once("funtions.php");

	if(isset($_SESSION["id_from_db"])){
		header("Location: data.php");
		
		
		
	}

?>

<h2>Avaleht</h2>




<?php
	
	require_once("../footer.php");



?>