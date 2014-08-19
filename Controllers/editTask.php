<?php 
    $taskName = strip_tags($_POST['task']);
    $dueDate = (empty($_POST['dueDate'])) ?  NULL: strip_tags($_POST['dueDate']);
    $priority = (empty($_POST['prio'])) ?  NULL: strip_tags($_POST['prio']) ;
    $status = (empty($_POST['status'])) ?  NULL: strip_tags($_POST['status']) ;
    $id = strip_tags($_POST['id']) ;

    if(!empty($id)){
		require('../Models/Task.php'); 

		if(isset($taskName)){
			$newRow = Task::edit($taskName, $priority, $dueDate, $status, $id);
			echo Task::stringify($newRow);
		}
    }
?>