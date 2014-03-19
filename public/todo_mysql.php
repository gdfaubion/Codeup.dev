<?php

	$error = null;
	$successMessage = null;
	$limit = 3;

	$mysqli = new mysqli('127.0.0.1', 'codeup', 'password', 'todo_list');

	if ($mysqli->connect_error) {
	    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	if(!empty($_POST['newItem'])) {
		if(isset($_POST['newItem'])){
			if(strlen($_POST['newItem']) > 240){
				$error = ("*New Item Can't be more than 240 Characters!");
			}else {
				$stmt = $mysqli->prepare("INSERT INTO todo_entrys (entry) VALUES (?)");
				$stmt->bind_param("s", $_POST['newItem']);
				$stmt->execute();
				$successMessage = "Todo item was added successfully.";
			}
		}	
	}

	if (isset($_POST['remove'])) {
    	$stmt = $mysqli->prepare("DELETE FROM todo_entrys WHERE id = ?");   
    	$stmt->bind_param("s", $_POST['remove']);
    	$stmt->execute();
     	header("Location: todo_list_db.php");
    	exit;
	}

	$result = $mysqli->query('SELECT * FROM todo_entrys');

	$num_rows = $result->num_rows;

	$num_pages = ceil($num_rows / $limit);

	$result->close();

	if(!empty($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	if($page > 1) {
		$offset = ($_GET['page'] * $limit) - $limit;
	} else {
		$offset = 0;
	}

	$stmt = $mysqli->prepare("SELECT * FROM todo_entrys LIMIT ? OFFSET ?");

	$stmt->bind_param("ii", $limit, $offset);

	$stmt->execute();

	$stmt->bind_result($id, $entry);

	$rows = array();
	
	while($stmt->fetch()) {
		$rows[] = array('id' => $id, 'entry' => $entry);
	}

	$mysqli->close();
?>