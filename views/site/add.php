<?php include ROOT.'/views/layouts/header_add.php'; ?>
		<main>
			<div class="container-fluid main">
				<div class="col-md-12 header_panel">
					<div class="row">
						<div class="col-md-2">
							<h2>Add new film:</h2>
						</div>
						<div class="col-md-5">

						</div>
						<div class="col-md-5">

						</div>
					</div>
				</div>
				<div class="col-md-12">
					<form action="" method="post">
					  <div class="form-group">
					    <label for="title">Movie title:</label>
					    <input type="text" class="form-control" id="title" name = "title">
					  </div>
					  <div class="form-group">
					    <label for="year">Year of issue:</label>
					    <input type="text" class="form-control" id="year" name = "year">
					  </div>
					  <div class="form-group">
					    <label for="format">Format:</label>
					    <input type="text" class="form-control" id="format" name = "format">
					  </div>
					  <div class="form-group">
					    <label for="cast">Cast (write the cast using commas):</label>
					    <textarea class="form-control" rows="5" id="cast" name = "cast"></textarea>
				      </div>
					  <input type="submit" class="btn btn-success" name = "submit" value = "Add">
					</form>
				</div>
			</div>
		</main>
<?php include ROOT.'/views/layouts/footer.php'; ?>