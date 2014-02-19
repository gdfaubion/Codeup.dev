<?php
echo "<p>POST:</p>";
var_dump($_POST);

echo "<p>GET:</p>";
var_dump($_GET);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Todo List</title>
	</head>
	<body>
		<h1>TODO List:</h1>
		<ul>
			<li>Wash the car</li>
			<li>Feed the dog</li>
			<li>Take out the trash</li>
		</ul>
		<hr>
		<h2>Add items to the todo list</h2>
		<form method="GET" action="">
			<p>
				<label for="Item">Item:</label>
				<input type="text" id="item" name="item" placeholder="Enter New Item">
			</p>
			<p>
				<button type="Confirm">Confirm</button>
			</p>
		</form>
	</body>





























</html>