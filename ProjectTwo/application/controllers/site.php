<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MY_Controller
{
	public $categories;
	public $instance;
/*
|===============================================================================
| Constructor
|===============================================================================
*/

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('cookie');

		//layout
		$this->load->library('layout');
		$this->layout->set_theme('site');
		$this->layout->set_charset('utf-8');

		$this->load->model('products_model');
		$this->categories = $this->products_model->getCategories();
		$this->instance = $this;
	}

	public function profiler()
	{
		$this->output->enable_profiler(true);
	}

	public function test()
	{
		var_dump( $this->products_model->_getProductsFirstImage() );
	}

/*
|===============================================================================
| Home (need to dynamize)
|===============================================================================
*/

	public function index()
	{
		$this->_home();
	}

	private function _home()
	{
		$this->layout->set_title( "Home" );		
		$this->_layoutAssets( 'home' );
		$this->layout->view( 'home' );
	}

/*
|===============================================================================
| Member Area (okey)
|===============================================================================
*/

	public function register()
	{
		if ( $this->_check_connexion() )
		{
			redirect( $this->config->item('url_profile') );
		} 
		else
		{
			$this->load->model( 'users_model' );
			$this->load->library( 'form_validation' );

			$this->_registerRules();

			if ( $this->form_validation->run() == TRUE )
			{
				if ( $this->users_model->register() )
				{
					$this->session->set_flashdata("success_msg", "Your account has been registered. You can login now");
					redirect( $this->config->item('url_login'), 'refresh' );
				}
				else
				{
					$this->session->set_flashdata("error_msg", "Fail to add account");
				}
			}

			$this->layout->set_theme( 'form' );
			$this->layout->add_css( 'form.custom' );
			$this->layout->add_js( 'login' );
			$this->layout->add_js( 'Form/main' );
			$this->layout->view( 'register' );
		}
	}

	public function login()
	{
		if ( $this->_check_connexion() )
		{
			redirect( $this->config->item('url_profile') );
		} 
		else
		{
			$this->load->model('users_model');
			$this->load->library( 'form_validation' );

			$this->_loginRules();

			if ( $this->form_validation->run() == TRUE )
			{
				$logId = $this->input->post('login');
				$password = sha1( $this->input->post('pass') );
				$remember = $this->input->post('remember');
				
				if ( $this->users_model->authentification( $logId, $password ) )
				{
					if ( !is_null( $remember ) )
					{
						set_cookie( 'logId', $logId, time() + (86400 * 30) );
						set_cookie( 'password', $password, time() + (86400 * 30) );
					}

					$this->_tmpCookiesToCart();

					$this->session->set_flashdata("success_msg", "You are logged in");
					redirect( $this->config->item('url_profile') );
				} 
				else
				{
					$this->session->set_flashdata("error_msg", "Invalid login or password");
					redirect( $this->config->item('url_login') );
				}
			}

			$this->layout->set_theme( 'form' );
			$this->layout->add_js( 'login' );
			$this->layout->add_js( 'Form/main' );
			$this->layout->view( 'login' );
		}
	}

	public function logout()
	{
		unset( $_SESSION );
		$this->session->sess_destroy();
		delete_cookie('logId');
		delete_cookie('password');
		redirect( $this->config->item('url_site') );
	}

	public function admin()
	{
		if ( isset( $_SESSION['rank'] ) && $_SESSION['rank'] == "admin" )
		{
			$this->_layoutAssets( 'admin' );
			$this->layout->view( 'admin_dashboard' );
		}
		else redirect( $this->config->item('url_site') );
	}

