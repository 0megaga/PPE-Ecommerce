		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<!-- Logo moblie -->
			<a href="<?= $this->config->item('url_site'); ?>" class="logo-mobile">
				<img src="<?= img_url('GNT.png'); ?>" alt="IMG-LOGO">
			</a>

			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
				<div class="header-icons-mobile">
					<?php
						$data['header'] = "mobile";
						$this->view('Include/header_fragment/header_user_icon', $data );
					?>

					<span class="linedivide2"></span>

					<div class="header-wrapicon2">
						<img src="<?= img_url('icons/icon-header-02.png'); ?>" class="header-icon1 js-show-header-dropdown" alt="ICON" id="cartIcon">
						<?php 
							if ( isset( $_SESSION['user_logged'] ) && $_SESSION['user_logged'] ) {
								$data['cart'] = $this->instance->buildConnectedDataCart();
							} else {
								$data = array();
							}

							$this->view('Include/header_fragment/header_cart', $data );
						?>
					</div>
				</div>

				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<span class="topbar-child1">
							Free shipping for standard order over $100
						</span>
					</li>

					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<div class="topbar-child2-mobile">
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
					</li>

					<li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">
							<a href="#" class="topbar-social-item fa fa-facebook"></a>
							<a href="#" class="topbar-social-item fa fa-instagram"></a>
							<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
							<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
							<a href="#" class="topbar-social-item fa fa-youtube-play"></a>
						</div>
					</li>

					<li class="item-menu-mobile">
						<a href="<?= $this->config->item('url_site'); ?>">Home</a>
					</li>

					<li class="item-menu-mobile">
						<a href="<?= $this->config->item('url_shop'); ?>">Shop</a>
						<ul class="sub-menu">
							<li><a href="<?= $this->config->item('url_shop'); ?>">Buy a product</a></li>
							<li><a href="<?= $this->config->item('url_add_product'); ?>">Sell a product</a></li>
						</ul>
						<i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>
					</li>

					<li class="item-menu-mobile">
						<a href="product.html">Sale</a>
					</li>

					<li class="item-menu-mobile">
						<a href="<?= $this->config->item('url_cart'); ?>">Cart</a>
					</li>

					<li class="item-menu-mobile">
						<a href="blog.html">Blog</a>
					</li>

					<li class="item-menu-mobile">
						<a href="about.html">About</a>
					</li>

					<li class="item-menu-mobile">
						<a href="contact.html">Contact</a>
					</li>
				</ul>
			</nav>
		</div>