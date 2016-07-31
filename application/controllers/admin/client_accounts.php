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
		$this->load->model('clients_model');
		$data['clients'] = $this->clients_model->get_all_clients();
		$data['clients_access'] = $this->clients_model->get_all_client_access();
		return $this->render('clients/new_access', $data);
	}

	public function accounts_list()
	{
		$global_id = $this->input->get('global_id');
		$this->load->model('accounts_model');
		$accounts  = $this->accounts_model->get_accounts_by_global_id($global_id);
		return $this->toJson($accounts);
	}

	/**
	 * Store the newly created access.
	 * @return Response 
	 */
	public function store()
	{
		// $this->output->enable_profiler(TRUE);
		$this->load->model('user_accounts_model');
		$this->load->model('accounts_model');
		$this->load->helper('date');
		
		$global_id =  $this->input->get('global_id');

		if ( $this->has_access($global_id) ){

			return show_error('Invalid request. Client has already have an acecss.');
		}

		$password =  $this->input->get('accss_pass_field1');

		$username =  $this->input->get('user_name');
		$email =  $this->input->get('client_email');
	
		$params = array(
							'USR_ID' 		=> random_string('alnum',12),
							'USR_NAME'		=> $username,
							'USR_PASSWORD'	=> hash('sha1',$password),
							'CLIENT_EMAIL'	=> $email,
							'CLIENT_NO'		=> $global_id,
							'DATE_ADDED'	=> date('Y-m-d g:i:s'),
							'STATUS'		=> 'Granted',
							'ACCESS_TYPE'	=> '0'
						);

		$this->accounts_model->update_access_accounts($this->input->get('accounts'));
		return $this->user_accounts_model->create_new_client_acccount($params);
		
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
	 * Remove the access from a certain user.
	 *
	 * @return     mixed  
	 */
	public function remove_access()
	{
		if ( ! $this->session->userdata('panel_access_token')) {
			return redirect(base_url('acesmain'));
		}
		
		$usr_id  = $this->input->get('id');
		$this->load->model('clients_model');
		$operation = $this->clients_model->remove_access($usr_id);

		if  ( $operation ){

			return $this->toJson(array('response'	 => 200,'msg'	=> 'Operation completed.'));
		}

		return $this->toJson(array('response'	 => 500,'msg'	=> 'Operation failed.'));
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
		
		if ( count($account) > 0 ){
			
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
	 * Destroy client session.
	 * @return Response 
	 */
	public function logout_user()
	{
		$username = $this->input->get('__usrname');
		$this->load->model('user_accounts_model');
		$this->user_accounts_model->change_auth_state($username,0);
		return $this->toJson(array('response'	 => 200,'msg'	=> 'User has been logged out.'));
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