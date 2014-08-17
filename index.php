<html>
<head>
	<title>ToDoList for CakeMail Interview</title>

	<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
	<script src='/js/j.js'></script>
	<script src='/js/jquery.datetimepicker.js'></script>
	<link rel='stylesheet' href='/css/s.css'>
	<link rel='stylesheet' href='/css/jquery.datetimepicker.css'>
	<link href='//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet'>
</head>
<body>
	<div id='taskList'>
		<table>
			<?php 
				require('db.php'); 
				require('core.php'); 
				try {
					// Task not done
			        $results = $db->query("SELECT * FROM tasks WHERE status LIKE 'Not Done' ORDER BY due_date DESC,priority ASC");
			        if(!empty($results)){
			        	echo '<tr><th></th><th>Priority</th><th>Due Date</th><th></th></tr>';
				        while($row = $results->fetch(PDO::FETCH_OBJ)) 
						{
					        echo 	stringify($row) ;
						}
					}
					echo '</table><table>';
					$results = $db->query("SELECT * FROM tasks WHERE status LIKE 'Done' ORDER BY due_date DESC, priority ASC");
			        while( $row = $results->fetch(PDO::FETCH_OBJ)) 
					{
					    echo  	stringify($row) ;
					}

			    } catch(PDOExecption $e) { 
			        $db->rollback(); 
			        echo "Error!: " . $e->getMessage() . "</br>"; 
			    }
			?>
		</table>
		<div id='addtask' onclick='showForm()'>
			<i class='fa fa-plus'></i>
			Add a new task...
		</div>
	</div>
	
	<div id='form'>
		<label>Task Name</label>
		<input type='text' id='taskName' placeholder='task name...'/><br/>
		<label>DueDate <input type='checkbox' onclick='toggleId("datetimepicker")'></label>
		<input id='datetimepicker' type='text' ><br/>
		<label>Priority <input type='checkbox' onclick='toggleId("selPrio")'></label>
		<select id='selPrio'>
			<option value='1'>Very High</option>
			<option value='2'>High</option>
			<option value='3'>Kind of Important</option>
			<option value='4'>Low</option>
			<option value='5'>Very Low</option>
		</select>
		<button onclick='addTask()'>Add</button>
	</div>
</body>
</html>