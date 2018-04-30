<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Orders_model extends CI_Model
{
	protected $ordersTable				= 'orders';
	protected $orderItemsTable			= 'order_items';

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
| Orders
|===============================================================================
*/

	/**
	 * @param integer $id_cart
	 * @return integer 
	 */

	public function addOrder( $id_cart )
	{
		$data = array(
			'user_id'		=> $_SESSION['id'],
			'total'			=> 0,
			'date_order'	=> date('Y-m-d'),
			'id_cart'		=> $id_cart
		);

		$this->db_default->insert( $this->ordersTable, $data );
		return $this->db_default->insert_id();
	}

	/**
	 * @param array $data
	 * @param array $where
	 */

	public function updateOrder( $data, $where )
	{
		$this->db_default->where( $where )
						 ->update( $this->ordersTable, $data );
	}

	/**
	 * @param array $where
	 */

	public function deleteOrder( $where )
	{
		$this->db_default->where( $where )
						 ->delete( $this->ordersTable );
	}

/*
|===============================================================================
| Order_items
|===============================================================================
*/

	/**
	 * @param array $datas
	 */

	public function addOrderItem( $datas = array() )
	{
		$this->db_default->insert( $this->orderItemsTable, $datas );
	}

}

/* End of file orders_model.php */
/* Location: ./application/models/orders_model.php */