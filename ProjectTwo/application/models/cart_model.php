<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Cart_model extends CI_Model
{
	protected $cartTable        		= 'cart';
	protected $cartItemTable        	= 'cart_items';
	protected $productsTable          	= 'products';
	protected $couponsTable          	= 'coupons';

/*
|===============================================================================
| Constructor
|===============================================================================
*/

	public function __construct()
	{
		parent::__construct();
		$this->db_default = $this->load->database( 'default',TRUE );
	}

/*
|===============================================================================
| Cart
|===============================================================================
*/

	/**
	 * @return integer ( cart_id )
	 */

	public function getCart()
	{
		$cart = $this->_getCart( array('user_id' => $_SESSION['id'] ) );
		return ( !empty( $cart ) ) ? $cart->id_cart : $this->_createCart();
	}

	/**
	 * @return object
	 */

	public function _getCart( $where = array() )
	{
		return $this->db_default->select("cart.*, coupons.promo")
								->from( $this->cartTable )
								->join( $this->couponsTable, "cart.id_coupon = coupons.id_coupon", "left" )
								->where( $where )
								->get()->row();
	}

	/**
	 * @return integer
	 */

	private function _createCart()
	{
		$data = array(
			'user_id' => $_SESSION['id']
		);
		$this->db_default->insert( $this->cartTable, $data );
		return $this->db_default->insert_id();
	}

	/**
	 * @param array $data
	 * @param array $where
	 */

	public function updateCart( $data, $where )
	{
		$this->db_default->where( $where )
						 ->update( $this->cartTable, $data );
	}

/*
|===============================================================================
| Cart items
|===============================================================================
*/

	/**
	 * @param array $where
	 * @return object
	 */

	public function getCartItem( $where = array() )
	{
		return $this->db_default->select('*')
								->from( $this->cartItemTable )
								->where( $where )
								->get()->row();
	}

	/**
	 * @param array $where
	 * @return array of object
	 */

	public function getCartItems( $where = array() )
	{
		$id_cart = $this->getCart();
		return $this->db_default->select('cit.quantities, cit.id_product, cit.id_cart, pt.name, pt.price')
								->from( $this->cartItemTable . " as cit" )
								->join( $this->productsTable . " as pt", "cit.id_product = pt.id_product" )
								->where( $where )
								->where( 'id_cart', $id_cart )
								->get()->result();
	}

	/**
	 * @param object $data
	 */

	public function addCardItem( $data )
	{
		$item = $this->getCartItem( array( 'id_product' => $data->id_product, 'id_cart' => $this->getCart() ) );

		if ( !empty( $item ) )
		{
			if ( $data->max_quantities >= $item->quantities + $data->quantities )
			{			
				$datas = array( 
					'quantities' => ( $item->quantities + $data->quantities )
				);
				$where = array(
					'id_product'		=> $item->id_product,
					'id_cart'			=> $item->id_cart
				);

				$this->updateCartItem( $datas, $where );
			}
		}
		else
		{
			$this->_addCardItem( $data );
		}	
	}

	/**
	 * @param object $data
	 */

	public function _addCardItem( $data )
	{
		$datas = array(
			'quantities'	=> $data->quantities,
			'id_product'	=> $data->id_product,
			'id_cart'		=> $this->getCart()
		);

		$this->db_default->insert( $this->cartItemTable, $datas );
	}

	/**
	 * @param array $data
	 * @param array $where
	 */

	public function updateCartItem( $data, $where = array() )
	{
		$this->db_default->where( $where )
						 ->update( $this->cartItemTable, $data );
	}

	/**
	 * @param array $where
	 */

	public function deleteCartItem( $where = array() )
	{
		$id_cart = $this->getCart();
		$this->db_default->where( $where )
						 ->where( 'id_cart', $id_cart )
						 ->delete( $this->cartItemTable );
	}

	/**
	 * @param array $where
	 */

	public function deleteCartItems( $where )
	{
		$this->db_default->where( $where )
						 ->delete( $this->cartItemTable );
	}

/*
|===============================================================================
| Coupon
|===============================================================================
*/

	/**
	 * @param array $where
	 * @return object
	 */

	public function getCoupon( $where = array() )
	{
		return $this->db_default->select('*')
								->from( $this->couponsTable )
								->where( $where )
								->get()->row();
	}
}

/* End of file cart_model.php */
/* Location: ./application/models/cart_model.php */