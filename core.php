<?php
function getPriority($i){
	switch ($i) {
		case 1:
			return 'Very High';
			break;
		case 2:
			return 'High';
			break;
		case 4:
			return 'Low';
			break;
		case 5:
			return 'Very Low';
			break;
		
		default:
			return 'Kind of Important';
			break;
	}
}

function stringify($task){
	return  '<tr><td>'.$task->name.
	        '</td><td>'.getPriority($task->priority).
	        '</td><td>'.((isset($task->due_date))?$task->due_date:'No due date').
	        '</td><td></td></tr>';
}
?>