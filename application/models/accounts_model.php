<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {

	protected $table = 'RB_ACCT';
	// private $db; use for oracle
	

	/**
	 * Get the client user info.
	 * @return Response 
	 */
	public function get_client_remaining_accounts($client_no,$source_acct)
	{
		$this->db->where('CLIENT_NO',$client_no);
		$this->db->where('ACCT_NO !=',$source_acct);
		$result = $this->db->get($this->table)->result_object();
		return $result;
		
	}

	/**
	 * Getting all the client accounts
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function get_client_accounts($client_no)
	{
		$this->db->where('CLIENT_NO',$client_no);
		$result = $this->db->get($this->table)->result_object();
		return $result;
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
		$this->db->from('RB_ACCT a');
		$this->db->where('a.ACCT_NO',$acct_no);
		$this->db->join('FM_CLIENT c','c.CLIENT_NO = a.CLIENT_NO');
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
		$this->db->from('RB_ACCT a');
		$this->db->where('a.ACCT_NO',"$acct_no");
		$this->db->join('FM_CLIENT c','c.CLIENT_NO = a.CLIENT_NO','left');
		$this->db->join('OBA_USER_TRANSACTIONS ut','ut.ACCT_NO = a.ACCT_NO','left');
		$this->db->join('OBA_TRAN_TYPES tt','tt.TYPE_ID = ut.TRAN_TYPE','left');
		$this->db->order_by('ut.TRAN_ID','desc');
		$result = $this->db->get()->result_object();
		return $result;

		
	}


	/**
	 * Update the account of the source acct during the fund transfer process.
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
						'LAST_CHANGE_DATE'			=> date('d-M-y'),
						'LAST_BAL_UPDATE'			=> date('d-M-y')
					);
		return $this->db->update($this->table, $data,array( 'ACCT_NO' => $acct_no));
	}

	/**
	 * Credit the transfer.
	 * @param  array $data    
	 * @param  string $acct_no 
	 * @return Response          
	 */
	public function update_beneficiary_balance($data,$acct_no)
	{
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
		$this->db->from('RB_ACCT a');
		$this->db->where('a.ACCT_NO',"$acct_no");
		$this->db->where('a.CLIENT_NO',"$client_no");
		$this->db->join('FM_CLIENT c','c.CLIENT_NO = a.CLIENT_NO');
		$result = $this->db->get()->result_object();
		return $result;
	}

	public function get_other_accounts($client_no)
	{
		$this->db->select('*');
		$this->db->from('rb_acct a');
		$this->db->where('a.CLIENT_NO != ',"$client_no");
		$this->db->join('fm_client c','c.CLIENT_NO = a.CLIENT_NO');
		$result = $this->db->get()->result_object();
		return $result;
	}


	public function negate($value='')
	{
		return -1 * $value;
	}

}
