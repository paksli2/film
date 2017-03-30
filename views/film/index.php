<?php include ROOT.'/views/layouts/header_add.php'; ?>
		<main>
			<div class="container-fluid main">
				<div class="col-md-12 header_panel">
					<div class="row">
						<div class="col-md-5">
							<h2>Information about <?php echo $film['title']; ?>:</h2>
						</div>
						<div class="col-md-2">

						</div>
						<div class="col-md-5">

						</div>
					</div>
				</div>
				<div class="col-md-12">
					<ul class="list-group">
					  <li class="list-group-item"><b>ID:</b> <?php echo $film['id'];?></li>
					  <li class="list-group-item"><b>Title:</b> <?php echo $film['title']; ?></li>
					  <li class="list-group-item"><b>Year of issue:</b> <?php echo $film['year']; ?></li>
					  <li class="list-group-item"><b>Format:</b> <?php echo $film['format']; ?></li>
					  <li class="list-group-item">
					  	<b>Cast:</b><br>
					  	<ul>
					  		<?php foreach($actors as $actor){ ?>
					  			<li><?php echo $actor; ?></li>
					  		<?php } ?>
					  	</ul>
					  </li>
					</ul>
				</div>
			</div>
		</main>
<?php include ROOT.'/views/layouts/footer.php'; ?>