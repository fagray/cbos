<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Post_model extends CI_Model {

	/**
	 * Get all post.
	 * @return Response 
	 */
	public function get_all()
	{
		$this->db->select('*');
		$this->db->from('posts p');
		$this->db->join('users u','users.user_id = posts.user_id','left');
		return $this->db->get()->result_array();
	}
}

/* End of file Post_model.php */
/* Location: ./application/models/Post_model.php */