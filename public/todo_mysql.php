<?php
	
	require_once('classes/filestore.php');	

	$mysqli = new mysqli('127.0.0.1', 'codeup', 'password', 'todo_list');

	if ($mysqli->connect_error) {
	    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	if(!empty($_POST['newItem'])) {
		if(strlen($_POST['newItem']) > 240){
			$error = ("*New Item Can't be more than 240 Characters!");
		}else {
			$stmt = $mysqli->prepare("INSERT INTO todo_entrys (entry) VALUES (?)");
			$stmt->bind_param("s", $_POST['newItem']);
			$stmt->execute();
		}	
	}

	if (isset($_GET['remove'])) {
    	$stmt = $mysqli->prepare("DELETE FROM todo_entrys WHERE id = ?");   
    	$stmt->bind_param("s", $_GET['remove']);
    	$stmt->execute();
     	header("Location: todo_list.php");
    	exit;
	}

	$errorMessage = '';

	if (count($_FILES) > 0) {
		if($_FILES['file1']['error'] != 0) {
			$errorMessage = 'Error!! Could not process request!';
		} elseif ($_FILES['file1']['type'] != 'text/plain') {
			$errorMessage = 'ERROR!! Invalid File!';
		} else {
			$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
			$filename = basename($_FILES['file1']['name']);
			$saved_filename = $upload_dir . $filename;
			move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
			$uploadedList = new Filestore($saved_filename);
			$fileContents =$uploadedList->read();
			//iterate through file array and insert into db
			foreach ($fileContents as $key => $value) {
		    	$stmt = $mysqli->prepare("INSERT INTO todo_entrys (entry) VALUES (?)");
		    	$stmt->bind_param("s", $value);
		    	$stmt->execute();
		    }	
			
		}
	}
	// query for paignation
	//Not sure where to go from here
	// $query = ("SELECT entry FROM todo_entrys LIMIT 10");

	$result = $mysqli->query("SELECT * FROM todo_entrys");

	$mysqli->close();
?>