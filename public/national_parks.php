<?php

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
	<script src="/js/jquery.js"></script>
	<style type="text/css">
		body{
			font-family: 'Belgrano', serif;
		}
		#error{
			color: red;
		}
		.invisible{
			display: none;
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
	<button class="btn btn-success toggle">Display Answers</button>
	<br>
	<br>
	<div class="col-md-12">
		<dl>
			<dt>What is the National Parks Conservation Association?</dt>
				<dd>We are an independent, nonpartisan voice working to address major threats facing the National Park System. NPCA was established in 1919, just three years after the National Park Service. Stephen Mather, the first director of the Park Service, was one of our founders. He felt very strongly that the national parks would need an independent voice—outside the political system—to ensure these places remained unimpaired for future generations. We have more than 800,000 members and supporters. In addition to our national headquarters in Washington, D.C., NPCA has 24 regional and field offices around the country. Our mission: to protect and enhance America’s National Park System for present and future generations.</dd>
				<br>
			<dt>What does NPCA do?</dt>
				<dd>NPCA works to address major threats facing the National Park System by gathering the information we need through our two centers, Center for Park Management and Center for Park Research, by keeping our eyes and ears to the ground in 11 regional and 12 field offices, and by developing relationships on Capitol Hill and in the administration to counter legislation or policies that would adversely affect the parks. We also pursue solutions in the courts when other avenues fail us.</dd>
				<br>
			<dt>How do I contact NPCA?</dt>
				<dd>Please feel free to email us at npca@npca.org, call us at 800.628.7275, or write to us at 777 6th St. NW, Suite 700, Washington, DC 20001.</dd>
				<br>
			<dt>How can I become a member? </dt>
				<dd>You can join NPCA online or by calling 800.628.7275 and asking for our member services department.</dd>
				<br>
			<dt>What are membership benefits? </dt>
				<dd>Our membership benefits include an award-winning quarterly magazine, National Parks; our exclusive travel information kit, which includes maps, a road atlas, park guides, and more; and discounts on NPCA publications and merchandise.</dd>
				<br>
			<dt>How do I renew or let you know about a change of address?</dt>
				<dd>We will send you renewal notices before your membership expires. You can return the renewal form with a check or credit card number, renew online, or call us at 800.628.7275.</dd>
				<br>
			<dt>How do I subscribe to National Parks magazine?</dt>
				<dd>For just $15, you can subscribe online or by calling our member services department at 800-628-7275.</dd>
				<br>
			<dt>What are national parks?</dt>
				<dd>The U.S. National Park System contains 401 units, which highlight and protect our natural, historic, and cultural treasures. The world's first national park, Yellowstone, was established in 1872. The National Park Service, the agency that oversees the park system, was created in 1916. Today, national parks cover more than 83 million acres and can be found in every state except Delaware, as well as the District of Columbia, American Samoa, Guam, Puerto Rico, and the Virgin Islands. The largest park is Wrangell-St. Elias National Park and Preserve which covers 13.2 million acres in Alaska. At .02 acres, Thaddeus Kosciuszko National Memorial in Pennsylvania is the smallest.</dd>
				<br>
			<dt>What problems do the national parks face?</dt>
				<dd>Although the National Park Service strives to safeguard our national parks, many of the 401 sites suffer from a variety of problems. Insufficient funding is the single greatest threat facing the parks. Some of the nation’s parks have some of the worst air in the country, even though our laws say they should have the cleanest. And, parks are such attractive places to live and work that commercial and other development threatens to overwhelm some of our most cherished lands with subdivisions and commercial development.</dd>
				<br>
			<dt>Can I purchase a National Parks Pass from NPCA?</dt>
				<dd>Due to changes in the National Parks Pass program, passes must now be purchased from participating federal agencies. Click here to purchase your parks pass from USGS.</dd>
				<br>
		</dl>
	</div> 
	<script type="text/javascript">
		$('dd').addClass('invisible');
		$('.toggle').on('click', function() {
			$('dd').toggleClass('invisible');
		})

	</script>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
</html>