<?php
var_dump($_POST);

function writeCSV($filename, $entries) {
$handle = fopen($filename, "w");
foreach ($entries as $entry) {
    fputcsv($handle, $entry);
}
fclose($handle);
}

$address_book = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
];

// $handle = fopen('address_book.csv', 'w');

// foreach ($address_book as $fields) {
//     fputcsv($handle, $fields);
// }

// fclose($handle);


$fileCSV = 'data/address_book.csv';

writeCSV($fileCSV, $address_book);

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
	writeCSV($fileCSV, $address_book);

};


?>
<!DOCTYPE>
<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<h2>Address Book:</h2>
	<table>
			<? foreach ($address_book as $entry) : ?>
		<tr>
			<? foreach ($entry as $item) : ?>
			<td> <?= $item; ?> </td>
			<? endforeach; ?>
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
	<h2>Add A New Address:</h2>
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