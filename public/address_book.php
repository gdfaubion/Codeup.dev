<?php
class addressDataStore {

	public $filename = '';

	function readCSV()
	{
		$address_book = [];
		$handle = fopen($this->filename, "r");
		while(!feof($handle)) {
		$line = fgetcsv($handle);
		if(!empty($line)) {
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

//new instance of addressDataStore
$contacts = new addressDataStore();

//set the $filename var
$contacts->filename = 'data/address_book.csv';

//output $address list
$address_book = $contacts->readCSV();

$errorMessage = [];

if(!empty($_POST)) {
	$entry = [
		$_POST['name'],
		$_POST['address'],
		$_POST['city'],
		$_POST['state'],
		$_POST['zip'],
		$_POST['phone']
		];
	if(empty($_POST['name'])) {
		array_push($errorMessage, "!!NAME IS REQUIRED!!");
		}
	if(empty($_POST['address'])) {
		array_push($errorMessage, "!!ADDRESS IS REQUIRED!!");
		}
	if(empty($_POST['city'])) {
		array_push($errorMessage, "!!CITY IS REQUIRED!!");
		}
	if(empty($_POST['state'])) {
		array_push($errorMessage, "!!STATE IS REQUIRED!!");
		}
	if(empty($_POST['zip'])) {
		array_push($errorMessage, "!!ZIP CODE IS REQUIRED!!");
		}
	if(empty($_POST['phone'])) {
		array_push($errorMessage, "!!PHONE NUMBER IS REQUIRED!!");
		}

	array_push($address_book, $entry);
	$contacts->writeCSV($address_book);

};
if(isset($_GET['remove'])) {
	$remove_item = array_splice($address_book, $_GET['remove'], 1);
	$contacts->writeCSV($address_book);
	header("Location: address_book.php");
	exit(0);
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
	<form method ="POST" action="address_book.php" >
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
	</form>
</body>
</html>