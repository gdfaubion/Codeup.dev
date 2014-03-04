<?php
require_once('classes/filestore.php');

class InvalidInputException extends Exception{}

$readOrWrite = new fileStore('data/tododata.txt');

$archiveFile = new filestore("data/archives.txt");
$archives = $archiveFile->read();
$items = $readOrWrite->read();
// add items to list
if (isset($_POST['newItem'])) {
	try {
		if (strlen($_POST['newItem']) > 240) {
			throw new InvalidInputException("*Error New Item can't be more than 240 characters.");
		} elseif (empty($_POST['newItem'])) {
			throw new InvalidInputException("*You must enter a new item before hitting submit!");
		} else {
			array_push($items, $_POST['newItem']);
			$readOrWrite->write($items);
			header("Location: todo-list.php");
			exit;
		}
	} catch (InvalidInputException $e) {
		$errorCatch = $e->getMessage();
	}
}
// remove items from list
if (isset($_GET['remove'])) {
	$archiveItem = array_splice($items, $_GET['remove'], 1);
	$archives = array_merge($archives, $archiveItem);
	$archiveFile->write($archives);
	$readOrWrite->write($items);
	header("Location: todo-list.php");
	exit;
}

$errorMessage = '';
// upload file, if not empty and is text file
if (count($_FILES) > 0 && empty($_POST['newItem'])) {
	if($_FILES['file1']['error'] != 0) {
		$errorMessage = 'Error Uploading File!!';
	} elseif ($_FILES['file1']['type'] != 'text/plain') {
		$errorMessage = 'ERROR!! Invalid File!';
	} else {
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$uploadedList = new Filestore($saved_filename);
		$fileContents =$uploadedList->read();
	
		if ($_POST['file2'] == TRUE) {
			$items = $fileContents;
		} else {
			$items = array_merge($items, $fileContents);
		}

		$readOrWrite->write($items);		
		header("Location: todo-list.php");
		exit;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>TODO List</title>
</head>
<body>

	<h2>TO-DO List</h2>
		<ul>
			<? foreach ($items as $key => $item): ?>
				<li><?= htmlspecialchars(strip_tags($item)); ?> <a href="?remove=<?= $key; ?>">To-Done! </a></li>
			<? endforeach; ?>
		</ul>
		<hr>
		<h2>Add Items to the To-Do List:</h2>
		<form method="POST" enctype="multipart/form-data" action="todo-list.php">
			<p>
				<label for="newItem"><strong>New Item:</strong></label>
				<input id="newItem" name="newItem" type="text" autofocus="autofocus">
			</p>
			<p>
				<? if(!empty($errorCatch)) : ?>
				<?= $errorCatch; ?>
				<? endif; ?>
			</p>
			<p>
				<button type="submit">Submit</button>
			</p>
		<form method="POST" enctype="multipart/form-data" action="todo-list.php">
			<p>
				<? if (!empty($errorMessage)) : ?>
				<?= $errorMessage; ?>
				<? endif; ?>
			</p>
			<p>
        		<label for="file1"><strong>Upload a file to add to your list:</strong></label>
        		<input id="file1" name="file1" type="file">
    		</p>
    		<p>
    			<label for='file2'>Replace to do all To-Do items?</label>
    			<input id='file2' name='file2' type='checkbox'>
    		</p>
			<button type="submit">Upload</button>
		</form>

</body>
</html>