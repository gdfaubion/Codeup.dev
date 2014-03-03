<?php

require_once('classes/address_data_store.php');

$contacts = new addressDataStore('data/address_book.csv');

$address_book = $contacts->read_address_book();

$errorMessage = [];
try {
if(!empty($_POST))
{
	if(isset($_POST['file2']) && $_POST['file2'] != 'on')
	{
		break 2;
	}
	$entry = [];
	$entry['Name'] = $_POST['name'];
	$entry['Address'] = $_POST['address'];
	$entry['City'] = $_POST['city'];
	$entry['State'] = $_POST['state'];
	$entry['Zip'] = $_POST['zip'];
	foreach($entry as $key => $value)
	{
		if(empty($value))
		{
			array_push($errorMessage, "!! " . strtoupper($key) . " IS REQUIRED !!");
		}
		if(strlen($value) > 125) 
		{
			throw new Exception(" *$key can't be more than 125 characters.");
			
		}
	}

	$entry['phone'] = $_POST['phone'];

	if(empty($errorMessage))
	{
		array_push($address_book, $entry);
		$contacts->write_address_book($address_book);
	}	
}
if(isset($_GET['remove'])) 
{
	$remove_item = array_splice($address_book, $_GET['remove'], 1);
	$contacts->write_address_book($address_book);
	header("Location: address_book.php");
	exit(0);
}
} catch (Exception $e) {
	$errorCatch = $e->getMessage();
}

$errorMessageUpload = '';

if(count($_FILES) > 0)
{
	if($_FILES['file']['error'] !== 0) 
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
		$contactsUpload = new addressDataStore($saved_filename);
		$addressBookUpload = $contactsUpload->read_address_book();
			if(isset($_POST['file2']) && $_POST['file2'] == 'on')
			{
				$address_book = $addressBookUpload;
			}else
			{
				$address_book = array_merge($address_book, $addressBookUpload);
			}
		
		$contacts->write_address_book($address_book);
	}

}

?>
<!DOCTYPE>
<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<h2>Contacts:</h2>
	<table>
		<th><strong>Name:</strong></th>
		<th><strong>Address:</strong></th>
		<th><strong>City:</strong></th>
		<th><strong>State:</strong></th>
		<th><strong>zip:</strong></th>
		<th><strong>Phone:</strong></th>
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
	<p>*Required Fields</p>
	<P>
		<?if (!empty($errorCatch)) : ?>
		<?= $errorCatch; ?>
		<? endif; ?>
	</P>
	<form method ="POST" enctype="multipart/form-data" action="address_book.php" >
			<p>
				<label for="name"><strong>*Name:</strong></label>
				<input id="name" name="name" type="text">
			</p>
			<p>
				<label for="address"><strong>*Address:</strong></label>
				<input id="address" name="address" type="text">
			</p>
			<p>
				<label for="city"><strong>*City:</strong></label>
				<input id="city" name="city" type="text">
			</p>
			<p>
				<label for="state"><strong>*State:</strong></label>
				<input id="state" name="state" type="text">
			</p>
			<p>
				<label for="zip"><strong>*Zip Code:</strong></label>
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
				<label for="file">Upload Contacts from CSV File</label>
				<input type="file" id="file" name="file">
			</p>
			<p>
				<label for="file2">Replace All Contacts?</label>
				<input id="file2" name="file2" type="checkbox">
			</p>
			<p>
				<input type="submit" value="upload">
			</p>
	</form>
</body>
</html>