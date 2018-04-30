<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Users_model extends CI_Model
{
	protected $usersTable           = 'users';
	protected $accountTypeTable     = "account_type";

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
| Login/Register
|===============================================================================
*/

	/**
	 * @param string $log
	 * @param string sha1 $password
	 * @return bool
	 */

	public function authentification( $log, $password )
	{
		$query = $this->db_default->select('users.*, account_type.type')
								  ->from( $this->usersTable )
								  ->join( $this->accountTypeTable, 'users.id_accountType = account_type.id_accountType' )
								  ->where( "password", $password )
								  ->group_start()
								  		->where( 'login', $log )
								  		->or_where( 'email', $log )
								  ->group_end()
								  ->get();

		if ( $query->num_rows() > 0 ) {

			$row = $query->row();

			$this->session->set_userdata( array(
				'user_logged'           => TRUE,
				'id'                    => $row->id_user,
				'username'              => $row->username,
				'login'                 => $row->login,
				'email'                 => $row->email,
				'phone'                 => $row->phone,
				'gender'                => $row->gender,
				'avatar'                => $row->avatar,

				'rank'                  => $row->type
			) );

			return true;

		} else return false;
	}

	public function register()
	{
		$data = array(
			'login'						=> $this->input->post('lg'),
			'email'						=> $this->input->post('email'),
			'password'					=> sha1( $this->input->post('pass') ),
			'created_date'				=> date('Y-m-d H:i:s'),
			'avatar'					=> "default.jpg",
			'id_accountType'			=> 2			// id user
		);
		
		return ( $this->db_default->insert( $this->usersTable, $data ) ) ? true: false;
	}

}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */