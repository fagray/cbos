<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends CI_Controller {

	private $layouts_path = 'admin/layouts/';
	private $admin_path = 'admin/';

	/**
	 * Show all the currencies from the storage.
	 * @return Response 
	 */
	public function index()
	{

		$this->load->model('currency_model');
		$data['currencies'] = $this->currency_model->get_all();
		$data['all_currencies'] = $this->currency_model->all_currency();
		return $this->render('currency/index',$data);

	}

	public function insert()
	{
		$from 	= $this->input->post('curr_from');
		$to 	= $this->input->post('curr_to');
		$rate 	= $this->input->post('curr_rate');
		$this->load->model('currency_model');
		$this->currency_model->insert($from,$to,$rate);
		$this->session->flashdata('msg',"New Rate has been added.");
		return redirect(base_url('acesmain/system/currency/rates'));
	}

	public function update_conv_rate()
	{
		$conv_id 	= $this->input->post('curr_conv_id');
		$rate 		= $this->input->post('curr_rate');

		$this->load->model('currency_model');
		 $this->currency_model->update_rate($conv_id,$rate);
		 return redirect(base_url('acesmain/system/currency/rates'));
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
