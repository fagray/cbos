<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency_model extends CI_Model {

	public $table = 'FM_CURRENCY';
	
	/**
	 * Grab all resource from the storage.
	 * @return Response 
	 */		
	public function get_all()
	{
		$this->db->select('*');
		$this->db->from('FM_CURRENCY c');
		$this->db->join('OBA_CURRENCY_RATES r','r.CCY_FROM = c.CCY');
		return $this->db->get()->result_object();
	}

	public function all_currency()
	{
		
		return $this->db->get($this->table)->result_object();
	}


	public function get_description($currency)
	{
		$this->db->where('CCY',"$currency");
		$result  =  $this->db->get($this->table)->result_object();
		return $result[0]->CCY_DESC;
	}

	public function insert($from,$to,$rate)
	{
		$data = array(
						'CCY_FROM'	=> $from,
						'CCY_TO'	=> $to,
						'RATE'		=> $rate	
					);	

		return $this->db->insert('OBA_CURRENCY_RATES',$data);
	}

	public function update_rate($conv_id,$rate)
	{
		return $this->db->update(
									'OBA_CURRENCY_RATES',array('RATE' => $rate),
									array('CONV_ID' => $conv_id)
						);
	}
	

	
	

}
