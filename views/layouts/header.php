<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Storage for film</title>
		<link rel="stylesheet" type="text/css" href="./template/css/myStyle.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
	</head>
	<body>
		<header>
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
			    <div class="navbar-header">
			      <a class="navbar-brand" href="/film/">Storage for film</a>
			    </div>
<!-- 			    <ul class="nav navbar-nav">
			      <li class="active"><a href="#">Home</a></li>
			      <li><a href="#">Page 1</a></li>
			      <li><a href="#">Page 2</a></li>
			    </ul> -->
			    <form class="navbar-form navbar-left" id = "search_form" action="" method="post">
			      <div class="input-group">
			        <input type="text" class="form-control" placeholder="Search" name="key">
			        <div class="input-group-btn">
			          <select class="form-control" id="sel1" name="search_word">
					    <option value="title">По названию фильма</option>
					    <option value="name">По имени актера</option>
					  </select>
			          <button class="btn btn-default" type="submit">
			            <i class="glyphicon glyphicon-search"></i>
			          </button>
			        </div>
			      </div>
			    </form>
			  </div>
			</nav>
		</header>