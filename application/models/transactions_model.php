<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions_model extends CI_Model {

	// private $db;
	protected $table = 'RB_TRAN_HIST';

	// public function get_transactions()
	// {
	// 	# code...
	// }
	
	public function get_all()
	{
		$client_no = $this->session->userdata('client_no');
		$this->db->select("*");
		$this->db->from("RB_ACCT a");
		$this->db->where("a.CLIENT_NO",$client_no);
		$this->db->join("RB_TRAN_HIST t", "t.INTERNAL_KEY = a.INTERNAL_KEY","left");
		$result = $this->db->get()->result_object();
		return $result;

		
			

	}

	/**
	 * Process the account transfer
	 * @return [type] [description]
	 */
	public function process_transfer()
	{
		
	}

	/**
	 * 
	 * @param  int $internal_key
	 * @return Response              
	 */
	public function get_back_date_amt($internal_key,$start_date)		
	{
		// $start_date = $start_date. ' 00:00:00';
		$start_date = '2006-02-08';
		$this->db->select_sum('th.tran_amt');
		$this->db->from('RB_TRAN_HIST th');
		$this->db->where('th.CR_DR_MAINT_IND','C');
		$this->db->where('th.INTERNAL_KEY',$internal_key);
		$this->db->where('th.TRAN_DATE   >=', $start_date);
		$this->db->where('th.EFFECT_DATE <', $start_date);
		$this->db->join('RB_TRAN_DEF c','c.TRAN_TYPE = th.TRAN_TYPE');
		return print_r($this->db->get()->result_object());
	}
	
	/**
	 * Get the list of transactions based on the given date.
	 * @param  string $start_date   
	 * @param  string $end_date     
	 * @param  int $internal_key 
	 * @return Response               
	 */
	public function get_trans_history($start_date,$end_date,$internal_key)
	{
		// return print $start_date.' '. $end_date;
		// $start_date = date('Y-m-d',strtotime(str_replace('-', '/', $start_date)));
		// $end_date = date('Y-m-d',strtotime(str_replace('-', '/', $end_date)));
		$d_start  = new DateTime($start_date);
		$d_end = new DateTime($end_date);
		$start_date =  $d_start->format('d-M-y');
		$end_date =  $d_end->format('d-M-y');
		// $this->db->select("*");
		// $this->db->from($this->table);
		// $this->db->where("INTERNAL_KEY",$internal_key);
		// $this->db->where("TRAN_DATE >= ", "$start_date");
		// $this->db->where("TRAN_DATE <=", "$end_date");
		// $this->db->order_by("TRAN_DATE ", "ASC");
		// $result =  $this->db->get()->result_object();
		// return $result;
		$this->db->select('*');
		$this->db->from('RB_TRAN_HIST h');
		$this->db->where('h.TRAN_DATE >= ', $start_date);
		$this->db->where('h.TRAN_DATE <=', $end_date);
		$this->db->where('h.INTERNAL_KEY',$internal_key);
		$res1 = $this->db->get()->result_object();

		$this->db->select('TRAN_DESC as trans_desc,TRAN_AMT as trans_amt,TRAN_DATE,ACTUAL_BAL as trans_bal ,
			TRAN_AMT as trans_amt,TRAN_DESC  as trans_desc,TRAN_ID');
		$this->db->from('OBA_USER_TRANSACTIONS');
		$this->db->where('TRAN_DATE >= ', $start_date);
		$this->db->where('TRAN_DATE <=', $end_date);
		$this->db->where('INTERNAL_KEY',$internal_key);
		$res2 = $this->db->get()->result_object();

		return array_merge($res1,$res2);
	}

	// public function get_end_balance($internal_key,$start_date,$end_date,$start_balance)
	// {
	// 	$debited_amount = $this->get_debit_amounts($internal_key,$start_date,$end_date);
	// 	$credited_amount= $this->get_credited_amounts($internal_key,$start_date,$end_date);
	// 	$end_balance  = ($start_balance - $debited_amount) + $credited_amount;

	// //	return print 'DEBIT : ' . $debited_amount .' CREDIT : ' . $credited_amount;
	// 	return $end_balance;
	// }

	// public function get_debit_amounts($internal_key,$start_date,$end_date)
	// {
	// 	$d_start  = new DateTime($start_date);
	// 	$d_end = new DateTime($end_date);
	// 	$start_date =  $d_start->format('d-M-y');
	// 	$end_date =  $d_end->format('d-M-y');

	// 	$this->db->select_sum('TRAN_AMT');
	// 	$this->db->from($this->table);
	// 	$this->db->where('INTERNAL_KEY',$internal_key);
	// 	$this->db->where('TRAN_DATE   >=', "$start_date");
	// 	$this->db->where('TRAN_DATE <=', "$end_date");
	// 	$this->db->where('CR_DR_MAINT_IND', 'D');
	// 	$result=  $this->db->get()->result_object();

	// 	if ( count($result) < 1){

	// 		// return print 'not found';
	// 		return '0.00';
	// 	}

	// 	return  $result[0]->TRAN_AMT;
	// }

	// public function get_credited_amounts($internal_key,$start_date,$end_date)
	// {
		
	// 	$d_start  = new DateTime($start_date);
	// 	$d_end = new DateTime($end_date);
	// 	$start_date =  $d_start->format('d-M-y');
	// 	$end_date =  $d_end->format('d-M-y');

	// 	$this->db->select_sum('TRAN_AMT');
	// 	$this->db->from($this->table);
	// 	$this->db->where('INTERNAL_KEY',$internal_key);
	// 	$this->db->where('TRAN_DATE   >=', "$start_date");
	// 	$this->db->where('TRAN_DATE <=', "$end_date");
	// 	$this->db->where('CR_DR_MAINT_IND', 'C');
	// 	$result=  $this->db->get()->result_object();

	// 	if ( count($result) < 1){

	// 		// return print 'not found';
	// 		return '0.00';
	// 	}

	// 	return  $result[0]->TRAN_AMT;
	

	// }

}
