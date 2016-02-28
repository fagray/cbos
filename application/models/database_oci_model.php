<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database_oci_model extends CI_Model {

	private static $instance;

	public function getInstance()
	{
		if  (!isset(self::$instance)) {

			self::$instance = $this->load->database('default',TRUE); // grab the connection resource
		}
		
		return self::$instance;
	}
}
