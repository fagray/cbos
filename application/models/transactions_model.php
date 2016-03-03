<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions_model extends CI_Model {

	// private $db;
	protected $table = 'rb_tran_hist';

	public function get_transactions()
	{
		# code...
	}
	
	public function get_all()
	{
			$client_no = $this->session->userdata('client_no');
			$this->db->select('*');
			$this->db->from('rb_acct as a');
			$this->db->where("a.CLIENT_NO",  $client_no);
			$this->db->join('rb_tran_hist t', 't.INTERNAL_KEY = a.INTERNAL_KEY','left');
			$transactions = $this->db->get()->result_object();	
			return $transactions;
		// $this->db = $this->database_model->getInstance();
		// $sql = "SELECT a.tran_date,
		// a.effect_date,	a.sort_priority,	nvl(a.cons_seq_no,seq_no),
		// a.tran_type||'-'||a.tran_desc	tran_desc,	
		// a.reference,	
		// a.voucher_no,
		// a.seq_no,
		// sum(decode(a.cr_dr_maint_ind,	'D',	a.tran_amt,	0))		debit_amount,
		// sum(decode(a.cr_dr_maint_ind,	'C',	a.tran_amt,	0))		credit_amount
		// from		rb_tran_hist	a,
		// rb_tran_def	c
		// where		a.internal_key	=	:internal_key
		// and			(a.tran_type	=	c.tran_type	and	nvl(c.show_on_stmt,'Y')	=	'Y')
		// and				greatest(a.tran_date,a.effect_date)	between	:start_date	AND	:end_date
		// and		((a.cr_dr_maint_ind	in	('C','D')	and	:excl_maint_tran	=	'Y')	or	:excl_maint_tran	=	'N')
		// group	by	a.tran_date,	a.effect_date,	a.sort_priority,	a.branch,
		// nvl(a.cons_seq_no,seq_no)	,
		// a.tran_type||'-'||a.tran_desc	,	
		// a.reference,	a.narrative,	a.voucher_no,	a.seq_no
		// order	by	1,2,3,4";

		// $stmt = oci_parse($this->db,$sql) or die(oci_error());
		// $result = oci_execute($stmt);
		// 	while (($row = oci_fetch_object($stmt)) != false) {
		// 	    // Use upper case attribute names for each standard Oracle column
		// 	    echo $row->tran_date . "<br>\n";
		// 	    echo $row->effect_date . "<br>\n"; 
		// 	}

		// 	exit();

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
		$this->db->from('rb_tran_hist th');
		$this->db->where('th.cr_dr_maint_ind','C');
		$this->db->where('th.internal_key',$internal_key);
		$this->db->where('th.tran_date   >=', $start_date);
		$this->db->where('th.effect_date <', $start_date);
		$this->db->join('rb_tran_def c','c.tran_type = th.tran_type');
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
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('INTERNAL_KEY',$internal_key);
		$this->db->where('TRAN_DATE >= ', $start_date);
		$this->db->where('TRAN_DATE <=', $end_date);
		$this->db->order_by('TRAN_DATE ', 'ASC');
		return $this->db->get()->result_object();
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
	// 	$this->db->select_sum('TRAN_AMT');
	// 	$this->db->from($this->table);
	// 	$this->db->where('INTERNAL_KEY',$internal_key);
	// 	$this->db->where('TRAN_DATE   >=', $start_date);
	// 	$this->db->where('TRAN_DATE <=', $end_date);
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
		
	// 	$this->db->select_sum('TRAN_AMT');
	// 	$this->db->from($this->table);
	// 	$this->db->where('INTERNAL_KEY',$internal_key);
	// 	$this->db->where('TRAN_DATE   >=', $start_date);
	// 	$this->db->where('TRAN_DATE <=', $end_date);
	// 	$this->db->where('CR_DR_MAINT_IND', 'C');
	// 	$result=  $this->db->get()->result_object();

	// 	if ( count($result) < 1){

	// 		// return print 'not found';
	// 		return '0.00';
	// 	}

	// 	return  $result[0]->TRAN_AMT;
	

	// }

}
