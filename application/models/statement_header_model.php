<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statement_header_model extends CI_Model {

	// private $db;
	protected $table = 'RB_STMT_HEADER';

	/**
	 * Retrieve all the statement headers.
	 * @return Response 
	 */
	public function get_all()
	{
		return $this->db->get($this->table)->result_object();
	}


	/**
	 * Get all account statement by client.
	 * @param  int $acct_no 
	 * @return Response          
	 */
	public function get_all_by_client()
	{
		$client_no = $this->session->userdata('client_no');
		$this->db->select('*');
		$this->db->from('RB_ACCT a');
		$this->db->where('a.CLIENT_NO',$client_no);
		$this->db->join('RB_STMT_HEADER s','s.INTERNAL_KEY = a.INTERNAL_KEY');
		return  $this->db->get()->result_object();
	}

	/**
	 * Store the statement header
	 * @param  array $data 
	 * @return Response       
	 */
	public function insert($data)
	{
		 $this->db->insert($this->table,$data);
		 return $this->get_max_id();
	}

	/**
	 * Grab the transaction next id.
	 * @return Response 
	 */
	public function get_max_id() {
	  $this->db->select_max('SEQ_NO');
	  $this->db->from($this->table);
	  $result = $this->db->get()->result_object();
	  return $result[0]->SEQ_NO;

	} 
	

	/**
	 * Get the generated estatement for viewing / downloading.
	 * @param  int $seq_no 
	 * @return Response         
	 */
	public function get_statement($seq_no)
	{
		$this->db->select('*');
		$this->db->from('RB_STMT_HEADER s');
		$this->db->where('s.SEQ_NO',$seq_no);
		$this->db->join('RB_ACCT a','a.ACCT_NO = s.ACCT_NO','left');
		$this->db->join('FM_BRANCH b','b.BRANCH = s.BRANCH');
		$this->db->join('FM_CLIENT c','c.CLIENT_NO = a.CLIENT_NO','left');
		return  $this->db->get()->result_object();
	}
}
