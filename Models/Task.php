<?php
	class Task{

		private $name;
		private $due_date;
		private $priority;
		private $status;
		private $id;

		public function __construct($task){
			$this->name = $task->name;
			$this->due_date = $task->due_date;
			$this->priority = $task->priority;
			$this->status = $task->status;
			$this->id = $task->id;
	    }

	    public function __toString(){
	    	return  '<tr><td>'.$this->name.
			        '</td><td>'.self::getPriorityString($this->priority).
			        '</td><td>'.((isset($this->due_date))?$this->due_date:'No due date').
			        '</td><td></td></tr>';
	    }


		/*

							STATIC FUNCTIONS

		*/

		public static function insert($taskName, $dueDate, $priority){
			require('db.php');
	        $sth = $db->prepare("INSERT INTO tasks (name, priority, due_date) VALUES (?, ?, ?)"); 
	        try { 
	            $db->beginTransaction(); 
	            $sth->execute(array($taskName,  $dueDate, $priority)); 
	            $sth = $db->prepare("SELECT  * FROM tasks WHERE name=? AND id=?");
	            $sth->execute( array($taskName,$db->lastInsertId()));
	            $new_row=$sth->fetch(PDO::FETCH_OBJ);
	            $db->commit(); 
	            return $new_row;

	        } catch(PDOExecption $e) { 
	            $db->rollback(); 
	            echo "Error!: " . $e->getMessage() . "</br>"; 
	        } 
		}

		public static function edit($task){
			require('db.php');
	        $sth = $db->prepare("UPDATE tasks  SET name =?, priority=?, due_date=?, status=? WHERE id=?"); 
	        try { 
	            $db->beginTransaction(); 
	            $sth->execute(array($task->name, $task->priority, $task->dueDate, $task->status, $task->id)); 

	            $sth = $db->prepare("SELECT  * FROM tasks WHERE name=? AND id=?");
	            $sth->execute( array($task->task, $db->lastInsertId())); 
	            $new_row=$sth->fetch(PDO::FETCH_OBJ);
	            $db->commit(); 
	            echo stringify($new_row);

	        } catch(PDOExecption $e) { 
	            $db->rollback(); 
	            echo "Error!: " . $e->getMessage() . "</br>"; 
	        }
		}

		public static function delete($id){
			require('db.php');
	        $sth = $db->prepare("DELETE FROM tasks WHERE id=?"); 
	        try { 
	            $db->beginTransaction(); 
	            $sth->execute($id); 
	            $count = $del->rowCount();
	            $db->commit();

	            if(isset($count) && !empty($count) && $count >0)
	            	echo 'Deleted';
	            else 
	            	echo 'Error while deleting';

	        } catch(PDOExecption $e) { 
	            $db->rollback(); 
	            echo "Error!: " . $e->getMessage() . "</br>"; 
	        }
		}
		public static function getPriorityString($priority){
			switch ($priority) {
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
		public static function stringify($task){
	    	return  '<tr><td>'.$task->name.
			        '</td><td>'.self::getPriorityString($task->priority).
			        '</td><td>'.((isset($task->due_date))?$task->due_date:'No due date').
			        '</td><td></td></tr>';
	    }

	}	
?>