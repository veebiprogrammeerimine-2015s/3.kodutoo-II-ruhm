<table border= 1>
	<tr>
		<th>id</th>
		<th>username</th>
		<th>book name</th>
		<th>description(max 30char)</th>
		<th>rating(0.0-5.0)</th>
		<th>X</th>
		<th>Edit</th>
	</tr>
	
	
	<?php
		for($i = 0; $i < count($book_list); $i++){
			echo "<tr>";
			
				echo "<td>".$book_list[$i]->id."</td>";
				echo "<td>".$book_list[$i]->user_name."</td>";
				echo "<td>".$book_list[$i]->book_name."</td>";
				echo "<td>".$book_list[$i]->book_description."</td>";
				echo "<td><a href='?delete=".$book_list[$i]->id."'>X</td>";
				echo "<td><a href='?edit=".$book_list[$i]->id."'>Edit</td>";
				
			echo "</tr>"; 
		}
	
	?>
</table>