<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_accounts extends CI_Controller {

	private $layouts_path = 'admin/layouts/';
	private $admin_path = 'admin/';

	 function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('panel_access_token')) {
			return redirect(base_url('acesmain'));
		}
	}

	/**
	 * Show the form for creating new client access.
	 * @return Response 
	 */
	public function create()
	{
		return $this->render('clients/new_access', NULL);
	}

	/**
	 * Store the newly created access.
	 * @return Response 
	 */
	public function store()
	{
		$this->output->enable_profiler(TRUE);
		$this->load->model('user_accounts_model');
		$this->load->helper('date');
		

			$client_no =  $this->input->get('client_no');
			if ( $this->has_access($client_no) ){

				return show_error('Invalid request. Client has already have an acecss.');
			}

			$password =  $this->input->get('accss_pass_field2');
			$username =  $this->input->get('user_name');
		
			
			$params = array(
								'usr_id' 		=> random_string('alnum',12),
								'usr_name'		=> $username,
								'usr_password'	=> hash('sha1',$password),
								'client_no'		=> $client_no,
								'date_added'	=> now(),
								'status'		=> 'Granted',
								'access_type'	=> '0'
						);
			$this->user_accounts_model->create_new_client_acccount($params);
			
		
	}

	/**
	 * Search for client account details.
	 * @return Response 
	 */
	public function find_account_details()
	{
		$this->load->model('accounts_model');
		$acct_no  = $this->input->get('acct_no');

		$account  = $this->accounts_model->find_account_details($acct_no);

		if ( count($account) < 1){
			// not found
			return show_error('account not found',500);
		}
		
		return $this->toJson($account);
	}

	/**
	 * Convert the givent value to JSON format.
	 * @param  array $value 
	 * @return Response        
	 */
	public function toJson($value)
	{
		return $this->output->set_content_type('application/json')
			->set_output(json_encode($value));
	}

	/**
	 * Change user account password
	 * @return Response 
	 */
	public function chage_client_password()
	{
		
		$this->load->model('user_accounts_model');
		$new_password = $this->input->get('new_pass1');
		$client_no = $this->input->get('client_no');
		$new_password2 = $this->input->get('new_pass2');
		$admin_password = $this->input->get('usr_password');

		if ( ! $this->is_correct_current_system_user_password($admin_password) ) {

			return $this->toJson(array('response' => 500,'msg' => 'Incorrect system user password.'));
		}
		// exit();
		if ( $new_password != $new_password2){

			return $this->toJson(array('response' => 500,'msg' => 'Password do not match'));
		
		}else if( strlen($new_password) < 8 ) {

			return $this->toJson(array('response' => 500,'msg' => 'Password must be greater than 8 characters.'));
		}

		$this->user_accounts_model
					->change_password($client_no,$new_password);
		
		return $this->toJson(array('response' => 200,'msg' => 'Client password has been changed. 
											Effective on the next logon of the user.'));
	}

	/**
	 * Verify the current system user password for password modification.
	 * @param  string  $input_password 
	 * @return Respnse                 
	 */
	public function is_correct_current_system_user_password($input_password)
	{
		$current_usr_name = $this->session->userdata('usrname');
		$this->load->model('system_users_model');
		$current_pass = $this->system_users_model->get_current_password($current_usr_name);

		// return print $this->hash_input($input_password) .' -  '. ;
		if ( $this->hash_input($input_password) != $current_pass) {

			return false;
		}

		return true;
	}

	public function hash_input($input)
	{
		return hash('sha1',$input);
	}

	/**
	 * Check if the client has already an acess.
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function has_access($client_no)
	{
		$this->load->model('user_accounts_model');
		$account = $this->user_accounts_model->check_if_has_access($client_no);
		if ( $account > 0 ){

			return true;
		}

		return false;
	}

	/**
	 * Grab all the client transactions
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function get_all_transactions($client_no)
	{
		$this->load->model('user_transactions_model');
		$data['transactions'] = $this->user_transactions_model->get_client_transfers($client_no);
		return $this->render('clients/view_transactions',$data);
	}

	/**
	 * Show the administration login form.
	 * @return Response        
	 */
	public function login()
	{
		return $this->load->view('admin/auth/login');

	}

	/**
	 * Render the view for this module.
	 * @param  string $path 
	 * @param  mixed $data 
	 * @return Response       
	 */
	public function render($path,$data = NULL)
	{
		$this->load->view($this->layouts_path.'header');
		$this->load->view($this->admin_path.$path,$data);	
	}

}


/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */