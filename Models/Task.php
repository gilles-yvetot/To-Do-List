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
	    	return  '<tr> <td>'.$this->name.
				        '</td><td>'.self::getPriorityString($this->priority).
				        '</td><td>'.((isset($this->due_date))?$this->due_date:'No due date').
				        '</td><td><i class="fa fa-edit" title="Edit" onclick="editTask(event,'.$this->id.')"></i>'
				        		.'<i class="fa fa-trash-o" title="Delete" onclick="deleteTask(event,'.$this->id.')"></i>'
				        		.(($this->status != 'Done')?
				        			'<i title="Mark as done" class="fa fa-check-square-o" onclick="markAsDone(event,'.$this->id.')"></i>'
				        			:'<i title="Mark as not done" class="fa fa-check-square" onclick="markAsNotDone(event,'.$this->id.')"></i>'
				        		).'</td></tr>';
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

		public static function edit($taskName, $priority, $dueDate, $status, $id){
			require('db.php');
			// we can update the row or marked it as done so we need to test if the status is defined
			$qu = (isset($status) && !empty($status))?
					 " UPDATE tasks  SET status=? WHERE id=?"
				   : " UPDATE tasks  SET name =?, priority=?, due_date=? WHERE id=?";
			$params = array();
			if (isset($status) && !empty($status))
				array_push($params, $status,$id);
			else
				array_push($params, $taskName, $priority, $dueDate ,$id);

	        $sth = $db->prepare($qu); 
	        try { 
	            $db->beginTransaction(); 
	            $sth->execute($params); 
	            
	            $sth = $db->prepare("SELECT  * FROM tasks WHERE id=?");
	            $sth->execute(array($id)); 
	            $new_row=$sth->fetch(PDO::FETCH_OBJ);
	            $db->commit(); 
	            return $new_row;

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
	            $sth->execute(array($id)); 
	            $count = $sth->rowCount();
	            $db->commit();

	            if(isset($count) && !empty($count) && $count >0)
	            	echo 'DELETED';
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
	    	return  '<tr> <td>'.$task->name.
				        '</td><td>'.self::getPriorityString($task->priority).
				        '</td><td>'.((isset($task->due_date))?$task->due_date:'No due date').
				        '</td><td><i class="fa fa-edit" title="Edit" onclick="editTask(event,'.$task->id.')"></i>'
				        		.'<i class="fa fa-trash-o" title="Delete" onclick="deleteTask(event,'.$task->id.')"></i>'
				        		.(($task->status != 'Done')?
				        			'<i title="Mark as done" class="fa fa-check-square-o" onclick="markAsDone(event,'.$task->id.')"></i>'
				        			:'<i title="Mark as not done" class="fa fa-check-square" onclick="markAsNotDone(event,'.$task->id.')"></i>'
				        		).'</td></tr>';
	    }

	}	
?>




