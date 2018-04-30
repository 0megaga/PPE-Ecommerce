<?php 
/*************************************************************************************************************
|
|	Note : please edit call.txt when you use this file to know the impacts of changes on different pages in the future !
|
*************************************************************************************************************/
?>
	<header class="header1">
		<!-- Header desktop -->
		<div class="container-menu-header">
			<div class="topbar">
				<div class="topbar-social">
					<a href="#" class="topbar-social-item fa fa-facebook"></a>
					<a href="#" class="topbar-social-item fa fa-instagram"></a>
					<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
					<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
					<a href="#" class="topbar-social-item fa fa-youtube-play"></a>
				</div>

				<span class="topbar-child1">
					Free shipping for standard order over $100
				</span>

				<div class="topbar-child2">
					<span class="topbar-email">
						fashe@example.com
					</span>

					<div class="topbar-language rs1-select2">
						<select class="selection-1" name="time">
							<option>USD</option>
							<option>EUR</option>
						</select>
					</div>
				</div>
			</div>

			<div class="wrap_header">
				<?php

				$data['header'] = 1;
				$this->view('Include/header_fragment/logo', $data );
				$this->view('Include/header_fragment/menu');

				?>

				<!-- Header Icon -->
				<div class="header-icons">
					<?php
						$data['header'] = "desktop";
						$this->view('Include/header_fragment/header_user_icon', $data);
					?>

					<span class="linedivide1"></span>

					<div class="header-wrapicon2">
						<img src="<?= img_url('icons/icon-header-02.png'); ?>" class="header-icon1 js-show-header-dropdown" alt="ICON" id="cartIcon">
						<?php 
							if ( isset( $_SESSION['user_logged'] ) && $_SESSION['user_logged'] ) {
								$data['cart'] = $this->instance->buildConnectedDataCart();
							} else {
								$data = array();
							}

							$this->view('Include/header_fragment/header_cart', $data);
						?>
					</div>
				</div>
			</div>
		</div>

		<?php $this->view('Include/header_fragment/header_mobile'); ?>
	</header>