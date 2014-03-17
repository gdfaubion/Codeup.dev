<?php
	class InvalidInputException extends Exception {}

	$mysqli = new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_mysqli_test_db');

	// Check for errors
	if ($mysqli->connect_error) {
	    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}
	if(!empty($_POST)) {

		if(empty($_POST['name']) || empty($_POST['location']) || empty($_POST['description']) || empty($_POST['date']) || empty($_POST['area'])) {
			$error = ("*ERROR All Fields are Required!");

		} elseif(!empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['description']) && !empty($_POST['date']) && !empty($_POST['area']) ) {
			// Create the prepared statement
			$stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, description, date_established, area_in_acres) VALUES (?, ?, ?, ?, ?)");

			// bind parameters
			$stmt->bind_param("ssssd", $_POST['name'], $_POST['location'], $_POST['description'], $_POST['date'], $_POST['area']);

			// execute query, return result
			$stmt->execute();
		}
	}
	if (!empty($_GET)) {
		$result = $mysqli->query("SELECT * FROM national_parks ORDER BY {$_GET['sort_col']} {$_GET['sort_order']} ");
	} else {
		$result = $mysqli->query("SELECT * FROM national_parks");
	}
	
	$mysqli->close();
?>
<html>
<head>
	<title>National Parks</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/portfolio.css">
	<link href='http://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet' type='text/css'>
	<style type="text/css">
		body{
			font-family: 'Belgrano', serif;
		}
		#error{
			color: red;
		}
	</style>	
</head>
<body>
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
	  <div class="container">
	  	  <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">| Grace Faubion |</a>
	    </div>
	      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class=""><a href="http://codeup.dev/resume.html">Resume</a></li>
        <li><a class="nav-text" href="http://codeup.dev/portfolio.html">Portfolio</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Address Book</a></li>
            <li><a href="#">To-Do List</a></li>
            <li><a href="#">Blackjack</a></li>
            <li><a href="">National Parks</a></li>
            <!-- <li><a href="#"></a></li>
            <li class="divider"></li>
            <li><a href="#"></a></li> -->
          </ul>
        </li>
      </ul>
	  </div>
	</nav>
		<div class="page-header">
		  <h1>National Parks</h1>
		</div>
	<div class="container-fluid projects">
		<div class="col-md-8">
		<table class="table table-striped table-hover table-bordered ">
		    <tr>
		      <th>
		      	 Name
		      	 <br>
		      	<a href="?sort_col=name&amp;sort_order=asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
		      	<a href="?sort_col=name&amp;sort_order=desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
		      </th>
		      <th>
		      	Location
		      	<a href="?sort_col=location&amp;sort_order=asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
		      	<a href="?sort_col=location&amp;sort_order=desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
		      </th>
		      <th>
		        Description
		      </th>
		      <th>
		      	Date
		      	<a href="?sort_col=date_established&amp;sort_order=asc"><span class="glyphicon glyphicon-arrow-up"></span></a>
		      	<a href="?sort_col=date_established&amp;sort_order=desc"><span class="glyphicon glyphicon-arrow-down"></span></a>
		      </th>
		      <th>
		      	Area
		      </th>
		    </tr>
				<?php while ($row = $result->fetch_assoc()): ?>
		 		<tr>
			  			<td> <?= $row['name']; ?></td>
			  			<td> <?= $row['location']; ?> </td>
			  			<td> <?= $row['description']; ?> </td>
			  			<td> <?= $row['date_established']; ?> </td>
			  			<td> <?= $row['area_in_acres']; ?> </td>
		  		</tr>
				<? endwhile; ?>
		</table>
		</div>
		<div class="col-md-4">
			<div class="page-header">
			  <h3>Add A New National Park</h3>
			</div>
			<p id="error">
				<? if(!empty($error)) : ?>
				<?= $error; ?>
				<? endif; ?>
			</p>
			<form role="form" method="POST" enctype="multipart/form-data" action="national_parks.php">
			  <div class="form-group">
			    <label for="name">Name of Park*</label>
			    <input type="text" class="form-control" name="name" id="name" placeholder="Park Name">
			  </div>
			  <div class="form-group">
			    <label for="location">Location*</label>
			    <input type="text" class="form-control" name="location" id="location" placeholder="Location">
			  </div>
			 <div class="form-group">
			 	<label for="description">Description*</label>
			 	<textarea type="text" name="description" id="description" placeholder="Enter Description Here" class="form-control" rows="3"></textarea>
			 </div>
			 <div class="form-group">
			    <label for="date">Date Established*</label>
			    <input type="date" class="form-control" name="date" id="date">
			  </div>
			  <div class="form-group">
			    <label for="area">Area in Acres*</label>
			    <input type="number" step="any" min="0" class="form-control" name="area" id="area" placeholder="Area">
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
			<br>
			<img src="/img/parks.jpg">
			<br>
			<p>*All information used was taken from <a href="http://en.wikipedia.org/wiki/List_of_national_parks_of_the_United_States">Wikipedia</a>.</p>
		</div>
	</div> 
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
</html>