/*
|===============================================================================
| Product
|===============================================================================
*/

	public function shop()
	{
		if ( !isset( $this->uri->ruri_to_assoc( 3 )['type'] ) )
		{
			$this->_products( 1 );
		}
		else 		//param type (route file)
		{
			switch ( $this->uri->ruri_to_assoc( 3 )['type'] ) {
				case 'add':
					$this->_newProduct();
					break;
				case 'pagination':
					$this->_products( $this->uri->ruri_to_assoc( 3 )['page'] );
					break;
				case 'section':
					$where = ( $this->uri->ruri_to_assoc( 3 )['category'] != "all" ) ? array( 'categories.name' => str_replace( '_', ' ', $this->uri->ruri_to_assoc( 3 )['category'] ) ) : array();
					
					$this->_products( 1, $where );
					break;
				case 'details':
					$this->_productDetails();
					break;
				
				default:
					redirect( $this->config->item('url_site') );
					break;
			}
		}
	}

	public function _productDetails()
	{
		$data['product'] 				= $this->products_model->getProduct( array( 'id_product' => $this->uri->ruri_to_assoc( 3 )['item'] ) );

		if ( !empty( $data['product'] ) )
		{
			$data['similaryProducts'] 	= $this->products_model->getProducts( array( 'categories.name' => $data['product']->category/*, 'products.id_product != ' => $data['product']->id_product*/ ) );
			$data['images'] 			= $this->products_model->_getProductsFirstImage();

			$this->_layoutAssets( 'details' );
			$this->layout->view( 'product_details', $data );
		}
		else {
			redirect( $this->config->item('url_site') );
		}
	}

	private function _products( $page, $where = array() )
	{
		$data['currentPage'] 		= $page;
		$data['products'] 			= $this->products_model->getProducts( $where, ( ( $page <= 0 ) ? 0 : $page - 1 ) * $this->config->item('product_per_page') );
		$data['images'] 			= $this->products_model->_getProductsFirstImage();
		$data['productsNumber'] 	= $this->products_model->countProduct();
		
		$this->layout->set_title( "Shop" );
		$this->_layoutAssets( 'shop' );
		$this->layout->view( 'product', $data );
	}

	private function _newProduct()
	{
		
		if ( $this->_check_connexion() )
		{
			$this->load->helper( 'file' );	// for fn : files_check
			$this->load->library( 'form_validation' );

			$this->_newProductRules();

			if ( $this->form_validation->run() == TRUE )
			{
				$config = array(
					"upload_path" => 'external/products/',
					"allowed_types"	=> 'gif|jpg|jpeg|png',
					"max_size"	=> 2048
				);

				$id_product = $this->products_model->addProduct();

				if ( $id_product != '-1' )
				{
					$this->load->library('upload', $config);

					for ( $i=0; $i < sizeof( $_FILES['img']['name'] ); $i++ )
					{
						$_FILES['image']['name']		= $_FILES['img']['name'][$i];
	            		$_FILES['image']['type']		= $_FILES['img']['type'][$i];
	            		$_FILES['image']['tmp_name']	= $_FILES['img']['tmp_name'][$i];
	            		$_FILES['image']['error']		= $_FILES['img']['error'][$i];
	            		$_FILES['image']['size']		= $_FILES['img']['size'][$i];

	            		if ( $this->upload->do_upload('image') ) {
							$uploadData = $this->upload->data();
							$this->products_model->addImage( $uploadData['file_name'], $id_product );	//check fail after
						}
					}
					$this->session->set_flashdata("success_msg", "Votre produit à bien été enregistrer et est en attente de validation par un administrateur");
				}
				else
				{
					$this->session->set_flashdata("error_msg", "Fail to add product");
				}
			}

			$data['categories'] = $this->products_model->getCategories();

			$this->layout->set_theme( 'form' );
			$this->layout->add_js( 'login' );
			$this->layout->add_js( 'Form/main' );
			$this->layout->view( 'add_product', $data );
		}
		else
		{
			redirect( $this->config->item('url_login') );
		}
	}

	public function profile()
	{
		if ( $this->_check_connexion() )
		{
			$this->_layoutAssets( 'profile' );
			$this->layout->view('profile');
		}
		else {
			$this->_loginLocation();
		}
	}

