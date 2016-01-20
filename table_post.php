<?php
	
	// table.php
	require_once("functions.php");
	require_once("header.php");
	
	
	$text_list = getTextData();
	//var_dump($car_list);
	$emailtable = getEmailData();
	
	
	
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deletePost($_GET["delete"]);
		
	}
?>

<table border=1 align="center" >
	<tr>
		<th>ID</th>
		<th>user_id</th>
		<th>text</th>
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($text_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$text_list[$i]->post_kd."</td>";
				echo "<td>".$text_list[$i]->user_id."</td>";
				echo "<td>".$text_list[$i]->text."</td>";
				echo "</tr>";
			}
			
			
		
	
	?>

</table>
