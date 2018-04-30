	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?= img_url('img-01.png'); ?>" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="">
					<span class="login100-form-title">
						Member Login
					</span>

					<?php if ( isset( $_SESSION['success_msg'] ) ) { ?>
						<div class="alert alert-success"><?= $_SESSION['success_msg'] ?></div>
					<?php } elseif ( isset( $_SESSION['error_msg'] ) ) { ?>
						<div class="alert alert-danger"><?= $_SESSION['error_msg'] ?></div>
					<?php } ?>
					<?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

					<div class="wrap-input100 validate-input" data-validate = "Login is required">
						<input class="input100" type="text" name="login" placeholder="Login" value="<?= ( isset( $_POST['login'] ) && !empty( $_POST['login'] ) ) ? $_POST['login']: ""; ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password" value="<?= ( isset( $_POST['pass'] ) && !empty( $_POST['pass'] ) ) ? $_POST['pass']: ""; ?>" />
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="form-group">
						<input type="checkbox" name="remember" id="kl" />
						<label for="kl">Keep Logged</label>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="<?= $this->config->item('url_register'); ?>">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>