/*
|===============================================================================
| Form Rules
|	- _loginRules
|	- _registerRules
|	- _newProductRules
|	- files_check
|===============================================================================
*/

	private function _loginRules()
	{
		$this->form_validation->set_rules('login', 'Login', 'required|min_length[4]|max_length[16]');
		$this->form_validation->set_rules('pass', 'Password', 'required|min_length[4]');
	}

	private function _registerRules()
	{
		$this->form_validation->set_rules('lg', 'Username', 'trim|required|min_length[4]|max_length[16]|is_unique[users.login]'/*,
			array(
				'required' 		=> $this->lang->line('user_field_required'),	///add lang after for all rules
				'min_length' 	=> $this->lang->line('user_min_length'),
				'max_length'	=> $this->lang->line('user_max_length'),
				'is_unique'		=> $this->lang->line('user_field_unique')
			)*/
		);

		$this->form_validation->set_rules('pass', 'Password', 'required|min_length[4]' );

		$this->form_validation->set_rules('pass2', 'Confirm Password', 'required|matches[pass]' );

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]' );

		$this->form_validation->set_rules('email2', 'Confirm Email', 'required|matches[email]' );
	}

	private function _newProductRules()
	{
		$this->form_validation->set_rules('product', 'Product', 'required|min_length[4]|max_length[100]'/*, 
			array(
				'required'		=> "Le champs %s est requis",
				'min_length'	=> "Le nom du produit doit comporter au minimum 4 caratères",
				'max_length'	=> "Le nom du produit doit comporter au maximum 100 caratères"
			)*/
		);

		$this->form_validation->set_rules('stock', 'Quantities', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5000]');

		$this->form_validation->set_rules('price', 'Price', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[100000]');

		$this->form_validation->set_rules('img[]', 'Image', 'callback_files_check');
	}

	/**
	 * Callback
	 * @return bool
	 */

	public function files_check()
	{
		$allowed_mime_type = array('image/gif', 'image/jpeg', 'image/png', 'image/x-png');

		$valid = true;

		if ( isset( $_FILES['img']['name'] ) && sizeof( $_FILES['img']['name'] ) > 0 && !empty( $_FILES['img']['name'][0] ) )
		{
			for ($i=0; $i < sizeof( $_FILES['img']['name'] ); $i++)
			{
				if ( isset( $_FILES['img']['size'][$i] ) && !empty( $_FILES['img']['size'][$i] ) && $_FILES['img']['size'][$i] <= 2097152 )
				{
					$mime = get_mime_by_extension( $_FILES['img']['name'][$i] );

					if ( !in_array($mime, $allowed_mime_type ) )
					{
						$this->form_validation->set_message('file_check', 'Please select only gif/jpg/png file.');
						$valid = false;
						break;
					}
				} 
				else
				{
					$this->form_validation->set_message('file_check', 'L\'image du produit ne doit pas dépasser 2Mo !');
					$valid = false;
					break;
				}
			}
		} 
		else
		{
			$this->form_validation->set_message('file_check', 'Please choose a file to upload');
			$valid = false;
		}

		return $valid;
	}

/*
|===============================================================================
|
|===============================================================================
*/

	/**
	 * @param string $page
	 * Note : Fashe. by Colorlib
	 */

	private function _layoutAssets( $page )
	{
		switch ( $page ) {
			case 'home':
				$this->layout->add_css_components( 'ColorlibVendor/daterangepicker/daterangepicker' );
				$this->layout->add_css_components( 'ColorlibVendor/lightbox2/css/lightbox.min' );

				$this->layout->add_js_components( 'ColorlibVendor/countdowntime/countdowntime' );
				$this->layout->add_js_components( 'ColorlibVendor/lightbox2/js/lightbox.min' );

				$this->layout->add_js( 'home' );
				break;
				
			case 'shop':
				$this->layout->add_css_components( 'ColorlibVendor/noui/nouislider.min' );

				$this->layout->add_js_components( 'ColorlibVendor/daterangepicker/moment.min' );
				$this->layout->add_js_components( 'ColorlibVendor/daterangepicker/daterangepicker' );
				$this->layout->add_js_components( 'ColorlibVendor/noui/nouislider.min' );

				$this->layout->add_js( 'product' );
				break;

			case 'details':
				$this->layout->add_js( 'details' );
				break;

			case 'cart':
				$this->layout->add_js( 'cart' );
				break;

			case 'admin':
				$this->_plugin( "DataTables" );

				$this->layout->add_js( 'admin' );
				break;
			
			default:
				# code...
				break;
		}

		$this->layout->add_css( 'fashe.custom' );
		$this->layout->add_css( 'Fashe/util' );
		$this->layout->add_css( 'Fashe/main' );

		$this->layout->add_js( 'Fashe/main' );
	}

	/**
	 * @param string $name
	 */

	private function _plugin( $name )
	{
		switch ( $name ) {
			/*case 'SumoSelect':
				$this->layout->add_css_components('SumoSelect/v3.0.3/sumoselect.min');
				$this->layout->add_js_components('SumoSelect/v3.0.3/jquery.sumoselect.min');
				break;*/
			case 'DataTables':
				//$this->layout->add_css_components('Datatables/v1.10.16/media/css/dataTables.bootstrap.min');
				$this->layout->add_css_components('Datatables/v1.10.16/media/css/jquery.dataTables.min');
				$this->layout->add_js_components('Datatables/v1.10.16/media/js/jquery.dataTables.min');
				break;
			
			default:
				# code...
				break;
		}
	}

	/**
	 * @return bool
	 */

	private function _check_connexion()
	{
		if ( isset( $_SESSION['user_logged'] ) && $_SESSION['user_logged'] )
		{
			return true;
		} 
		elseif ( isset( $_COOKIE['logId'] ) && isset( $_COOKIE['password'] ) ) 
		{
			$this->load->model('users_model');
			$this->users_model->authentification( $_COOKIE['logId'], $_COOKIE['password'] );
			return true;
		}
		else {
			return false;
		}
	}

	private function _loginLocation()
	{
		$this->session->set_flashdata("error_msg", "Please login first to view this page!");
		redirect( $this->config->item('url_login') );
	}

/*
|===============================================================================
| Cart
|	- addToCart
|	- removeCartItem
|	- _tmpCookiesToCart
|===============================================================================
*/

	public function cart()
	{
		if ( $this->_check_connexion() )
		{
			$this->load->model('cart_model');

			$data['cart'] 		= $this->_buildConnectedDataCart();
			$data['coupon'] 	= $this->cart_model->_getCart( array( "user_id" => $_SESSION['id'] ) );
		} 
		else
		{
			$data['cart'] 		= ( isset( $_COOKIE['cart'] ) && !empty( $_COOKIE['cart'] ) ) ? json_decode( $_COOKIE['cart'] ) : array();
			$data['coupon'] 	= ( isset( $_COOKIE['coupon'] ) && !empty( $_COOKIE['coupon'] ) ) ? json_decode( $_COOKIE['coupon'] ) : "";
		}
		
		$this->_layoutAssets( 'cart' );
		$this->layout->view('cart', $data );
	}

	public function addToCart()
	{
		if ( !is_null( $this->input->post('i') ) && !is_null( $this->input->post('q') ) )
		{
			$item = $this->products_model->getProduct( array( 'id_product' => $this->input->post('i') ) );
			if ( !empty( $item ) && $item->quantities >= $this->input->post('q'))
			{
				$cartItem = new stdClass();

				$cartItem->name 			= $item->name;
				$cartItem->price 			= $item->price;
				$cartItem->quantities 		= $this->input->post('q');
				$cartItem->max_quantities 	= $item->quantities;
				$cartItem->id_product 		= $item->id_product;
				$cartItem->image 			= $item->images[0]->file;

				if ( $this->_check_connexion() )
				{
					$this->load->model('cart_model');
					$this->cart_model->addCardItem( $cartItem );
					$data['cart'] = $this->_buildConnectedDataCart();
				}
				else
				{
					$cartItemExist = false;

					if ( isset( $_COOKIE['cart'] ) )
					{
						$cart = json_decode( $_COOKIE['cart'] );

						foreach ($cart as $key => $elemCart)
						{
							if ( $elemCart->id_product == $cartItem->id_product )
							{
								$cart[ $key ]->quantities += ( $cart[ $key ]->quantities + $this->input->post('q') <= $item->quantities ) ? $this->input->post('q') : 0;
								$cartItemExist = true;
								break;
							}
						}
					}

					if ( !$cartItemExist ) {
						$cart[] = $cartItem;
					}
					
					set_cookie( 'cart', json_encode( $cart ), time() + (86400 * 30) );

					$data['cart'] = $cart;
					//add to login check wait cart & delete it after
				}

				$this->load->view( 'Include/header_fragment/header_cart', $data );
			} else echo 2;		// error : product not found / insufficient quantities 
		} else echo 1;		// error : product/quantities null
	}

	public function removeCartItem()
	{
		if ( !is_null( $this->input->post('i') ) )
		{
			if ( $this->_check_connexion() )
			{
				$this->load->model('cart_model');
				$this->cart_model->deleteCartItem( array( 'id_product' => $this->input->post('i') ) );

				$data['cart'] 		= $this->_buildConnectedDataCart();
				$data['coupon'] 	= $this->cart_model->_getCart( array( "user_id" => $_SESSION['id'] ) );
			}
			else
			{
				$cart = json_decode( $_COOKIE['cart'] );

				foreach ( $cart as $key => $elemCart )
				{
					if ( $elemCart->id_product == $this->input->post('i') )
					{
						array_splice( $cart, $key, 1);
					}
				}

				if ( !empty( $cart ) )
				{
					set_cookie( 'cart', json_encode( $cart ), time() + (86400 * 30) );
				}
				else
				{
					delete_cookie('cart');
				}

				$data['cart'] = $cart;
				$data['coupon'] 	= ( isset( $_COOKIE['coupon'] ) && !empty( $_COOKIE['coupon'] ) ) ? json_decode( $_COOKIE['coupon'] ) : "";
			}

			if ( !is_null( $this->input->post('v') ) && $this->input->post('v') === "table" )
			{
				$this->load->view('Include/cart_table', $data );
			}
			else
			{
				$this->load->view( 'Include/header_fragment/header_cart', $data );
			}
		} else echo 1;
	}

	/**
	 * @return array object
	 */

	private function _buildConnectedDataCart()
	{	
		$data['cart'] 		= $this->cart_model->getCartItems();
		$data['images'] 	= $this->products_model->_getProductsFirstImage();

		foreach ( $data['cart'] as $key => $elemCart )
		{
			$data['cart'][ $key ]->image = $data['images'][ $elemCart->id_product ];
		}

		return $data['cart'];
	}

	public function buildConnectedDataCart()
	{
		$this->load->model('cart_model');
		return $this->_buildConnectedDataCart();
	}

	private function _tmpCookiesToCart()
	{
		if ( isset( $_COOKIE['cart'] ) && !empty( $_COOKIE['cart'] ) )
		{
			$cart = json_decode( $_COOKIE['cart'] );

			foreach ( $cart as $key => $item )
			{
				if ( !empty( $this->products_model->getProduct( array( 'id_product' => $item->id_product ), false ) ) )
				{
					$this->load->model('cart_model');
					$this->cart_model->addCardItem( $item );
				}
			}

			delete_cookie('cart');
		}

		//note add coupon
	}

	public function order()
	{
		if ( $this->_check_connexion() )
		{
			$this->load->model('cart_model');
			$this->load->model('orders_model');

			$items = $this->cart_model->getCartItems();

			if ( !empty( $items ) )
			{
				$order_id 		= $this->orders_model->addOrder( $items[0]->id_cart );
				$total 			= 0;

				foreach ( $items as $item )
				{
					$product = $this->products_model->getProduct( array( 'id_product' => $item->id_product ) );
					$datas = array(
						'name'			=> $product->name,
						'price'			=> $product->price,
						'quantities'	=> $item->quantities,
						'id_order'		=> $order_id
					);

					$this->orders_model->addOrderItem( $datas );
					$this->cart_model->deleteCartItem( array( 'id_product' => $item->id_product ) );

					$total += $item->quantities * $product->price;
				}

				$promo = $this->cart_model->_getCart( array( 'id_cart' => $items[0]->id_cart ) )->promo;

				if ( !is_null( $promo ) )
				{
					$total -= $promo;
					$this->cart_model->updateCart( array( 'id_coupon' => NULL ), array( 'user_id' => $_SESSION['id'] ) );
				}

				$this->orders_model->updateOrder( array( 'total' => $total ), array( 'id_order' => $order_id ) );
			}
			else echo 2;
		} else echo 1;
	}

/*
|===============================================================================
| Coupon
|===============================================================================
*/

	public function removeCoupon()
	{
		$this->load->model('cart_model');

		if ( $this->_check_connexion() )
		{
			$this->cart_model->updateCart( array( "id_coupon" => NULL ), array( 'user_id' => $_SESSION['id'], 'id_cart' => $this->cart_model->getCart() ) );
			$data['cart'] 		= $this->_buildConnectedDataCart();
			$data['coupon'] 	= $this->cart_model->_getCart( array( "user_id" => $_SESSION['id'] ) );
		}
		else
		{
			delete_cookie('coupon');

			$data['cart'] 		= ( isset( $_COOKIE['cart'] ) && !empty( $_COOKIE['cart'] ) ) ? json_decode( $_COOKIE['cart'] ) : array();
			$data['coupon'] 	= "";
		}

		$this->load->view( 'Include/cart_table', $data );
	}

	public function applyCoupon()
	{
		$this->load->model('cart_model');

		$coupon = $this->cart_model->getCoupon( array( 'code' => strtoupper( $this->input->post('c') ) ) );

		if ( $this->_check_coupon( $coupon ) )
		{
			if ( $this->_check_connexion() )
			{
				$this->cart_model->updateCart( array( 'id_coupon' => $coupon->id_coupon ), array( 'user_id' => $_SESSION['id'], 'id_cart' => $this->cart_model->getCart() ) );
				$data['cart'] 		= $this->_buildConnectedDataCart();
				$data['coupon'] 	= $this->cart_model->_getCart( array( "user_id" => $_SESSION['id'] ) );
			} else {
				set_cookie( 'coupon', json_encode( $coupon ), time() + (86400 * 30) );

				$data['cart'] 		= ( isset( $_COOKIE['cart'] ) && !empty( $_COOKIE['cart'] ) ) ? json_decode( $_COOKIE['cart'] ) : array();
				$data['coupon'] 	= $coupon;
			}
			
			$this->load->view( 'Include/cart_table', $data );
		}
	}

	/**
	 * @param object $coupon
	 * @return bool
	 */

	private function _check_coupon( $coupon )
	{
		if ( empty( $coupon ) ) {
			exit('0');
		}
		else {
			switch ( $coupon->requirement_type ) {
				case 'none':
					return true;
					break;
				
				default:
					return false;
					break;
			}
		}
	}

/*
|===============================================================================
| Admin
|===============================================================================
*/
	
	public function usersTable()
	{
		$this->load->model( "admin_model" );

		echo json_encode( $this->admin_model->usersTable() );
	}

	public function productsTable()
	{
		$this->load->model( "admin_model" );

		echo json_encode( $this->admin_model->productsTable() );
	}

	public function categoriesTable()
	{
		$this->load->model( "admin_model" );

		echo json_encode( $this->admin_model->categoriesTable() );
	}

	// ------------------------------------------------------------------

	public function allowProduct()
	{
		if ( isset( $_SESSION['rank'] ) && $_SESSION['rank'] == "admin" )
		{
			$this->load->model( "admin_model" );

			$this->admin_model->allowProduct( $this->input->post( 'item_id' ) );
		}
		else echo 1;
	}

	public function deleteProduct()
	{
		if ( isset( $_SESSION['rank'] ) && $_SESSION['rank'] == "admin" )
		{
			$this->products_model->deleteProduct( $this->input->post( 'item_id' ) );
		}
		else echo 1;
	}
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */