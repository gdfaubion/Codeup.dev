<?php
// read from txt file, return array
function read_file($file) {
    $handle = fopen($file, "r");
   	$contents = fread($handle, filesize($file));
    fclose($handle);
    return explode("\n", $contents); 	
}

// save to array txt file
function save_file($file, $item) {
    $handle = fopen($file, 'w');
    $itemstr = implode("\n", $item);
    fwrite($handle, $itemstr);
    fclose($handle);
}

// set file location
$file = "data/tododata.txt";
$archiveFile = "data/archives.txt";
$archives = read_file($archiveFile);
// check that file is not empty
$items = (filesize($file) > 0) ? read_file($file) : array();

// add items to list
if (!empty($_POST['newItem'])) {
	array_push($items, $_POST['newItem']);
	save_file($file, $items);
	header("Location: todo-list.php");
	exit;
}

// remove items from list
if (isset($_GET['remove'])) {
	$archiveItem = array_splice($items, $_GET['remove'], 1);
	$archives = array_merge($archives, $archiveItem);
	save_file($archiveFile, $archives);
	save_file($file, $items);
	header("Location: todo-list.php");
	exit;
}

$errorMessage = '';
// upload file, if not empty and is text file
if (count($_FILES) > 0) {
	if($_FILES['file1']['error'] != 0) {
		$errorMessage = 'Error Uploading File!!';
	} elseif ($_FILES['file1']['type'] != 'text/plain') {
		$errorMessage = 'ERROR!! Invalid File!';
	} else {
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['file1']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
		$fileContents = read_file($saved_filename);
	
		if ($_POST['file2'] == TRUE) {
			$items = $fileContents;
		} else {
			$items = array_merge($items, $fileContents);
		}

		save_file($file, $items);		
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
				<? if (!empty($errorMessage)) : ?>
				<?= $errorMessage; ?>
				<? endif; ?>
			</p>
			<p>
        		<label for="file1"><strong>Upload a file to add to your list:</strong></label>
        		<input id="file1" name="file1" type="file">
    		</p>
    		<p>
        		<label for="file2">Replace To-Do list items with contents of this file? </label>
        		<input id="file2" name="file2" type="checkbox">
    		</p>

			<button type="submit">Submit</button>
		</form>

</body>
</html>