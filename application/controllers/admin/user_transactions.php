<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Transactions extends CI_Controller {

	private $layouts_path = 'admin/layouts/';
	private $admin_path = 'admin/';

	 function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('panel_access_token')) {
			return redirect(base_url('acesmain'));
		}
	}

	/**
	 * Show all resource.
	 * @return Repsonse 
	 */			
	public function index()
	{
		$this->load->model('user_transactions_model');
		$data['transactions'] = $this->user_transactions_model->get_all();
		return $this->render('transactions/index',$data);
	}



	/**
	 * Show the transaction details
	 * @param  int $trans_id 
	 * @return Response           
	 */
	public function view($trans_id)
	{
		$this->load->model('user_transactions_model');
		$data['account'] = $this->user_transactions_model->get_transaction_details($trans_id);
		$this->render('transactions/view',$data);
	}

	/**
	 * Process the specified request.
	 * @return Response 
	 */
	public function process_request()
	{	
		$tran_id  = $this->input->get('tran_id');
		$tran_status  = $this->input->get('tran_status');
		// return print $tran_id.' '. $tran_status;exit();
		$this->load->model('user_transactions_model');
		$data = array(
						'TRAN_STAT'	=> $tran_status,
					);
		$this->user_transactions_model->verify_request($data,$tran_id);
		$params = array('response'	=> 200,'msg' => 'Request has been successfully completed.');
		return $this->toJson($params);
	}

	/**
	 * Convert the data to json format.
	 * @param  array $value 
	 * @return Response        
	 */
	public function toJson($value='')
	{
		 return $this->output->set_content_type('application/json')
            ->set_output(json_encode($value));
	}
	

	/**
	 * Render the view for this module.
	 * @param  string $path 
	 * @param  mixed $data 
	 * @return Response       
	 */
	public function render($path,$data = NULL)
	{
		$this->load->view($this->layouts_path.'header');
		$this->load->view($this->admin_path.$path,$data);	
	}

}


/* End of file Users.php */
/* Location: ./application/controllers/admin/Users.php */