<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_users_model extends CI_Model {

	private $table = 'OBA_SYS_USERS';

	/**
	 * Admin authentication.
	 * @param  string $user_id  
	 * @param  string $password 
	 * @return Response           
	 */
	public function authenticate_user($user_id,$password)
	{
		
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('USR_ACS_USERNAME',$user_id);
		$this->db->where('USR_ACS_PASS',$password);
		$result = $this->db->get()->result_object();
		return  $result;

	}

	/**
	 * Return the current user password.
	 * @param  Response $usrname 
	 * @return Response
	 */
	public function get_current_password($usrname)
	{
		$this->db->where('USR_ACS_USERNAME',$usrname);
		$result = $this->db->get($this->table)->result_object();

	//	return print $result[0]->usr_acs_pass;
		if ( count($result) > 0){
			return $result[0]->USR_ACS_PASS;
		}
		return show_error('Invalid Request.',500);
	}

}
