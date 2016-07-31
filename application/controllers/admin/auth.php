<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


	private $layouts_path = 'admin/layouts/';
	private $admin_path = 'admin/';

	public function __construct()
	{
		parent::__construct();

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

	/**
	 * Show the view for password changing
	 */
	public function change_password()
	{

		return $this->render('auth/change-password');
	}

	/**
	 * Process the admin password change
	 */
	public function post_change_password()
	{
		$this->load->model('system_users_model');
		$usrname = $this->session->userdata('usrname');
		$old_password = $this->system_users_model->get_current_password($usrname);
		$old_input_password = $this->input->post('old_pass');
		$new_password = $this->input->post('new_pass1');
		$confirm_new_passwrod = $this->input->post('new_pass2');

		if ( $old_password != hash('sha1',$old_input_password)){

			$this->session->set_flashdata('msg','Old password is invalid!');
			return redirect('acesmain/settings/change-password');
		}

		if ( $new_password != $confirm_new_passwrod){
			$this->session->set_flashdata('msg','Password do not match!');
			return redirect('acesmain/settings/change-password');
		}

		$this->system_users_model->change_password($new_password);
		$this->session->set_flashdata('msg','Password has been changed.');
		return redirect('acesmain');


		
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