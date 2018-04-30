	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 custom">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?= img_url('img-01.png'); ?>" alt="IMG" id="registerImg">
				</div>

				<form class="login100-form validate-form" method="post" action="">
					<span class="login100-form-title">
						Member Register
					</span>

					<?php if ( isset( $_SESSION['success_msg'] ) ) { ?>
						<div class="alert alert-success"><?= $_SESSION['success_msg'] ?></div>
					<?php } elseif ( isset( $_SESSION['error_msg'] ) ) { ?>
						<div class="alert alert-danger"><?= $_SESSION['error_msg'] ?></div>
					<?php } ?>
					<?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

					<div class="wrap-input100 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="lg" placeholder="Username" value="<?= ( isset( $_POST['lg'] ) && !empty( $_POST['lg'] ) ) ? $_POST['lg']: ""; ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password" value="<?= ( isset( $_POST['pass'] ) && !empty( $_POST['pass'] ) ) ? $_POST['pass']: ""; ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Confirm Password is required">
						<input class="input100" type="password" name="pass2" placeholder="Confirm Password" value="<?= ( isset( $_POST['pass2'] ) && !empty( $_POST['pass2'] ) ) ? $_POST['pass2']: ""; ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Email is required">
						<input class="input100" type="email" name="email" placeholder="Email" value="<?= ( isset( $_POST['email'] ) && !empty( $_POST['email'] ) ) ? $_POST['email']: ""; ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Confirm email is required">
						<input class="input100" type="email" name="email2" placeholder="Confirm Email" value="<?= ( isset( $_POST['email2'] ) && !empty( $_POST['email2'] ) ) ? $_POST['email2']: ""; ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn" id="registerBtn">
						<button class="login100-form-btn">
							Register
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt2" href="<?= $this->config->item('url_login'); ?>">
							Login
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>