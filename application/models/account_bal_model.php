<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_bal_model extends CI_Model {

	// private $db;
	protected $table = 'rb_acct_bal';

	public function insert_transaction($data)
	{
		return $this->db->insert($this->table,$data);
	}

	
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
		$this->db->order_by('TRAN_DATE','DESC');
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

	public function get_end_balance($internal_key,$end_date)
	{
		
		$this->db->select("LEDGER_BAL");
		$this->db->from($this->table);
		$this->db->where('INTERNAL_KEY',$internal_key);
		$this->db->where('TRAN_DATE <=',$end_date);
		$this->db->order_by('TRAN_DATE','DESC');
		$result =  $this->db->get()->result_object();
		
		if ( count($result) < 1){

			// return print 'not found';
			return '0.00';
		}

		return  $result[0]->LEDGER_BAL * -1;
	}


	/**
	 * Update the balance after fund transfer request.
	 * @param  array $data 
	 * @return Response       
	 */		
	public function update_ledger_balance($data)
	{
		$current_day = date('Y-m-d');
		$transaction = $this->is_there_transaction_for_this_day();

		if ( $transaction > 0){

			// update the balance for a certain date
			return $this->update_current_balance($data,$current_day);
		} 

		return $this->db->insert($this->table,$data);
	}

	// TODO : ADD INTERNAL KEY AS PARAMETER
	public function update_current_balance($data,$current_day)
	{
		$new_balance = $data['ACTUAL_BAL'];
		
		$data = array(
						'ACTUAL_BAL'	=>	$new_balance,
						'LEDGER_BAL'	=>  $new_balance,
						'CALC_BAL'		=> 	$new_balance
					);

		$this->db->update($this->table,$data,array('TRAN_DATE' => $current_day ));
	}

	public function update_benef_balance($data,$current_day,$internal_key)
	{
		$new_balance = $data['ACTUAL_BAL'];
		
		$data = array(
						'ACTUAL_BAL'	=>	$new_balance,
						'LEDGER_BAL'	=>  $new_balance,
						'CALC_BAL'		=> 	$new_balance
					);

		$this->db->update(
							$this->table,$data,
							array('TRAN_DATE' => $current_day,'INTERNAL_KEY' => $internal_key )
					);
	}

	// TODO : ADD INTERNAL KEY AS PARAMETER
	public function is_there_transaction_for_this_day()
	{
		$current_day = date('Y-m-d');
		$this->db->where('TRAN_DATE',$current_day);
		return $this->db->count_all_results($this->table);
	}


	public function check_transaction_today($internal_key)
	{
		$current_day = date('Y-m-d');
		$this->db->where('TRAN_DATE',$current_day);
		$this->db->where('INTERNAL_KEY',$internal_key);
		return $this->db->count_all_results($this->table);
	}

	// TODO, to be check
	/**
	 * Credit the transfer.
	 * @param  array $data    
	 * @param  string $acct_no 
	 * @return Response          
	 */
	public function update_beneficiary_balance($data,$internal_key)
	{
		$transactions = $this->check_transaction_today($internal_key);
		if ( count($transactions) > 0){

			// update balances
			$today = date('Y-m-d');
			return $this->update_benef_balance($data,$today,$internal_key);
			
		}

		$data = array(
						'INTERNAL_KEY'			=> $internal_key,
						'TRAN_DATE'				=> date('Y-m-d'),
						'ACTUAL_BAL'			=> $data['ACTUAL_BAL'],
						'LEDGER_BAL'			=> $data['LEDGER_BAL'],
						'CALC_BAL'				=> $data['CALC_BAL'],
						'PREV_ACTUAL_BAL'		=> $data['PREV_DAY_LEDGER_BAL'],
						'PREV_LEDGER_BAL'		=> $data['PREV_DAY_ACTUAL_BAL'],
						'PREV_CALC_BAL'			=> $data['PREV_DAY_CALC_BAL']
				);

		//else insert transactions
		return $this->insert_transaction($data);
	}

	
}
