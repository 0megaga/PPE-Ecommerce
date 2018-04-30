	<!-- Header -->
	<?php $this->view('Include/header1'); ?>

	<!--<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
					<div class="leftbar p-r-20 p-r-0-sm">
					</div>
				</div>

				<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
				</div>
			</div>
		</div>
	</section>-->

	<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<h2>List of users</h2>	
				<table class="table table-bordered table-striped table-hover" id="usersTable">
					<thead>
						<tr>
							<th>avatar</th>
							<th>rank</th>
							<th>username</th>
							<th>email</th>
							<th>gender</th>
							<th>phone</th>
							<th>created_date</th>
							<th>action</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="row">
				<h2>List of items</h2>
				<table class="table table-bordered table-striped table-hover" id="productsTable">
					<thead>
						<tr>
							<th>Name</th>
							<th>quantities</th>
							<th>price</th>
							<th>description</th>
							<th>tags</th>
							<th>category</th>
							<th>vendeur</th>
							<th>state</th>
							<th>action</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="row">
				<h2>List of categories</h2>
				<table class="table table-bordered table-striped table-hover" id="categoriesTable">
					<!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#categoryModal">add categorie</button>-->
					<thead>
						<tr>
							<th>name</th>
							<th>action</th>
						</tr>
					</thead>
				</table>
			</div>			
		</div>
	</section>
	


	<?php
	$this->view('Include/footer');
	$this->view('Include/back_to_top');
	?>

	<!-- Container Selection -->
	<div id="dropDownSelect1"></div>
	<div id="dropDownSelect2"></div>