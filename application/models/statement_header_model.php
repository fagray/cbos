<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statement_header_model extends CI_Model {

	// private $db;
	protected $table = 'rb_stmt_header';


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
		$this->db->from('rb_acct a');
		$this->db->where('a.CLIENT_NO',$client_no);
		$this->db->join('rb_stmt_header s','s.INTERNAL_KEY = a.INTERNAL_KEY');
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
		 return $this->db->insert_id();
	}
	

	/**
	 * Get the generated estatement for viewing / downloading.
	 * @param  int $seq_no 
	 * @return Response         
	 */
	public function get_statement($seq_no)
	{
		$this->db->select('*');
		$this->db->from('rb_stmt_header s');
		$this->db->where('s.SEQ_NO',$seq_no);
		$this->db->join('rb_acct a','a.ACCT_NO = s.ACCT_NO');
		$this->db->join('fm_branch b','b.BRANCH = s.BRANCH');
		$this->db->join('fm_client c','c.CLIENT_NO = a.CLIENT_NO');
		return  $this->db->get()->result_object();
	}
}
