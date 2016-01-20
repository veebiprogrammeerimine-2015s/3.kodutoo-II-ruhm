<?php
	
	// table.php
	require_once("functions.php");
	require_once("header.php");

	
	$user_list = getUserData();
	//var_dump($car_list);

?>

<table border=1 align="center" >
	<tr>
		<th>USER ID</th>
		<th>USER E-MAIL</th>
		<th>SAADA SÕNUM</th>
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($user_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$user_list[$i]->id."</td>";
				echo "<td>".$user_list[$i]->email."</td>";
				echo "<td><a href='comment.php?edit=".$user_list[$i]->id."'>comment.php</a></td>";
			
				echo "</tr>";
			}
			
			
		
	
	?>

</table>
