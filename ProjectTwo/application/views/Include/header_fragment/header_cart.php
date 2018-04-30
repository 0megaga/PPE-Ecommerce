<?php 
	if ( isset( $cart ) )
	{
		$cartItems = $cart;
	}
	elseif ( isset( $_COOKIE['cart'] ) && !empty( $_COOKIE['cart'] ) )
	{
		$cartItems = json_decode( $_COOKIE['cart'] );
	}
	else
	{
		$cartItems = "";
	}
?>
						<span class="header-icons-noti"><?= ( empty( $cartItems ) ) ? 0 : sizeof( $cartItems ); ?></span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown" id="cartContainer">
<?php
	if ( !empty( $cartItems ) ) {

	$total = 0;
?>
							<ul class="header-cart-wrapitem">
							<?php
								foreach ( $cartItems as $cartItem ) :
									$total += $cartItem->quantities*$cartItem->price;
							?>
								<li class="header-cart-item" data-i="<?= $cartItem->id_product; ?>">
									<div class="header-cart-item-img">
										<img src="<?= ( file_exists( $this->config->item('path_products_images') . $cartItem->image ) ) ? $this->config->item('url_products_images') . $cartItem->image : $this->config->item('url_default_product'); ?>" alt="IMG">
									</div>

									<div class="header-cart-item-txt">
										<a href="<?= $this->config->item('url_shop_details') . $cartItem->id_product; ?>" class="header-cart-item-name">
											<?= $cartItem->name; ?>
										</a>

										<span class="header-cart-item-info">
											<?= $cartItem->quantities . ' x &euro;' . $cartItem->price; ?>
										</span>
									</div>
								</li>
							<?php endforeach; ?>

							</ul>

							<div class="header-cart-total">
								<?= "Total : " . $total; ?>
							</div>

							<div class="header-cart-buttons">
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="<?= $this->config->item('url_cart'); ?>" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div>

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										Check Out
									</a>
								</div>
							</div>
<?php } else { ?>
							<span>panier vide</span>
<?php } ?>
						</div>