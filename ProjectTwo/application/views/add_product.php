	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?= img_url('img-01.png'); ?>" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="" enctype="multipart/form-data">
					<span class="login100-form-title">
						Ajoute d'un produit
					</span>

					<?php if ( isset( $_SESSION['success_msg'] ) ) { ?>
						<div class="alert alert-success"><?= $_SESSION['success_msg'] ?></div>
					<?php } elseif ( isset( $_SESSION['error_msg'] ) ) { ?>
						<div class="alert alert-danger"><?= $_SESSION['error_msg'] ?></div>
					<?php } ?>
					<?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

					<div class="wrap-input100 validate-input" data-validate = "Produit is required">
						<input class="input100" type="text" name="product" placeholder="Produit" value="<?= set_value('product'); ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-cube" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Quantité is required">
						<input class="input100" type="number" min="1" max="5000" name="stock" placeholder="Quantité" value="<?= set_value('stock'); ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "prix is required">
						<input class="input100" type="number" min="1" max="100000" name="price" placeholder="Prix" value="<?= set_value('price'); ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-money" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "category is required">
						<select class="input100" id="categorie" name="category">
						<?php foreach ( $categories as $categorie ) { ?>
							<option value="<?= $categorie->id_category; ?>" <?= ( set_value('category') == $categorie->id_category ) ? "selected": ""; ?> ><?= $categorie->name; ?></option>
						<?php } ?>
						</select>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-reorder" aria-hidden="true"></i>
						</span>
					</div>

					<!--<div class="form-group">
						<label for="tag" >Tag :</label>
						<select class="form-control tags" id="tag" name="tags[]" multiple="multiple">
						 foreach ($tags as $tag) { ?>
							<option value=" $tag->id; "> $tag->name; </option>
						
						</select>
					</div>-->

					<div class="form-group">
						<label for="description" >Description :</label>
						<textarea class="form-control" name="description" id="description" row="3"><?= set_value('description'); ?></textarea>
					</div>

					<div class="form-group">
						<label for="img" >Image du produit :</label>
						<input class="form-control-file" type="file" name="img[]" id="img" multiple="multiple" />
					</div>
					
					<div class="container-login100-form-btn">
						<button type="reset" class="btn btn-primary" name="reset">
							Reset
						</button>
						<button class="login100-form-btn">
							A vendre !
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>