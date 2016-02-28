<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_bal_model extends CI_Model {

	// private $db;
	protected $table = 'rb_acct_bal';

	
	public function get_start_balance($internal_key,$start_date)
	{

		// $this->db->select("LEDGER_BAL");
		// $this->db->from($this->table);
		// $this->db->where("INTERNAL_KEY",$internal_key);
		// $this->db->where("TRAN_DATE ",$start_date);
		// $this->db->order_by('TRAN_DATE','DESC');
		// $this->db->limit(1);
		// $result =  $this->db->get()->result_object();

		// return print $result[0]->LEDGER_BAL * -1;


		// $date = $this->get_max_date($internal_key,$start_date);
		// $min_date  = $date[0]->TRAN_DATE;
		// return print $min_date;
		
		$this->db->select("LEDGER_BAL");
		$this->db->from($this->table);
		$this->db->where('INTERNAL_KEY',$internal_key);
		$this->db->where('TRAN_DATE <=',$start_date);
		$result =  $this->db->get()->result_object();

		if ( count($result) < 1){

			// return print 'not found';
			return '0.00';
		}

		return  $result[0]->LEDGER_BAL * -1;
	}

	public function get_max_date($internal_key,$start_date)
	{

		$start_date = $start_date.' 00:00:00'; 
		$this->db->select_max("TRAN_DATE");
		$this->db->from($this->table);
		$this->db->where("TRAN_DATE <", $start_date);
		$this->db->where("INTERNAL_KEY",$internal_key);
		return $this->db->get()->result_object();
		// $result =  $this->db->get()->result_object();
		// return print_r($result);
	
	}

	/**
	 * Update the balance after fund transfer request.
	 * @param  array $data 
	 * @return Response       
	 */		
	public function update_ledger_balance($data)
	{
		return $this->db->insert($this->table,$data);
	}

	
}
