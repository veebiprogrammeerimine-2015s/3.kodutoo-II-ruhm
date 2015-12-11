<?php
	
	require_once("session.php");
	
	$_SESSION["name"] = "tanja";
	
	echo($_SESSION["name"]);
?>