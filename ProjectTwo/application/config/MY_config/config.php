<?php

	// Adresse URL de base du site
	// Documenhtation CI : http://codeigniter.com/user_guide/libraries/config.html

	$config['url_site']					= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/';

	$config['url_register']				= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/register/';
	$config['url_login']				= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/login/';
	$config['url_logout']				= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/logout/';
	$config['url_admin']				= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/admin/';
	
	$config['url_profile']				= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/profile/';
	//$config['url_edit_profil']		= 'http://' . $_SERVER['HTTP_HOST'] . '/WebVP/editProfil/';

	//$config['url_contact']			= 'http://' . $_SERVER['HTTP_HOST'] . '/WebVP/contact/';

	$config['url_shop']					= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/shop/';
	$config['url_shop_pagination']		= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/shop/page/';
	$config['url_shop_category']		= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/shop/category/';
	$config['url_shop_details']			= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/shop/details/';
	$config['url_add_product']			= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/shop/add';
	
	//$config['url_search']			= 'http://' . $_SERVER['HTTP_HOST'] . '/WebVP/search/';	

	// external
	$config['url_default_product']		= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/external/products/default.png';
	$config['url_products_images']		= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/external/products/';
	$config['path_products_images'] 	= 'D:/Programme/WAMP/wamp64/www/ProjectTwo/external/products/';

	//cart
	$config['url_addCartItem']			= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/atc/';
	$config['url_removeCartItem']		= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/rci/';
	$config['url_applyCoupon']			= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/ac/';
	$config['url_removeCoupon']			= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/rc/';
	$config['url_order']				= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/bn/';
	$config['url_cart']					= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/cart/';

	// DataTable
	$config['url_users_dataTable']		= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/usersDt/';
	$config['url_products_dataTable']	= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/itemsDt/';
	$config['url_categories_dataTable']	= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/categoriesDt/';

	// admin cmd
	$config['url_allowProduct']			= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/awP/';
	$config['url_deleteProduct']		= 'http://' . $_SERVER['HTTP_HOST'] . '/ProjectTwo/dP/';

	$config['product_per_page']	= 12;

/* End of file config.php */
/* Location: ./application/config/MY_config/config.php */

?>