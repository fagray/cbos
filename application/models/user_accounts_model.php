<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_accounts_model extends CI_Model {

	private $table = 'OBA_CLIENT_ACCOUNTS';

	/**
	 * Authenticating the client.
	 * @param  int $user_id  
	 * @param  mixed $password 
	 * @return Response           
	 */
	public function authenticate_user($user_id,$password)
	{
		$encrpted_pass = hash('sha1',$password);
		$this->db->select('*');
		$this->db->from('OBA_CLIENT_ACCOUNTS a');
		$this->db->where('a.USR_NAME',"$user_id");
		$this->db->where('a.USR_PASSWORD',"$encrpted_pass");
		$this->db->where('a.STATUS','Granted');
		$this->db->join('FM_CLIENT c','c.CLIENT_NO = a.CLIENT_NO');
		$result = $this->db->get()->result_object();
		return $result;

	}

	/**
	 * Change the authentication state of the user.
	 * @param  string  $user_id 
	 * @param  int $state   
	 * @return Response           
	 */
	public function change_auth_state($user_id,$state = 0)
	{
		$stamp = date('Y-m-d g:i:s');
		$data = array('IS_ACTIVE' => $state,'LAST_LOGIN' => $stamp);
		return $this->db->update($this->table, $data,array('USR_NAME' => $user_id));
	}

	/**
	 * Store the new resource.
	 * @param  array $params 
	 * @return Response         
	 */
	public function create_new_client_acccount($params)
	{
		return $this->db->insert($this->table,$params);	
		
	}

	

	/**
	 * Watching out for multiple access.
	 * @param  int $client_no 
	 * @return Response            
	 */
	public function check_if_has_access($client_no)
	{
		$this->db->where('CLIENT_NO',$client_no);
		return $this->db->count_all_results($this->table);
	}

	/**
	 * Verify if the old password entered matches a row on the storage.
	 * @param  string $old_password 
	 * @return Boolean               
	 */
	public function check_for_old_password($old_password)
	{
		$this->db->where('USR_PASSWORD',hash('sha1',$old_password));
		return $this->db->count_all_results($this->table);
	}

	/**
	 * Process the changing of password request
	 * @param  string $usr_id       
	 * @param  string $old_password 
	 * @param  string $new_password 
	 * @return Response               
	 */
	public function change_account_password($client_no,$old_password,$new_password)
	{
		$data = array(
			
					'USR_PASSWORD' 					=> hash('sha1',$new_password),
					'PASSWORD_CHANGED_TIMESTAMP'	=> date('Y-m-d g:i:s'),
					'ACCESS_TYPE'					=> 1		
				);	

		return $this->db->update($this->table, $data,
					array(
							'CLIENT_NO' 		=> $client_no,
							'USR_PASSWORD' 		=> hash('sha1',$old_password),
					));
	}

	/**
	 * Change the client password
	 * @param  int $client_no    
	 * @param  stirng $new_password 
	 * @return Response               
	 */
	public function change_password($client_no,$new_password)
	{
		$encrypted_pass = hash('sha1',$new_password);
		$data = array(
			
					'USR_PASSWORD' 					=> 	$encrypted_pass,
					'PASSWORD_CHANGED_TIMESTAMP'	=>  date('Y-m-d g:i:s')
					
				);	

		return $this->db->update($this->table, $data,
					array(
							'CLIENT_NO' 		=> $client_no
							
					));
	}


	/**
	 * Grab all the current logged in users.
	 * @return Response 
	 */
	public function get_logged_in_users()
	{
		$this->db->where('IS_ACTIVE',1);
		return $this->db->get($this->table)->result_object();
	}

	public function get_client_email($client_no)
	{
		$this->db->where('CLIENT_NO',$client_no);
		$result = $this->db->get($this->table)->result_object();
		return $result[0]->CLIENT_EMAIL;
	}


}
