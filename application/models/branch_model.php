<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {

	// private $db;
	protected $table = 'FM_BRANCH';

	
	public function get_all()
	{
		// $this->db = $this->database_model->getInstance();

		// $stmt = oci_parse($this->db,"SELECT BRANCH, BRANCH_NAME, BRANCH_SHORT, INTERNAL_CLIENT FROM {$this->table}") or die(oci_error());
		// $result = oci_execute($stmt);
		// 	while (($row = oci_fetch_object($stmt)) != false) {
		// 	    // Use upper case attribute names for each standard Oracle column
		// 	    echo $row->BRANCH_NAME . "<br>\n";
		// 	    echo $row->BRANCH_SHORT . "<br>\n"; 
		// 	}

	}

	/**
	 * Get the client user info.
	 * @return Response 
	 */
	public function retrieve_account_info($acct_no)
	{
		$this->db->where('acct_no',$acct_no);
		return $this->db->get($this->table)->result_object();
	}

	public function get_branch_name($branch)
	{
		$this->db->where('BRANCH',$branch);
		$result  =  $this->db->get($this->table)->result_object();
		return $result[0]->BRANCH_NAME;
	}

}
