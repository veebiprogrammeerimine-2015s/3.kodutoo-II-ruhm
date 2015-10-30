<?php

		require_once("../../../configglobal.php");
		$database = "if15_koidkan";

		function getSingleTaskData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT day, d_time, d_task FROM tasks WHERE id=? AND deleted IS NULL");
		
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($day, $d_time, $d_task);
		$stmt->execute();
		
		
		$task = new Stdclass();
		
		
		if($stmt->fetch()){
		
			$task->day = $day;
			$task->d_time = $d_time;
			$task->d_task = $d_task;
			
	}else{
			
			header("Location: table.php");
	    }
		
	return $task;
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function updatetasks($id, $day, $d_time, $d_task){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				
		$stmt = $mysqli->prepare("UPDATE tasks SET day=?, d_time=?, d_task=? WHERE id=?");
		$stmt->bind_param("sssi", $day, $d_time, $d_task, $id);
		
		
		if($stmt->execute()){
			echo "Muudatus on tehtud";
		}
		
		
		$stmt->close();
		$mysqli->close();
		
		
	}



?>