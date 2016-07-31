<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {

	protected $table = 'RB_ACCT';

	/**
	 * Get the client remaining accounts
	 * @return Response 
	 */
	public function get_client_remaining_accounts($global_id,$source_acct)
	{
		// $this->output->enable_profiler(TRUE);
		$ignored_branches = array(01,14,05,15,09,13);
	 	$this->db->select('b.CCY,b.BRANCH,b.ACTUAL_BAL,b.ACCT_DESC,b.LEDGER_BAL,
	 		b.ACCT_OPEN_DATE,b.ACCT_TYPE,a.GLOBAL_ID, a.CLIENT_ALIAS, 
	 		b.CLIENT_NO,b.ACCT_NO,b.ACCT_DESC,b.EB_ACCT, b.ACCT_STATUS');
		$this->db->from('RB_ACCT b');
		$this->db->where('b.GLOBAL_ID',$global_id);
		// $this->db->where('b.CLIENT_NO','a.CLIENT_NO');
		// $this->db->where('b.GLOBAL_ID','0700000');
		$this->db->where('b.ACCT_NO !=',$source_acct);
		$this->db->where('a.EB_CLIENT','Y');
		$this->db->where('b.EB_ACCT','Y');
		$this->db->where('a.CLIENT_TYPE',5);
		$this->db->where('b.ACCT_TYPE','DOB');
		$this->db->where('b.CCY','SDG');
		$this->db->where('b.ACCT_STATUS','A');
		$this->db->where_not_in('b.BRANCH',$ignored_branches);
		// $this->db->where_not_in('a.CTRL_BRANCH',$ignored_branches);
		$this->db->join('FM_CLIENT a','b.CLIENT_NO = a.CLIENT_NO');
		
		 $result = $this->db->get()->result_object();
		 // return print_r($result);
		return $result;
		
	}

	/**
	 * Getting all the client accounts
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function get_client_accounts($global_id)
	{

		
		$this->db->select('b.CCY,b.BRANCH,b.ACTUAL_BAL,b.ACCT_DESC,b.LEDGER_BAL,b.ACCT_OPEN_DATE,b.ACCT_TYPE,a.GLOBAL_ID, a.CLIENT_ALIAS, b.CLIENT_NO,b.ACCT_NO,b.ACCT_DESC,b.EB_ACCT, b.ACCT_STATUS');
		$this->db->from('RB_ACCT b');
		$this->db->where('b.GLOBAL_ID',$global_id);
		// $this->db->where('b.CLIENT_NO','a.CLIENT_NO');
		$this->db->where('a.EB_CLIENT','Y');
		$this->db->where('b.EB_ACCT','Y');
		$this->db->where('a.CLIENT_TYPE',5);
		$this->db->where('b.ACCT_TYPE','DOB');
		$this->db->where('b.CCY','SDG');
		$this->db->where('b.ACCT_STATUS','A');
		$this->db->join('FM_CLIENT a','b.CLIENT_NO = a.CLIENT_NO','left');
		$this->db->distinct();
		$result = $this->db->get()->result_object();
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
	public function get_account($global_id,$acct_no)
	{
		// return print $global_id;
		$this->db->select('*');
		$this->db->from('RB_ACCT a');
		$this->db->where('a.ACCT_NO',$acct_no);
		$this->db->where('a.GLOBAL_ID',"$global_id");
		$this->db->join('FM_CLIENT c','c.GLOBAL_ID = a.GLOBAL_ID');
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

	public function get_accounts_by_global_id($global_id)
	{
		
		// $this->output->enable_profiler(TRUE);
		$this->db->select('b.ACCT_NO,b.ACCT_DESC,b.GLOBAL_ID,b.EB_ACCT');
		$this->db->from('RB_ACCT b,FM_CLIENT a');
		
		$this->db->where('b.GLOBAL_ID',$global_id);
		$this->db->where('b.EB_ACCT','Y');
		$this->db->where('a.EB_CLIENT','Y');
		$this->db->where('a.CLIENT_TYPE',5);
		$this->db->where('b.ACCT_TYPE','DOB');
		$this->db->where('b.CCY','SDG');
		$this->db->where('b.ACCT_STATUS','A');
		
		$this->db->group_by('b.GLOBAL_ID');
		$this->db->group_by('b.ACCT_NO');
		$this->db->group_by('b.ACCT_DESC');
		$this->db->group_by('b.EB_ACCT');
		$result = $this->db->get()->result_object();
		return $result;
	}

	public function update_access_accounts($accounts)
	{
		$conditions = array();

			for ($i=0; $i < count($accounts);  $i++) { 
					
				$conditions = array('ACCT_NO' => $accounts[$i]);	

			}
		$data = array('EB_ACCT' => 'Y');
		$this->db->where($conditions);
		if  ( $this->db->update($this->table, $data) ) {
			return true;
		}
		return false;

	}

}
