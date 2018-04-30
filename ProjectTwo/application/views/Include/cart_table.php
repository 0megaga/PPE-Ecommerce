					<?php 
					foreach ( $cart as $cartItem ) : ?>
						<tr class="table-row">
							<td class="column-1">
								<div class="cart-img-product b-rad-4 o-f-hidden" data-i="<?= $cartItem->id_product; ?>">
									<img src="<?= ( file_exists( $this->config->item('path_products_images') . $cartItem->image ) ) ? $this->config->item('url_products_images') . $cartItem->image : $this->config->item('url_default_product'); ?>" alt="IMG-PRODUCT">
								</div>
							</td>
							<td class="column-2"><?= $cartItem->name; ?></td>
							<td class="column-3">$<?= $cartItem->price; ?></td>
							<td class="column-4">
								<div class="flex-w bo5 of-hidden w-size17">
									<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
									</button>

									<input class="size8 m-text18 t-center num-product" type="number" name="num-product1" value="<?= $cartItem->quantities; ?>">

									<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2" data-m="300">
										<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
									</button>
								</div>
							</td>
							<td class="column-5">$<?= $cartItem->price * $cartItem->quantities; ?></td>
						</tr>
					<?php endforeach; ?>
					<?php
						if ( isset( $coupon ) )
						{
							$cp = $coupon;
						}
						else if ( isset( $_COOKIE['coupon'] ) )
						{
							$cp = json_decode( $_COOKIE['coupon'] );
						}
						else
						{
							$cp = "";
						}

						if ( !empty( $cp ) && isset( $cp->id_coupon ) ) :
					?>
						<tr class="table-row">
							<td class="column-1">
								<div class="cart-img-product b-rad-4 o-f-hidden" data-p="cp" >
									<img src="<?= img_url('coupon.png'); ?>" alt="IMG-PRODUCT">
								</div>
							</td>
							<td class="column-2">COUPON</td>
							<td class="column-3">$<?= $coupon->promo; ?></td>
							<td class="column-4"></td>
							<td class="column-5">$<?= $coupon->promo; ?></td>
						</tr>
					<?php endif; ?>