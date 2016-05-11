<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

	/**
	 * Find a resource based on reference key.
	 * @return Response 
	 */
	public function find()
	{

		$keyword = $this->input->get('q');
		$this->load->model('clients_model');
		$client = $this->clients_model->find($keyword);

		if ( count($client) > 0){

			$params = array(
						'response'	=> 200,
						'client_no' => $client[0]->CLIENT_NO
					);

		}else{

			$params = array('response' => 500,'msg' => 'Not found');
		}

		return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode(array($params)));
		

	}



}
