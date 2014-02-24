<?php
var_dump($_GET);
var_dump($_POST);

$file = "data/tododata.txt";

function read_file() {
	$file = "data/tododata.txt";
    $handle = fopen($file, "r");
    $setfile = filesize($file);
    if($setfile > 0) {
    $contents = fread($handle, filesize($file));
    fclose($handle);
    return explode("\n", $contents);
   } else {
   	echo "Your dont have any items in your list";
   	return array();
   }  
}

$items = read_file($file);


function saveFile($file, $item) {
	$itemstr = implode("\n", $item);
	$handle = fopen($file, 'w');
	fwrite($handle, $itemstr);
	fclose($handle);
}

if(isset($_POST["item"])) {
	$newitem = $_POST["item"];
	array_push($items, $newitem);
	saveFile($file, $items);

}



if(isset($_GET["remove"])) {
	$key = $_GET["remove"];
	unset($items[$key]);
	saveFile($file, $items);

	header("Location: todo-list.php");
	exit;

}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>TODO List</title>
	</head>
	<body>
		<h1>TO-DO List:</h1>
		<ul>
			<?php foreach($items as $key => $item) { ?>
			<li> <?php echo $item; ?> <a href="?remove=<?php echo $key; ?>"> Completed </a> </li>
				<?php } ?>
		</ul>
		<hr>
		<h2>Add Items to the TO-DO List</h2>
		<form method="POST" action="todo-list.php">
			<p>
				<label for="item"><strong>Item:</strong></label>
				<input type="text" id="item" name="item" placeholder="Enter New Item">
			</p>
			<p>
				<button type="Confirm">Confirm</button>
			</p>
		</form>
	</body>





























</html>