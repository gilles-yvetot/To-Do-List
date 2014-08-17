<?php 
    $taskName = strip_tags($_POST['task']);
    $dueDate = (empty($_POST['dueOn'])) ?  NULL: strip_tags($_POST['dueOn']);
    $priority = (empty($_POST['prio'])) ?  NULL: strip_tags($_POST['prio']) ;

    require("../db.php");
    require('../core.php'); 


    if(isset($taskName)){
        $sth = $db->prepare("INSERT INTO tasks (name, priority, due_date) VALUES (?, ?, ?)"); 

        try { 
            $db->beginTransaction(); 
            $sth->execute(array($taskName, $priority, $dueDate)); 

            $sth = $db->prepare("SELECT  * FROM tasks WHERE name=? AND id=?");
            $sth->execute( array($taskName, $db->lastInsertId())); 
            $new_row=$sth->fetch(PDO::FETCH_OBJ);
            $db->commit(); 
            echo stringify($new_row);

        } catch(PDOExecption $e) { 
            $db->rollback(); 
            echo "Error!: " . $e->getMessage() . "</br>"; 
        } 
    }

?>