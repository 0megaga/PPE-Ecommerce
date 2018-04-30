	<?php 
	$this->view('Include/header1');
	?>

	<!-- Product Detail -->
	<div class="container bgwhite p-t-35 p-b-80">
		<?php if ( isset( $_SESSION['success_msg'] ) ) { ?>
					<div class="alert alert-success"><?= $_SESSION['success_msg'] ?></div>
				<?php } elseif ( isset( $_SESSION['error_msg'] ) ) { ?>
					<div class="alert alert-danger"><?= $_SESSION['error_msg'] ?></div>
				<?php } ?>
	</div>




	<?php $this->view('Include/footer');
	$this->view('Include/back_to_top'); ?>

	<!-- Container Selection -->
	<div id="dropDownSelect1"></div>
	<div id="dropDownSelect2"></div>