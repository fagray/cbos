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
		$this->load->model('system_users_model');
		$username = $this->input->post('usr_id');
		$password = hash('sha1',$this->input->post('usr_password'));
		$account = $this->system_users_model->authenticate_user($username,$password);
		
		if( count ($account) < 1 ){

			$this->session->set_flashdata('msg','Invalid username or password.');
			return redirect('acesmain');
		}
		
		$data = array(
						'panel_access_token'	=> 	random_string('alnum',32), 
						'usrname' 				=> 	$username,
						'last_login' 			=> 	$account->usr_acs_last_login,
						
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
		// $random_pass = random_string('alnum',16);
		// return $this->output
	 //        ->set_content_type('application/json')
	 //        ->set_output(json_encode(array('rnd_pass' => $random_pass)));
	}

	/**
	 * De-authenticate the user.
	 * @return Response 
	 */
	public function destroy()
	{
		$this->session->unset_userdata('panel_access_token');
		$this->session->sess_destroy();
		return redirect(base_url('acesmain'));
	}




}


/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */