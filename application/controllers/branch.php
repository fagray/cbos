<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {


	public function index()
	{
		$this->load->model('branch_model');
		return $this->branch_model->get_all();
	}
	
	

}
