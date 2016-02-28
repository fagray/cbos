<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_rates_model extends CI_Model {

	protected $table = 'aces_currency_rates';
	
	/**
	 * Grab all resource from the storage.
	 * @return Response 
	 */		
	public function get_all()
	{
		return $this->db->get($this->table)->result_object();
	}

	/**
	 * Get the specific rate for the given currency.
	 * @param  strinng $ccy_from ccy to be converted to
	 * @param  string $ccy_to   
	 * @return Response           
	 */
	public function get_currency_rate($ccy_from,$ccy_to)			
	{
		$this->db->select('rate as conversion_rate');
		$this->db->from($this->table);
		$this->db->where('ccy_from',$ccy_from);
		$this->db->where('ccy_to',$ccy_to);
		return  $this->db->get()->result_object()[0]->conversion_rate;
	}
	


	
	

}
