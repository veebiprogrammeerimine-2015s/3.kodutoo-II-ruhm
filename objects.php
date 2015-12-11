<?php
	
	$user = new StdClass();
	
	$user->name = "Romil";
	$user->gender = "male";
	
	
	var_dump($user);
	
	$user->name = "Juku";
	
	echo("<br>");
	echo($user->name);
	
	
	//error
	
	$error = new StdClass();
	
	
	$error->id = 0;
	$error->message("Unknown error");
	
	$error->id = 3;
	$error->message("Wrong password");
	
	
	
?>