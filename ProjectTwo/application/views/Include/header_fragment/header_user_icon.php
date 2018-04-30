					<a href="#" class="header-wrapicon1 dis-block" id="<?= ( $header === "mobile" ) ? 'userLogoMobile': 'userLogo'; ?>">
						<img src="<?= img_url('icons/icon-header-01.png'); ?>" class="header-icon1" alt="ICON">
						
					</a>
					<ul class="sub_menu" id="<?= ( $header === "mobile" ) ? 'hiddenMenuMobile': 'hiddenMenu'; ?>">
					<?php if ( isset( $_SESSION['user_logged'] ) && $_SESSION['user_logged'] ) { ?>
						<li><a href="<?= $this->config->item('url_profile'); ?>">Profile</a></li>
						<!--<li><a href="<?= $this->config->item('url_login'); ?>">edit profile</a></li>-->
						<?php if ( isset( $_SESSION['rank'] ) && $_SESSION['rank'] == "admin" ) : ?>
							<li><a href="<?= $this->config->item('url_admin'); ?>">Administration</a></li>
						<?php endif; ?>
						<li><a href="<?= $this->config->item('url_logout'); ?>">Logout</a></li>
					<?php }else { ?>
						<li><a href="<?= $this->config->item('url_register'); ?>">Sign up</a></li>
						<li><a href="<?= $this->config->item('url_login'); ?>">Sign in</a></li>
					<?php } ?>
					</ul>