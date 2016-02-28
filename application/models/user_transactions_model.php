<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_transactions_model extends CI_Model {

	// private $db;
	protected $table = 'aces_user_transactions';

	
	public function get_all()
	{
			$this->db->select('*');
			$this->db->from('aces_user_transactions t');
			$this->db->join('fm_client c', 'c.CLIENT_NO = t.CLIENT_NO','left');
			$this->db->join('aces_tran_types ty', 'ty.TYPE_ID = t.TRAN_TYPE','left');
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
	 * Grab the client transactions.
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function get_client_transfers($client_no)
	{
		$this->db->select('*');
		$this->db->from('aces_user_transactions t');
		$this->db->where('t.CLIENT_NO',$client_no);
		$this->db->join('rb_acct a','a.ACCT_NO = t.ACCT_NO');
		$this->db->join('fm_client c','c.CLIENT_NO = a.CLIENT_NO');
		$this->db->join('aces_tran_types ty','ty.TYPE_ID = t.TRAN_TYPE');
		return $this->db->get()->result_object();
	}

	public function get_transaction_details($trans_id)
	{
		$this->db->select('*');
		$this->db->from('aces_user_transactions t');
		$this->db->where('t.TRAN_ID',$trans_id);
		$this->db->join('rb_acct a','a.CLIENT_NO = t.CLIENT_NO');
		$this->db->join('aces_tran_types ty','ty.TYPE_ID = t.TRAN_TYPE');
		$this->db->join('fm_client c','c.CLIENT_NO = a.CLIENT_NO');
		return $this->db->get()->result_object();
	}

	/**
	 * Count all the total successful transfers.
	 * @return Response 
	 */
	public function count_all_successful_transfers()
	{
			$this->db->select('*');
			$this->db->from('aces_user_transactions t');
			$this->db->where('TRAN_STAT','Approved');
			return $this->db->count_all_results();
	}

	/**
	 * Verify the transfer request.
	 * @param  array $data    
	 * @param  int $tran_id 
	 * @return Response          
	 */
	public function verify_request($data,$tran_id)
	{
		return $this->db->update($this->table, $data,array( 'TRAN_ID' => $tran_id));
	}

	/**
	 * Process the fund transfer
	 * @param  array $params 
	 * @return Response         
	 */
	public function transfer_funds($params)
	{
		return $this->db->insert($this->table,$params);
	}

	

}
