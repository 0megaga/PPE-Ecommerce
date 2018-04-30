<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	protected $usersTable				= 'users';
	protected $accountTypeTable 		= 'account_type';
	protected $productsTable			= 'products';
	protected $categoriesTable			= 'categories';

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
| Users DataTable
|===============================================================================
*/

	private function _usersQuery()
	{
		$column = array( null, "id_accountType", "username", "email", "gender", "phone", "created_date", null );

		$this->db_default->select( 'users.*, type' )
						 ->from( $this->usersTable )
						 ->join( $this->accountTypeTable, "users.id_accountType = account_type.id_accountType" );

		if ( isset( $_POST['search']['value'] ) ) {
			$this->db_default->like( "username", $_POST['search']['value'] )
							 ->or_like( "email", $_POST['search']['value'] );
		}

		if ( isset( $_POST['order'] ) ) {
			$this->db_default->order_by( $column[ $_POST['order']['0']['column'] ], $_POST['order']['0']['dir'] );
		}
		else {
			$this->db_default->order_by( "id_user", "DESC" );
		}
	}

	/**
	 * @return array of object
	 */

	private function _usersData()
	{
		$this->_usersQuery();
		if ( $_POST['length'] != -1 ) {
			$this->db_default->limit( $_POST['length'], $_POST['start'] );
		}
		return $this->db_default->get()->result();
	}

	/**
	 * @return integer
	 */

	private function _getAllData()
	{
		$this->db_default->select( '*' )
						 ->from( $this->usersTable );
		return $this->db_default->count_all_results();
	}

	private function _getFilteredData()
	{
		$this->_usersQuery();
		return $this->db_default->get()->num_rows();
	}

	/**
	 * @return array of array
	 */

	public function usersTable()
	{
		$data = array();

		foreach ( $this->_usersData() as $row ) {
			$sub_array = array();

			$sub_array[] = $row->avatar;
			$sub_array[] = $row->type;
			$sub_array[] = $row->username;
			$sub_array[] = $row->email;
			$sub_array[] = $row->gender;
			$sub_array[] = $row->phone;
			$sub_array[] = $row->created_date;
			$sub_array[] = '';
			//$sub_array[] = '<span data-i="' . $row->id_user . '" class="btn btn-warning">Update</span>
			//				<span data-i="' . $row->id_user . '" class="btn btn-danger">Delete</span>';
							
			$data[] = $sub_array;
		}

		$output = array(
			"draw"				=> intval( $_POST['draw'] ),
			"recordsTotal" 		=> $this->_getAllData(),
			"recordsFiltered" 	=> $this->_getFilteredData(),
			"data" 				=> $data
		);

		return $output;
	}

/*
|===============================================================================
| Products DataTable
|===============================================================================
*/

	private function _productsQuery()
	{
		$column = array( "products.name", "quantities", "price", "description", null, "categories.name", "users.username", "state", null );

		$this->db_default->select( 'products.id_product, products.name as itemName, quantities, price, description, state, categories.name as categoryName, username' )
						 ->from( $this->productsTable )
						 ->join( $this->categoriesTable, 'products.id_category = categories.id_category', 'left' )
						 ->join( $this->usersTable, 'products.id_user = users.id_user', 'left' );

		if ( isset( $_POST['search']['value'] ) ) {
			$this->db_default->like( "username", $_POST['search']['value'] )
							 ->or_like( "email", $_POST['search']['value'] )
							 ->or_like( "products.name", $_POST['search']['value'] )
							 ->or_like( "description", $_POST['search']['value'] );
		}

		if ( isset( $_POST['order'] ) ) {
			$this->db_default->order_by( $column[ $_POST['order']['0']['column'] ], $_POST['order']['0']['dir'] );
		}
		else {
			$this->db_default->order_by( "id_product", "DESC" );
		}
	}

	/**
	 * @return array of object
	 */

	private function _productsData()
	{
		$this->_productsQuery();
		if ( $_POST['length'] != -1 ) {
			$this->db_default->limit( $_POST['length'], $_POST['start'] );
		}
		return $this->db_default->get()->result();
	}

	/**
	 * @return integer
	 */

	private function _getFilteredProducts()
	{
		$this->_productsQuery();
		return $this->db_default->get()->num_rows();
	}

	/**
	 * @return integer
	 */

	private function _getAllProducts()
	{
		$this->db_default->select( '*' )
						 ->from( $this->productsTable );
		return $this->db_default->count_all_results();
	}

	/**
	 * @return array of array
	 */

	public function productsTable()
	{
		$data = array();

		foreach ( $this->_productsData() as $row ) {
			$sub_array = array();

			$sub_array[] = $row->itemName;
			$sub_array[] = $row->quantities;
			$sub_array[] = $row->price;
			$sub_array[] = $row->description;
			$sub_array[] = "";
			$sub_array[] = $row->categoryName;
			$sub_array[] = $row->username;
			$sub_array[] = $row->state;
			$sub_array[] = ( $row->state != "on" ? '<span data-i="' . $row->id_product . '" class="btn btn-success allowItem">Allow</span>' : '' ) . '<span data-i="' . $row->id_product . '" class="btn btn-danger deleteItem">Delete</span>';
							
			$data[] = $sub_array;
		}

		$output = array(
			"draw"				=> intval( $_POST['draw'] ),
			"recordsTotal" 		=> $this->_getAllProducts(),
			"recordsFiltered" 	=> $this->_getFilteredProducts(),
			"data" 				=> $data
		);

		return $output;
	}

/*
|===============================================================================
| Categories DataTable
|===============================================================================
*/

	private function _categoriesQuery()
	{
		$column = array( 'name', null );

		$this->db_default->select( '*' )
						 ->from( $this->categoriesTable );

		if ( isset( $_POST['search']['value'] ) ) {
			$this->db_default->like( "name", $_POST['search']['value'] );
		}

		if ( isset( $_POST['order'] ) ) {
			$this->db_default->order_by( $column[ $_POST['order']['0']['column'] ], $_POST['order']['0']['dir'] );
		}
		else {
			$this->db_default->order_by( "id_category", "DESC" );
		}
	}

	/**
	 * @return array of object
	 */

	private function _categoriesData()
	{
		$this->_categoriesQuery();
		if ( $_POST['length'] != -1 ) {
			$this->db_default->limit( $_POST['length'], $_POST['start'] );
		}
		return $this->db_default->get()->result();
	}

	/**
	 * @return integer
	 */

	private function _getAllCategories()
	{
		$this->db_default->select( '*' )
						 ->from( $this->categoriesTable );
		return $this->db_default->count_all_results();
	}

	/**
	 * @return integer
	 */

	private function _getFilteredCategories()
	{
		$this->_categoriesQuery();
		return $this->db_default->get()->num_rows();
	}

	/**
	 * @return array 
	 */

	public function categoriesTable()
	{
		$data = array();

		foreach ( $this->_categoriesData() as $row ) {
			$sub_array = array();

			$sub_array[] = $row->name;
			$sub_array[] = '';
							
			$data[] = $sub_array;
		}

		$output = array(
			"draw"				=> intval( $_POST['draw'] ),
			"recordsTotal" 		=> $this->_getAllCategories(),
			"recordsFiltered" 	=> $this->_getFilteredCategories(),
			"data" 				=> $data
		);

		return $output;
	}

/*
|===============================================================================
| Products Action
|===============================================================================
*/

	/**
	 * @param integer $id_product
	 */

	public function allowProduct( $id_product )
	{
		$this->load->model('products_model');
		$this->products_model->updateProduct( array( 'state' => 'on' ), array( 'id_product' => $id_product ) );
	}

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */