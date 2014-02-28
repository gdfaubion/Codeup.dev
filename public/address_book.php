<?php
class addressDataStore {

	public $filename = '';

	function __construct($filename = 'data/address_book.csv') 
	{
		$this->filename = $filename;

	}

	function readCSV()
	{
		$address_book = [];
		$handle = fopen($this->filename, "r");
		while(!feof($handle)) {
		$line = fgetcsv($handle);
		if(!empty($line)) 
		{
	  		$address_book[] = $line;
			}
		}
		fclose($handle);
		return $address_book;

	}

	function writeCSV($entries)
	{
		$handle = fopen($this->filename, "w");

		foreach ($entries as $entry) 
		{
			fputcsv($handle, $entry);
		}

		fclose($handle);

	}

}

$contacts = new addressDataStore();

$address_book = $contacts->readCSV();

$errorMessage = [];

if(!empty($_POST))
{
	$entry = [];
	$entry['name'] = $_POST['name'];
	$entry['address'] = $_POST['address'];
	$entry['city'] = $_POST['city'];
	$entry['state'] = $_POST['state'];
	$entry['zip'] = $_POST['zip'];

	foreach($entry as $key => $value)
	{
		if(empty($value))
		{
			array_push($errorMessage, "!! " . strtoupper($key) . " IS REQUIRED !!");
		}
	};

	array_push($address_book, $entry);
	$contacts->writeCSV($address_book);
};
if(isset($_GET['remove'])) 
{
	$remove_item = array_splice($address_book, $_GET['remove'], 1);
	$contacts->writeCSV($address_book);
	header("Location: address_book.php");
	exit(0);
}

$errorMessageUpload = '';

if(count($_FILES) > 0)
{
	if($_FILES['file']['error'] != 0) 
	{
		$errorMessageUpload = 'Error Uploading File!!';

	}
	elseif($_FILES['file']['type'] != 'text/csv')
	{
		$errorMessageUpload = 'Invalid File Type';
	}
	else
	{
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['file']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['file']['tmp_name'], $saved_filename);
		$fileContents = $contacts->readCSV($saved_filename);
		$address_book = array_merge($address_book, $fileContents);
		$contacts->writeCSV($address_book);
	}

}

?>
<!DOCTYPE>
<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<h2>Address Book:</h2>
	<table>
			<? foreach ($address_book as $key => $entry) : ?>
		<tr>
			<? foreach ($entry as $item) : ?>
			<td><?= htmlspecialchars(strip_tags($item)); ?></td>
			<? endforeach; ?>
			<td><a href="?remove=<?= $key; ?>"> Delete Entry </a></td>
		</tr>
			<? endforeach; ?>
			
	</table>
	<ul>
		<? if(!empty($errorMessage)) : ?>
		<? foreach($errorMessage as $error) : ?>
			<strong><em><li><?= $error; ?></li></em></strong>
		<? endforeach; ?>
		<? endif; ?>
	</ul>
	<hr>
	<hr>
	<h2>Add A New Contact:</h2>
	<form method ="POST" enctype="multipart/form-data" action="address_book.php" >
			<p>
				<label for="name"><strong>Name:</strong></label>
				<input id="name" name="name" type="text" autofocus>
			</p>
			<p>
				<label for="address"><strong>Address:</strong></label>
				<input id="address" name="address" type="text">
			</p>
			<p>
				<label for="city"><strong>City:</strong></label>
				<input id="city" name="city" type="text">
			</p>
			<p>
				<label for="state"><strong>State:</strong></label>
				<input id="state" name="state" type="text">
			</p>
			<p>
				<label for="zip"><strong>Zip Code:</strong></label>
				<input id="zip" name="zip" type="text">
			</p>
			<p>
				<label for="phone"><strong>Phone Number:</strong></label>
				<input id="phone" name="phone" type="text">
			</p>

			<p>
				<button type="submit">Submit</button>
			</p>
			<p>
				<label for="file">Upload Address File</label>
				<input type="file" id="file" name="file">
			</p>
			<p>
				<input type="submit" value="upload">
			</p>
	</form>
</body>
</html>