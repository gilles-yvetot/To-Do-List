<?php 
    $taskName = strip_tags($_POST['task']);
    $dueDate = strip_tags($_POST['dueOn']);
    $priority = strip_tags($_POST['prio']);

    require("../db.php");

    if(isset($taskName)){
        $sth = $db->prepare("INSERT INTO tasks (name, priority, due_date) VALUES (?, ?, ?)"); 

        try { 
            $db->beginTransaction(); 
            $sth->execute( array($taskName, $priority, ((isset($dueDate))?$dueDate:null)  )); 

            $sth = $db->prepare("SELECT  * FROM tasks WHERE name=? AND id=?");
            $sth->execute( array($taskName, $db->lastInsertId())); 
            $results=$sth->fetchAll(PDO::FETCH_OBJ);
            $db->commit(); 
            echo json_encode($results);


        } catch(PDOExecption $e) { 
            $db->rollback(); 
            echo "Error!: " . $e->getMessage() . "</br>"; 
        } 
    }

?>