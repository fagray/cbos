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

		if ( count($result) > 0 ){

			$user_id = $result[0]->USR_ACS_ID;
			// update the last login field
			$this->update_last_logged_in($user_id);
			
		}

		return $result;
		

	}	

	/**
	 * Add a login timestamp to the user.
	 * @param  int $user_id 
	 * @return Response          
	 */
	public function update_last_logged_in($user_id)
	{
		$stamp   = date('Y-m-d g:i:s');
		return $this->db->update($this->table,
					array('USR_ACS_LAST_LOGIN' => $stamp),
					array('USR_ACS_ID' => $user_id));

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

		if ( count($result) > 0){
			return $result[0]->USR_ACS_PASS;
		}
		return show_error('Invalid Request.',500);
	}

	public function change_password($new_password)
	{
		$usrname = $this->session->userdata('usrname');
		return $this->db->update($this->table,
					array('USR_ACS_PASS' => hash('sha1',$new_password) ),
					array('USR_ACS_USERNAME' => $usrname));
	}

}
