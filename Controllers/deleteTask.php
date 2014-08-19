<?php 
    $id = strip_tags($_POST['id']) ;
    if(!empty($id)){
		require('../Models/Task.php'); 
		Task::delete($id);
    }

?>