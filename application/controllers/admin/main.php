<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	 function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('panel_access_token')) {
			return redirect(base_url('acesmain'));
		}
	}

	public function index()
	{
		$this->load->model('clients_model');
		$this->load->model('accounts_model');
		$this->load->model('user_accounts_model');
		$this->load->model('user_transactions_model');
		$data['client_count'] = $this->clients_model->count_number_of_clients();
		$data['accounts_count'] = $this->accounts_model->count_number_of_accounts();
		$data['transfers_count'] = $this->user_transactions_model->count_all_successful_transfers();
		$logged_in_users = $this->user_accounts_model->get_logged_in_users();
		$data['users'] = $logged_in_users;
		$this->load->view('admin/layouts/header');
		return $this->load->view('admin/index',$data);
	}

	/**
	 * Show the administration login form.
	 * @return Response        
	 */
	public function login()
	{
		return $this->load->view('admin/auth/login');

	}

}


/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */