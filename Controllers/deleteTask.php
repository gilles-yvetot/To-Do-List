<?php 
    $taskName = strip_tags($_POST['task']);
    $dueDate = (empty($_POST['dueOn'])) ?  NULL: strip_tags($_POST['dueOn']);
    $priority = (empty($_POST['prio'])) ?  NULL: strip_tags($_POST['prio']) ;

    require('../Models/Task.php'); 

    if(isset($taskName)){
        $newRow = Task::insert($taskName, $dueDate, $priority);
        $task = new Task($newRow);
        echo $task->__toString();
    }

?>