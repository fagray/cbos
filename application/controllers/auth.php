<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	private $layouts_path = 'auth/';


	/**
	 * Show the view for the login page.
	 * @return Respnonse =
	 */			
	public function login()
	{
		$this->load->view('auth/login');
	}

	/**
	 * Authenticate the user.
	 * @return Response 
	 */
	public function post_login()
	{

		$this->output->enable_profiler(TRUE);
		$this->load->model('user_accounts_model');
		$this->load->model('accounts_model');
		$username = $this->input->post('usr_id');
		$password = $this->input->post('usr_password');
		 $account = $this->user_accounts_model->authenticate_user($username,$password);
		  // return print_r($account);
		if( count ($account) < 1 ){

			$this->session->set_flashdata('msg','Invalid username or password.');
			return redirect('auth/login');
		}

		$data = array(
						'access_token'	=> 	random_string('alnum',32), 
						'usrname' 		=> 	$username,
						'client_no' 	=> 	$account[0]->CLIENT_NO,
						'last_login' 	=> 	$account[0]->last_login,
						'client_name' 	=> 	$account[0]->CLIENT_NAME
					);

		$this->session->set_userdata($data);

		// determine if the account is new
		if ( $account[0]->access_type == 0){
			return redirect(base_url('accounts/new/settings/change-password/'.random_string('alnum',12)));

		}
		// print_r($account[0]);			
		// print $account[0]->access_type;
		// return print "not a newbie";exit();

		// $data['accounts']  = $this->accounts_model->get_client_accounts($account[0]->CLIENT_NO);
		return redirect(base_url());

	}

	public function is_not_logged_in()
	{
		if ( ! $this->session->userdata('access_token')){
			return redirect('auth/login');
		}
	}

	/**
	 * Render the change password view.
	 * @return Response 
	 */
	public function change_new_account_password()
	{
		$this->render('new_access_change_password',NULL);
	}

	/**
	 * Handle  the change pasword request.
	 * @return Response      
	 */
	public function post_change_new_account_password()
	{
		$account = FALSE; //if existing account
		
		$client_no = $this->session->userdata('client_no');
		$this->load->model('user_accounts_model');
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('new_pass1');
		$row_count = $this->user_accounts_model->check_for_old_password($old_password);

		// determine if the account is existing 
		if ( $this->input->post('_origin') == 'accounts/settings/change-password'){
			$account  = TRUE;
		}

		if ( $row_count > 0) {
			// password matches, process the request
		
			if ( $new_password != '' && strlen($new_password ) >= 8 ){

				if ( $new_password == $old_password ){
					 $this->session->set_flashdata('msg','New password cannot be the same with your old password.');
					 
					return $this->redirect_back($account);

				}
				// process the request
				 $this->user_accounts_model
					->change_account_password($client_no,$old_password,$new_password);
				return $this->force_logout();
			
			}else{

				 $this->session->set_flashdata('msg','New password must be minimum of 8 characters.');
				return $this->redirect_back($account);
			}
		}

		 $this->session->set_flashdata('msg','Old password is invalid.');
		return  $this->redirect_back($account);
		
	}

	public function redirect_back($existing_account)			
	{
		if (  ! $existing_account ){
				return redirect('accounts/new/settings/change-password/'.
						random_string('md5',12));
			}

		  return redirect('accounts/settings/change-password');
	}

	/**
	 * Redirect user after password modification for existing user.		
	 * @return Response 
	 */
	public function force_logout()
	{
		$this->session->unset_userdata('access_token');
		$this->session->unset_userdata('msg');
		$this->session->set_flashdata('msg-success','Password has been changed.Please login again.');
		return redirect(base_url('auth/login'));
	}



	/**
	 * De-authenticate the user.
	 * @return Response 
	 */
	public function destroy()
	{
		$this->session->unset_userdata('access_token');
		$this->session->sess_destroy();
		return redirect(base_url('auth/login'));
	}

	/**
	 * Show the form for the changing of password.
	 * @return Response 
	 */
	public function get_change_password()
	{
		$this->is_not_logged_in();
		$data['title'] = 'Change Password';
		$this->load->view('layouts/header');
		return $this->load->view('auth/change_password',$data);
	}

	/**
	 * Process the changing of password.
	 * @return Response 
	 */
	public function post_change_password()
	{
		# code...
	}

	/**
	 * Render the specifed view
	 * @param  string $path 
	 * @param  array $data 
	 * @return Response       
	 */
	public function render($path,$data)
	{
		$this->load->view('layouts/header',$data);
		$this->load->view($this->layouts_path.$path,$data);

	}

	
}
