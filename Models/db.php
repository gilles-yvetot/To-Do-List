<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_STRICT);

    $st = 'mysql:dbname=ToDoList;host=localhost';
	$user = 'CakeMailDude';
	$password = 'hireGilles';
    try {
	    $db = new PDO($st, $user, $password);
	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	}
?>