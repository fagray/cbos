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
		$benef_acct_no  = $this->input->get('benef_acct_no');
		$trans_amt  = $this->input->get('_trans_amt');
		// return print $tran_id.' '. $tran_status;exit();
		$this->load->model('user_transactions_model');
		$data = array(
						'TRAN_STAT'	=> $tran_status,
					);

		$this->user_transactions_model->verify_request($data,$tran_id);
		$this->update_beneficiary_balance($benef_acct_no,$trans_amt);
		$params = array('response'	=> 200,'msg' => 'Request has been successfully completed.');
		return $this->toJson($params);
	}

	/**
	 * Credit beneficiary balances
	 * @param  string $acct_no 
	 * @return Response          
	 */
	public function update_beneficiary_balance($benef_acct_no,$trans_amt)
	{
		$this->load->model('accounts_model');
		$this->load->model('account_bal_model');
		$exist = $this->accounts_model->check_account_number($benef_acct_no);	
		if ( $exist){

			$account = $this->accounts_model->get_acocunt_details($benef_acct_no);
			$internal_key = $account[0]->INTERNAL_KEY;
			$old_balance = $account[0]->ACTUAL_BAL;
			$new_balance = $old_balance + $trans_amt;
			// return print $new_balance;
			$data = array(
							'LEDGER_BAL'			=> $new_balance,
							'ACTUAL_BAL'			=> $new_balance,
							'CALC_BAL'				=> $new_balance,
							'PREV_DAY_LEDGER_BAL'	=> $old_balance,
							'PREV_DAY_ACTUAL_BAL'	=> $old_balance,
							'PREV_DAY_CALC_BAL'		=> $old_balance,
							'LAST_CHANGE_OFFICER'	=> $this->session->userdata('usrname'),
							'LAST_BAL_UPDATE'		=> date('Y-m-d')
						);

			$this->accounts_model->update_beneficiary_balance($data,$benef_acct_no);
			$this->account_bal_model
					->update_beneficiary_balance($data,$internal_key);

		}	

		return $this->toJson(array('response'	=> 500,'msg' => 'Beneficiary account number doest not exist.'));
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