<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Products_model extends CI_Model
{
	protected $categoriesTable			= 'categories';
	protected $productsTable          	= 'products';
	protected $imagesTable				= 'images';

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
| Categories
|===============================================================================
*/

	/**
	 * @return array object
	 */

	public function getCategories()
	{
		return $this->db_default->get( $this->categoriesTable )->result();
	}

/*
|===============================================================================
| Products
|===============================================================================
*/
	
	/**
	 * @param array $where
	 * @param bool $files
	 * @return object
	 */

	public function getProduct( $where = array(), $files = TRUE )
	{
		$query = $this->db_default->select('pt.*, ct.name as category')
								  ->from( $this->productsTable . " as pt" )
								  ->join( $this->categoriesTable . " as ct", "pt.id_category = ct.id_category" )
								  ->where( $where )
								  ->get()->row();
		
		if ( !empty( $query ) && $files ) {
			$query->images = $this->_getProductImages( $where );
		}
		
		return $query;
	}

	/**
	 * @param array $where
	 * @param integer $start
	 * @return array object
	 */

	public function getProducts( $where, $start = NULL )
	{
		$this->db_default->select('products.*, categories.name as category')
						 ->from( $this->productsTable )
						 ->join( $this->categoriesTable, 'products.id_category = categories.id_category' )
						 ->where( "state", "on" )
						 ->where( $where );

		if ( !is_null( $start ) ) {
			$this->db_default->limit( $this->config->item('product_per_page'), $start );
		}
								
		return $this->db_default->order_by( 'id_product', 'DESC' )
								->get()->result();
	}
	
	/**
	 * @return integer
	 */

	public function addProduct()
	{
		$data = array(
			'name'			=> ucfirst( trim( $this->input->post('product') ) ),
			'quantities'	=> $this->input->post('stock'),
			'price'			=> $this->input->post('price'),
			'description'	=> htmlentities( ucfirst( trim( $this->input->post('description') ) ) ),
			'state'			=> "off",
			'id_user'		=> $_SESSION['id'],
			'id_category'	=> $this->input->post('category')
		);

		if ( $this->db_default->insert( $this->productsTable, $data ) )
		{
			$item_id = $this->db_default->insert_id();

			/*if ( !is_null( $this->input->post('tags') ) )
			{
				//ajoute de tags
			}*/

			return $item_id;
		}
		else {
			return -1;
		}
	}

	/**
	 * @param array $data
	 * @param array $where
	 */

	public function updateProduct( $data, $where )
	{
		$this->db_default->where( $where )
						 ->update( $this->productsTable, $data );
	}

	/**
	 * Note : The removal of the product will result in the removal of the product from the shopping cart some users as well and the associated images
	 * @param integer $id_product
	 */

	public function deleteProduct( $id_product )
	{
		$condition = array( 'id_product' => $id_product );
		$images = $this->_getProductImages( $condition );

		$this->_deleteImages( $condition );

		foreach ( $images as $image )
		{
			if ( file_exists( $this->config->item('path_products_images') . $image->file ) )
			{
				unlink( $this->config->item('path_products_images') . $image->file );
			}
		}

		$this->load->model('cart_model');

		$this->cart_model->deleteCartItems( $condition );

		$this->db_default->where( $condition )
						 ->delete( $this->productsTable );
	}

	/**
	 * @return integer
	 */

	public function countProduct()
	{
		return ( int ) $this->db_default->where( "state", "on" )
										->from( $this->productsTable )
										->count_all_results();
	}

/*
|===============================================================================
| Images
|===============================================================================
*/

	/**
	 * Note : need to optimiz ( search after )
	 * @return associate array
	 */

	public function _getProductsFirstImage()
	{
		$query = $this->db_default->select('t1.*')
								  ->from( $this->imagesTable . " as t1" )
								  ->join( "( SELECT min( id_image ) as id_image FROM images GROUP BY id_product ) t2", "t1.id_image = t2.id_image" )
								  ->get()->result();

		$array = array();

		foreach ( $query as $key => $image ) {
			$array[ $image->id_product ] = $image->file;
		}

		return $array;
	}

	/**
	 * @param array $where
	 * @return array object
	 */

	private function _getProductImages( $where )
	{
		return $this->db_default->select('file')
								->from( $this->imagesTable )
								->where( $where )
								->get()->result();
	}

	/**
	 * @param string $file_name
	 * @param integer $product_id
	 * @return bool
	 */

	public function addImage( $file_name, $product_id )
	{
		$data = array(
			'file'			=> $file_name,
			'id_product'	=> $product_id
		);

		return $this->db_default->insert( $this->imagesTable, $data );
	}

	/**
	 * @param array $where
	 */

	private function _deleteImages( $where )
	{
		$this->db_default->where( $where )
						 ->delete( $this->imagesTable );
	}
}

/* End of file products_model.php */
/* Location: ./application/models/products_model.php */