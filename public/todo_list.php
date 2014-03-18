<?php
	require('todo_mysql.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title> Grace Faubion | ToDo List</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link href='http://fonts.googleapis.com/css?family=Belgrano' rel='stylesheet' type='text/css'>
	<style type="text/css">
		#error{
			color: red;
		}
		body{
			font-family: 'Belgrano', serif;
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
            <li><a href="#">National Parks</a></li>
            <!-- <li><a href="#"></a></li>
            <li class="divider"></li>
            <li><a href="#"></a></li> -->
          </ul>
        </li>
      </ul>
	  </div>
	</nav>
		<div class="col-md-6">
			<div class="page-header">
			  <h1>ToDo List!</h1>
			</div>
			<table class="table table-striped table-hover table-bordered ">
				<tr>
					<th>To Do List Items:</th>
				</tr>
				<?php while($row = $result->fetch_assoc()): ?>
				<tr>
					<td><?= $row['entry']; ?><br><br><a href="?remove=<?= $row['id']; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
				</tr>
	<? endwhile; ?>
			</table>
			<div>
				<ul class="pager">
				  <li><a href="#">Previous</a></li>
				  <li><a href="#">Next</a></li>
				</ul>
			</div>	
		</div>
		<div class="col-md-6">
			<div class="page-header">
			  <h1>Add A New Item!</h1>
			</div>
			<p id="error">
				<? if(!empty($error)) : ?>
					<?= $error; ?>
				<? endif; ?>

				<? if(!empty($errorMessage)) : ?>
					<?= $errorMessage; ?>
				<? endif; ?>
			</p>
			<form role="form" method="POST" enctype="multipart/form-data" action="todo_list.php">
				<div class="form-group">
					<label for="newItem"><strong>New Item:</strong></label>
					<input id="newItem" name="newItem" type="text">
					<br>
					<label for="file1"></label>
        			<input id="file1" name="file1" type="file">
				</div>	
    			<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>			
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
</html>