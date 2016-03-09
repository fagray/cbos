<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller{

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
	 * Grab all the clients on the storage.
	 * @return Response 
	 */
	public function index()
	{
		$this->load->model('clients_model');
		$data['clients'] = $this->clients_model->get_all();
		$this->render('clients/index',$data);
	}

	public function get_number_of_accounts($client_no)
	{
		$this->load->model('clients_model');
		return $this->clients_model->count_number_of_accounts($client_no);
	}

	public function view($client_no)
	{
		$this->load->model('clients_model');
		$this->load->model('accounts_model');
		$data['client'] = $this->clients_model->get_client_details($client_no);
		$data['accounts'] = $this->accounts_model->get_client_accounts($client_no);
		return $this->render('clients/view',$data);
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
