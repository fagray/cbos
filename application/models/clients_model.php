<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients_model extends CI_Model {

	protected $table = 'FM_CLIENT';
	// private $db; // use for oracle
	
	// public function __construct()
	// {
	// 	parent::__construct();
	// 	// $this->db = $database_oci_model->getInstance();
	// }
	

	/**
	 * Show all the clients on the storage.
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
	 * Get the local banks
	 * @return Response 
	 */
	public function get_banks()
	{
		$this->db->select('CLIENT_NO,CLIENT_SHORT,CLIENT_NAME');
		$this->db->from('FM_CLIENT c');
		$this->db->where('c.CLIENT_TYPE',5);
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
	public function get_client_details($client_no)
	{
		$this->db->where('CLIENT_NO',$client_no);
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
