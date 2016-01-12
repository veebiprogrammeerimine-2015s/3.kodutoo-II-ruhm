<?php
	session_start();

	require_once("../configglobal.php");
	$database = "if15_sizen";

	function getBookData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_name, book_name, book_description, book_rating FROM book_list WHERE deleted IS NULL");
		$stmt->bind_result($id, $user_name, $book_name, $book_description, $book_rating);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			$book = new StdClass();
			$book->id = $id;
			$book->user_name = $user_name;
			$book->book_name = $book_name;
			$book->book_description = $book_description;
			$book->book_rating = $book_rating;
			array_push($array, $book);
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $array;
		
	}
	
	function updateBookData(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			
		
		
	}
		
		
	
	
?>