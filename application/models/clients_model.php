<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients_model extends CI_Model {

	protected $table = 'FM_CLIENT';

	public function get_all_clients()
	{
		$ignored_branches = array(01,14,05,15,09,13);
		$this->db->select('GLOBAL_ID,CLIENT_ALIAS');
		$this->db->from($this->table);
		$this->db->where('EB_CLIENT','Y');
		$this->db->where('TRAN_STATUS','A');
		$this->db->where('CLIENT_TYPE',5);
		$this->db->where_not_in('CTRL_BRANCH', $ignored_branches);
		$this->db->like('GLOBAL_ID','07','after');
		$this->db->distinct();
		$clients = $this->db->get()->result_object();
		 return $clients;
	}

	/**
	 * Get all the clients from the storage.
	 * @return Response 
	 */
	public function get_all()
	{
			$this->db->select('*');
			$this->db->from('OBA_CLIENT_ACCOUNTS  a');
			$this->db->join('FM_CLIENT  c','c.CLIENT_NO = a.CLIENT_NO','right');
			$clients = $this->db->get()->result_object();
			return $clients;
	}

	/**
	 * Remove the access from a certain user.
	 *
	 * @param      int  $usr_id  
	 *
	 * @return     mixed  
	 */
	public function remove_access($usr_id)
	{
	 	return $this->db->delete('OBA_CLIENT_ACCOUNTS', array('USR_ID' => $usr_id)); 
	}

	/**
	 * Get all clients who have an access to the application.
	 * @return Response 
	 */
	public function get_all_client_access()
	{
			$this->db->select('c.GLOBAL_ID,ca.USR_NAME,ca.USR_ID,ca.DATE_ADDED,ca.LAST_LOGIN');
			$this->db->from('OBA_CLIENT_ACCOUNTS ca');
			$this->db->join('FM_CLIENT c','ca.CLIENT_NO = c.GLOBAL_ID');
			$this->db->distinct();
			$clients = $this->db->get()->result_object();
			return $clients;
	}



	/**
	 * Get the local banks
	 * @return Response 
	 */
	public function get_client_banks()
	{
		// 
		// $this->db->select('CLIENT_NO,CLIENT_SHORT,CLIENT_NAME');
		// $this->db->from('FM_CLIENT c');
		// $this->db->where('c.CLIENT_TYPE',5);
		// $this->db->where_not_in('CTRL_BRANCH', $ignored_branches);
		$ignored_branches = array(01,14,05,15,09,13);
		$this->db->select('CLIENT_NO,CLIENT_SHORT,CLIENT_NAME');
		$this->db->from('FM_CLIENT c');
		$this->db->where('EB_CLIENT','Y');
		$this->db->where('TRAN_STATUS','A');
		$this->db->where('CLIENT_TYPE',5);
		$this->db->where_not_in('CTRL_BRANCH', $ignored_branches);
		$this->db->like('GLOBAL_ID','07','after');
		$this->db->distinct();
		$clients = $this->db->get()->result_object();
		if ( count($clients) > 0 ){

			return $clients;
		}
		return NULL;	
	}
	
	public function count_number_of_accounts($client_no)
	{
		 $this->db->where('CLIENT_NO',$client_no);
		 return $this->db->count_all_results('RB_ACCT');
	}

	/**
	 * Grab the client details.
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function get_client_details($global_id)
	{
		$this->db->where('GLOBAL_ID',$global_id);
		return $this->db->get($this->table)->result_object();
	}

	/**
	 * Grab the client details.
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function get_details($client_no)
	{
		$this->db->select('*');
		$this->db->from('FM_CLIENT  c');
		$this->db->where('a.CLIENT_NO',$client_no);
		$this->db->join('RB_ACCT a',"a.CLIENT_NO = c.CLIENT_NO",'right');
		$client = $this->db->get()->result_object();
		return $client;
	}

	/**
	 * Get the client user info.
	 * @return Response 
	 */
	public function retrieve_accounts($client_no)
	{
		// return $this->db->where('client_no')
		//$this->db = $this->database_model->getInstance();
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
	 * Find client based on client_no.
	 * @param int $q
	 * @return [type]        [description]
	 */
	public function find($q)
	{
		$this->db->where('CLIENT_NO',$q);
		$result = $this->db->get($this->table)->result_object();
		return  $result;
	
	}

	/**
	 * Count the current number of clients on the storage.
	 * @return Repsonse 
	 */
	public function count_number_of_clients()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

}
