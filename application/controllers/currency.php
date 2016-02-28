<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends CI_Controller {

	/**
	 * Show all the currencies from the storage.
	 * @return Response 
	 */
	public function index()
	{

		$this->load->model('currency_model');
		$data['currencies'] = $this->currency_model->get_all();
		// $this->render('index',$data);

	}


}
