<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {

	protected $table = 'rb_acct';
	// private $db; use for oracle
	

	public function authenticate_user($user_id,$password)
	{
		//move to client_model

		// $this->db = $this->database_model->getInstance();
		// $this->db->where('USER_ID',$user_id);
		// $this->db->where('CLIENT_PASSWORD',$password);
		// $result = $this->db->get($this->table)->result_object();
		// return print_r($result);
		// return $result;
		// // $encrypted_password = sha1($password);

		// // $stmt = oci_parse($this->db,"SELECT * FROM {$this->table} WHERE USER_ID = '$user_id' AND CLIENT_PASSWORD = '$password'") 
		// // 	or die(oci_error());
		// // oci_execute($stmt);
		// // $result_count = oci_num_rows($stmt);
		
		// // if ( $result_count > 0){
		// 	return  oci_fetch_object($stmt);
		// // }
		// // return false;

	}
	/**
	 * Get the client user info.
	 * @return Response 
	 */
	public function get_client_accounts($client_no)
	{
		$this->db->where('CLIENT_NO',$client_no);
		$result = $this->db->get($this->table)->result_object();
		return $result;
		// $this->db = $this->database_model->getInstance();
		// ;$result = array();
		// $this->db = $this->database_model->getInstance();
		// $sql = "SELECT BRANCH_NAME,ACCT_NO,ACCT_DESC,CCY,LEDGER_BAL,ACTUAL_BAL FROM RB_ACCT  a,	FM_BRANCH_TBL  b 
		// WHERE a.branch = b.branch";
		// $stmt = oci_parse($this->db,$sql) or die(oci_error());
		// oci_execute($stmt);
		// while (($row = oci_fetch_object($stmt)) != false) {
		   
		//     $result[] = array(
		//     					'branch' 			=> $row->branch,
		//     					'acct_no'			=> $row->acct_no,
		//     					'ccy'				=> $row->ccy,
		//     					'ledger_bal'		=> $row->ledger_bal,
		//     					'actual_bal'		=> $row->actual_bal
		//     				); 
		   
		// }
		
		// return $result;
	}

	/**
	 * Count number of current accounts on the storage.
	 * @return Response 
	 */
	public function count_number_of_accounts()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	/**
	 * Get the account details
	 * @param  int $acct_no 
	 * @return Response          
	 */
	public function get_acocunt_details($acct_no)
	{
		$this->db->select('*');
		$this->db->from('rb_acct a');
		$this->db->where('a.ACCT_NO',$acct_no);
		$this->db->join('fm_client c','c.CLIENT_NO = a.CLIENT_NO');
		$result = $this->db->get()->result_object();
		return $result;
	}

	/**
	 * Verify account number if it exist.
	 * @return Response
	 */		
	public function check_account_number($acct_no)
	{	
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('ACCT_NO',$acct_no);
		$result_count = $this->db->count_all_results();
		if ( $result_count > 0 ){
			return true;
		}

		return false;
	}

	/**
	 * Search for account details.	
	 * @return Response
	 */		
	public function find_account_details($acct_no)
	{	
		$this->db->select('*');
		$this->db->from('rb_acct a');
		$this->db->where('a.ACCT_NO',"$acct_no");
		$this->db->join('fm_client c','c.CLIENT_NO = a.CLIENT_NO');
		$this->db->join('aces_user_transactions ut','ut.ACCT_NO = a.ACCT_NO');
		$this->db->join('aces_tran_types tt','tt.TYPE_ID = ut.TRAN_TYPE');
		$this->db->order_by('ut.TRAN_ID','desc');
		$result = $this->db->get()->result_object();
		return $result;

		
	}


	/**
	 * Update the account during the fund transfer process.
	 * @param  string $acct_no      the source account number 
	 * @param  int $avail_bal    the new available balance
	 * @param  int $previous_bal the previous balance
	 * @return Response               
	 */
	public function update_account($acct_no,$avail_bal,$previous_bal)
	{
		$change_by = $this->session->userdata('usrname');
		$data = array(
						'LEDGER_BAL'				=> $avail_bal,
						'ACTUAL_BAL'				=> $avail_bal,
						'CALC_BAL'					=> $avail_bal,
						'PREV_DAY_LEDGER_BAL'		=> $previous_bal,
						'PREV_DAY_ACTUAL_BAL'		=> $previous_bal,
						'PREV_DAY_CALC_BAL'			=> $previous_bal,
						'LAST_CHANGE_OFFICER'		=> $change_by ,
						'LAST_CHANGE_DATE'			=> now(),
						'LAST_BAL_UPDATE'			=> now()
					);
		return $this->db->update($this->table, $data,array( 'ACCT_NO' => $acct_no));
	}

	/**
	 * Return the acocunt details of the client
	 * @param  int $client_no 
	 * @param  int $acct_no   
	 * @return Response            
	 */		
	public function get_account($client_no,$acct_no)
	{
		$this->db->select('*');
		$this->db->from('rb_acct a');
		$this->db->where('a.ACCT_NO',"$acct_no");
		$this->db->where('a.CLIENT_NO',"$client_no");
		$this->db->join('fm_client c','c.CLIENT_NO = a.CLIENT_NO');
		$result = $this->db->get()->result_object();
		return $result;
	}

}
