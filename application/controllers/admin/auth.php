<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// if ( ! $this->session->userdata('panel_access_token')){

		// 	return redirect(base_url('acesmain'));
		// }
	}

	/**
	 * Show the login form for the administrator.
	 * @return Respnse 
	 */
	public function index()
	{
		// return print hash('sha1','cbosadmin');
		if ( $this->session->has_userdata('panel_access_token')) {
			
			return redirect(base_url('acesmain/home'));
		}

		return $this->load->view('admin/auth/login');
	}

	/**
	 * Handle the panel authorization.
	 * @return Response 
	 */
	public function post_login()
	{
		

		// $this->load->library('passwordhash');
		
		$this->load->model('system_users_model');
		$username = $this->input->post('usr_id');
		$password = hash('sha1',$this->input->post('usr_password'));
		// return print $password;
		// $encrypted_pass = $this->passwordhash->HashPassword($this->input->post('usr_password'));
		// return print $encrypted_pass . ' - '. $this->passwordhash->HashPassword('raymund');exit();

		 $account = $this->system_users_model->authenticate_user($username,$password);

		if( count ($account) < 1 ){

			$this->session->set_flashdata('msg','Invalid username or password.');
			return redirect('acesmain');
		}
		
		$data = array(
						'panel_access_token'	=> 	random_string('alnum',32), 
						'usrname' 				=> 	$username,
						'last_login' 			=> 	$account[0]->USR_ACS_LAST_LOGIN,
						
					);

		$this->session->set_userdata($data);
		
		// $data['accounts']  = $this->accounts_model->get_client_accounts($account[0]->CLIENT_NO);
		return redirect(base_url('acesmain/home'));
	}

	/**
	 * Generate a secure-random password for the client access.
	 * @return Response 
	 */
	public function generate_password()
	{
		$this->load->library('password_service_provider');
		return print $this->password_service_provider->get_random_password(12,18,false,true,false);
		
	}

	/**
	 * De-authenticate the user.
	 * @return Response 
	 */
	public function destroy()
	{
		$this->session->unset_userdata('panel_access_token');
		$this->session->unset_userdata('usrname');
		$this->session->unset_userdata('last_login');
		return redirect(base_url('acesmain'));
	}




}


/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */