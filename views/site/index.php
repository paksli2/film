<?php include ROOT.'/views/layouts/header.php'; ?>
		<main>
			<div class="container-fluid main">
				<div class="col-md-12 header_panel">
					<div class="row">
						<div class="col-md-2">
							<h2>List of films:</h2>
						</div>
						<div class="col-md-5"> 
							<a href="/film/add" class = "btn btn-success but">Add film</a>
						</div>
						<div class="col-md-5">
							<b>Cортировать в алф порядке:</b><br>
							<form class="navbar-form navbar-left" id = "sort" action="" method="post">
						      <div class="input-group">
						        <div class="input-group-btn">
						        	
						          <select class="form-control" id="sel2" name="sort">
								    <option value="ASC">По возростанию</option>
								    <option value="DESC">По убыванию</option>
								  </select>
						          <button class="btn btn-default" type="submit">
						            Submit
						          </button>
						        </div>
						      </div>
						    </form>
						</div>
						<div class="col-md-12 error">
							<?php
								if(isset($_SESSION['info'])){
									$info = $_SESSION['info'];
									unset($_SESSION['info']);
									echo $info;
								}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-12 filmContainer">
					<?php foreach($films as $film){ ?>
						<div class="col-md-12 film">
							<div class="row">
								<div class="col-md-1 film_id"><?php echo $film['id']; ?></div>
								<div class="col-md-10 film_name"><a href = "/film/<?php echo $film['id']; ?>"><?php echo $film['title']; ?></a></div>
								<div class="col-md-1 remove"><a href="/film/delete/<?php echo $film['id']; ?>"><span class="glyphicon glyphicon-remove-sign" title="remove"></span></a></div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</main>
<?php include ROOT.'/views/layouts/footer.php'; ?>