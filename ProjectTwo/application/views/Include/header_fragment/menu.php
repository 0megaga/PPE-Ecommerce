				<!-- Menu -->
				<div class="wrap_menu">
					<nav class="menu">
						<ul class="main_menu">
							<li>
								<a href="<?= $this->config->item('url_site'); ?>">Home</a>
							</li>

							<li>
								<a href="<?= $this->config->item('url_shop'); ?>">Shop</a>
								<ul class="sub_menu">
									<li><a href="<?= $this->config->item('url_shop'); ?>">Buy a product</a></li>
									<li><a href="<?= $this->config->item('url_add_product'); ?>">Sell a product</a></li>
								</ul>
							</li>

							<li class="sale-noti">
								<a href="product.html">Sale</a>
							</li>

							<li>
								<a href="<?= $this->config->item('url_cart'); ?>">Cart</a>
							</li>

							<li>
								<a href="blog.html">Blog</a>
							</li>

							<li>
								<a href="about.html">About</a>
							</li>

							<li>
								<a href="contact.html">Contact</a>
							</li>
						</ul>
					</nav>
				</div>