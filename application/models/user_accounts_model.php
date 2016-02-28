<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_accounts_model extends CI_Model {

	private $table = 'aces_user_accounts';

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
		$this->db->from('aces_user_accounts a');
		$this->db->where('a.usr_name',"$user_id");
		$this->db->where('a.usr_password',"$encrpted_pass");
		$this->db->where('a.status','Granted');
		$this->db->join('fm_client c','c.CLIENT_NO = a.client_no');
		// return print $this->db->count_all_results();
		// $this->db->join('fm_client c','c.CLIENT_NO = a.client_no ','left');
		$result = $this->db->get()->result_object();
		return  $result;

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
		$this->db->where('usr_password',hash('sha1',$old_password));
		return $this->db->count_all_results($this->table);
	}

	/**
	 * Process the changing of password request.
	 * @param  string $usr_id       
	 * @param  string $old_password 
	 * @param  string $new_password 
	 * @return Response               
	 */
	public function change_account_password($client_no,$old_password,$new_password)
	{

		$data = array(
			
					'usr_password' 					=> hash('sha1',$new_password),
					'password_changed_timestamp'	=> now(),
					'access_type'					=> 1		
				);	

		return $this->db->update($this->table, $data,
					array(
							'client_no' 		=> $client_no,
							'usr_password' 		=> hash('sha1',$old_password),
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
		$data = array(
			
					'usr_password' 					=> hash_input($new_password),
					'password_changed_timestamp'	=> add_stamp()
					
				);	

		return $this->db->update($this->table, $data,
					array(
							'client_no' 		=> $client_no
							
					));
	}

}
