<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_model extends CI_Model {

	public $table = 'fm_currency';
	
	/**
	 * Grab all resource from the storage.
	 * @return Response 
	 */		
	public function get_all()
	{
		return $this->db->get($this->table)->result_object();
	}

	public function get_description($currency)
	{
		$this->db->where('CCY',$currency);
		$result  =  $this->db->get($this->table)->result_object();
		return $result[0]->CCY_DESC;
	}
	

	
	

}
