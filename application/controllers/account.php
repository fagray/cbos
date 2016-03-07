<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		if( ! $this->session->userdata('access_token') 
				&& ! $this->session->userdata('client_no')) {
			return redirect('auth/login');
		}

		

	}

	/**
	 * Show the main page for the client.
	 * @return Response 
	 */
	public function index()
	{

		if(!$this->session->userdata('access_token')){

			return redirect(base_url('auth/login'));
		}

		$client_no = $this->session->userdata('client_no');
		$this->load->model('accounts_model');
		$data['accounts'] = $this->accounts_model->get_client_accounts($client_no);
		$data['page'] = 'AS';
		$this->render('index',$data);

	}

	/**
	 * Show the index for fund transfer page.
	 * @return Response 
	 */
	public function get_transfer()
	{
		$data['page'] = 'FT';
		$client_no = $this->session->userdata('client_no');
		$this->load->model('user_transactions_model');
		$data['title'] = 'Account Transfer | acesglobal';
		$data['transactions'] = $this->user_transactions_model->get_client_transfers($client_no);
		return $this->render('transactions/fund_transfer',$data);
	}

	/**
	 * Show the view for accunt transfer process.
	 * @return Response 
	 */
	public function new_transfer($acct_no)
	{	
		$data['page'] = 'FT';
		if ( ! $this->account_exist($acct_no)){
			return show_error('Account does not exist.',500,'An error occured.');
		}

		$client_no = $this->session->userdata('client_no');
		$this->load->model('accounts_model');
		$this->load->model('currency_model');
		$data['currencies'] = $this->currency_model->get_all();
		$data['account'] = $this->accounts_model->get_acocunt_details($acct_no);
		$data['user_accounts'] = $this->accounts_model
						->get_client_remaining_accounts($client_no,$acct_no); // client accounts
		

		return $this->render('transactions/fund_transfer_process',$data);
	}

	public function view_transaction_details($trans_id)
	{
		$data['page'] = 'FT';
		$this->load->model('user_transactions_model');
		$data['account'] = $this->user_transactions_model->get_transaction_details($trans_id);
		
		return $this->render('transactions/view',$data);

	}

	/**
	 * Check if the account exist.
	 * @param  int $acct_no 
	 * @return Response          
	 */
	public function account_exist($acct_no)
	{
		$this->load->model('accounts_model');
		$is_exist = $this->accounts_model->check_account_number($acct_no);
		if ( $is_exist){ return true; }
		return false;
	}


	/**
	 * Initiate the CBOS transfer.
	 * @param  int $acct_no 
	 * @return Response          
	 */
	public function async_cbos_post_transfer()
	{
		$this->load->model('accounts_model');
		$this->load->model('user_transactions_model');
		
		// return print_r($_POST);
		
		// validate the data
		$source_acct_no = $this->input->get('source_acct_no');
		// check if the source account exists
		if ( ! $this->account_exist($source_acct_no)) {
			$params = array('response' => 500,'msg' => 'Source account number is invalid.');
			return $this->toJson($params);
		}

		
		$transfer_amount = $this->input->get('tran_amount');
		$account  = $this->accounts_model->get_acocunt_details($source_acct_no);
		$source_balance  = $account[0]->ACTUAL_BAL;
		$prev_original_bal = $account[0]->ACTUAL_BAL;

		$source_ccy  = $account[0]->CCY;
		$transfer_ccy  = $this->input->get('ccy');

		if (  $source_ccy != $transfer_ccy){

			// get the rate for the currency
			$rate = $this->get_conversion_rate($source_ccy,$transfer_ccy); // e.g 1 PHP = 0.021 USD
			$source_balance = $this->convert($source_balance,$rate);
			
		}
		
		if ( $source_balance < 0 && $source_balance != 0 ){

			$source_balance = $source_balance * -1;
		}

		$rate = 1; // if the same currency
		// check if the transfer amount is greater than its source amount
		if ( $transfer_amount > $source_balance ){

			$params = array('response' => 500,'msg' => 'Transfer amount cannot exceed the actual balance.');
			return $this->toJson($params);
		}


		// deduct the source balance from the transfer amount
		$new_balance = $this->get_new_balance($source_balance,$transfer_amount,$rate);
		$this->update_balance($new_balance,$prev_original_bal,$source_acct_no,$account);

		$data = array(

						'INTERNAL_KEY'		=> $account[0]->INTERNAL_KEY,
						'TRAN_DATE'			=> date('Y-m-d'),
						'TRAN_TYPE'			=> $this->input->get('tran_type'),
						'ACCT_NO'			=> $this->input->get('source_acct_no'),
						'BENEF_ACCT_NO'		=> $this->input->get('benef_acct_no'),
						'TRAN_CCY'			=> $transfer_ccy,
						'TRAN_AMT'			=> $this->input->get('tran_amount'),
						'TRAN_DESC'			=> $this->input->get('trans_desc'),
						'ACTUAL_BAL'		=> $new_balance,
						'PREV_BAL'			=> $prev_original_bal,
						'CLIENT_NO'			=> $this->session->userdata('client_no'),
						'CLIENT_TERMINAL'	=> $this->input->ip_address()
			);

		$this->initiate_transfer($data);

			$params = array('response' => 200,'msg' => 'Transfer has been received.');
			return $this->toJson($params);
		

	}

	/**
	 * Initiate the Other transfer.
	 * @param  int $acct_no 
	 * @return Response          
	 */
	public function async_others_post_transfer()
	{

		$this->load->model('accounts_model');
		$this->load->model('user_transactions_model');
		
		// return print_r($_POST);
		
		// validate the data
		$source_acct_no = $this->input->get('other_source_acct_no');
		// check if the source account exists
		if ( ! $this->account_exist($source_acct_no)) {
			$params = array('response' => 500,'msg' => 'Source account number is invalid.');
			return $this->toJson($params);
		}

		
		$transfer_amount = $this->input->get('other_trans_amount');
		// return print $transfer_amount;
		$account  = $this->accounts_model->get_acocunt_details($source_acct_no);
		$source_balance  = $account[0]->ACTUAL_BAL;
		$prev_original_bal = $account[0]->ACTUAL_BAL;

		$source_ccy  = $account[0]->CCY;
		$transfer_ccy  = $this->input->get('other_ccy');

		if (  $source_ccy != $transfer_ccy){
			// get the rate for the currency
			$rate = $this->get_conversion_rate($source_ccy,$transfer_ccy); // e.g 1 PHP = 0.021 USD
			$source_balance = $this->convert($source_balance,$rate);
			
		}
		
		if ( $source_balance < 0 && $source_balance != 0 ){

			$source_balance = $source_balance * -1;
		}
		
		$rate = 1; // if the same currency
		// check if the transfer amount is greater than its source amount
		if ( $transfer_amount > $source_balance ){

			$params = array('response' => 500,'msg' => 'Transfer amount cannot exceed the actual balance.');
			return $this->toJson($params);
		}



		// deduct the source balance from the transfer amount
		$new_balance = $this->get_new_balance($source_balance,$transfer_amount,$rate);
		$this->update_balance($new_balance,$prev_original_bal,$source_acct_no,$account);

		//$update_balance_params = $this->prepare_updated_params($account);

		// deduct the source balance from the transfer amount
		  // $this->update_balance($source_balance,$prev_original_bal,$transfer_amount,$source_acct_no,$rate);

			$data = array(

						'INTERNAL_KEY'				=> $account[0]->INTERNAL_KEY,
						'TRAN_DATE'					=> date('Y-m-d'),
						'TRAN_TYPE'					=> $this->input->get('other_tran_type'),
						'ACCT_NO'					=> $this->input->get('other_source_acct_no'),
						'BENEF_ACCT_NO'				=> $this->input->get('other_benef_acct_no'),
						'TRAN_CCY'					=> $this->input->get('other_ccy'),
						'TRAN_AMT'					=> $transfer_amount,
						'TRAN_DESC'					=> $this->input->get('other_trans_desc'),
						'ACTUAL_BAL'				=> $new_balance,
						'PREV_BAL'					=> $prev_original_bal,
						'REQUEST_TIMESTAMP'			=> date('Y-m-d H:i:s'),
						'CLIENT_NO'					=> $this->session->userdata('client_no'),
						'CLIENT_TERMINAL'			=> $this->input->ip_address()
			);

			

		if ( $this->initiate_transfer($data)){

			//$this->update_balance($updated_balance_params);
			$params = array('response' => 200,'msg' => 'Transfer has been received.');
			return $this->toJson($params);
		}

			$params = array('response' => 500,'msg' => 'Transfer has been aborted. Transfer error.');
			return $this->toJson($params);


	}

	/**
	 * Prepare the data for the account verification.
	 * @param  array $account      account row details
	 * @param  int $new_balance  
	 * @param  int $prev_balance previous balance amount
	 * @return Response               
	 */
	public function update_balance_params($account,$new_balance,$prev_balance)
	{
		$this->load->helper('timestamp_helper');
		$params = array();	

			$params = array(

					'INTERNAL_KEY'				=> $account[0]->INTERNAL_KEY,
					'TRAN_DATE'					=> date('Y-m-d'),
					'ACTUAL_BAL'				=> $new_balance,
					'LEDGER_BAL'				=> $new_balance,
					'CALC_BAL'					=> $new_balance,
					'PREV_ACTUAL_BAL'			=> $prev_balance,
					'PREV_LEDGER_BAL'			=> $prev_balance,
					'PREV_CALC_BAL'				=> $prev_balance,
					'ACTUAL_OR_LEDGER_BAL'		=> 'A',
					'OD_OS_PRINCIPAL'			=> 0,
					'ACCUM_PENALTY'				=> 0
				);


		return $params;
	}

	/**
	 * Update the source balance.
	 * @param  int $source_balance  the converted balance 
	 * @param  int $prev_bal  the original balance
	 * @param  int $transfer_amount 
	 * @param  string $source_acct_no  
	 * @param  array $account_row // client db row details  
	 * @return Response                  
	 */
	public function update_balance($new_balance,$prev_bal,$source_acct_no,$account_row)
	{
		// return print ' source_balance : '.$source_balance . ' source rate : '.$rate;
		$this->load->model('accounts_model');
		$this->load->model('account_bal_model');
		

		// prepare to update rb_acct_bal table
		$params = $this->update_balance_params($account_row,$new_balance,$prev_bal);
		$this->account_bal_model->update_ledger_balance($params);

		// update account on rb_acct table
		$this->accounts_model->update_account($source_acct_no,$new_balance,$prev_bal);

		
	}

	public function get_new_balance($source_balance,$transfer_amount,$rate)
	{
		$new_balance = $source_balance - $transfer_amount;
		return  $new_balance / $rate;
	}

	/**
	 * Initiate the fund transfer process.
	 * @param  array $data 
	 * @return Response       
	 */
	private function initiate_transfer($data)
	{
		$this->load->model('user_transactions_model');
		
		return $this->user_transactions_model->transfer_funds($data);
		
		
	}


	/**
	 * Get all the transactions based on a certain account.
	 * @param  int $acct_no 
	 * @return  Response
	 */
	public function get_transactions_by_account($acct_no)
	{
		$data['page'] = '';
		$this->load->model('user_transactions_model');
		$data['transactions'] = $this->user_transactions_model->get_all_transactions_by_account($acct_no);
		return $this->render('accounts/account_transactions',$data);
	}
	/**
	 * Get the conversion rates of the two currencies.
	 * @param  string $ccy_from 
	 * @param  string $ccy_to   
	 * @return Response           
	 */
	public function get_conversion_rate($ccy_from,$ccy_to)
	{
		$this->load->model('currency_rates_model');
		return $this->currency_rates_model->get_currency_rate($ccy_from,$ccy_to);
	}

	/**
	 * Converting the source balance to the given rate.
	 * @param  int $source_balance 
	 * @param  double $rate           
	 * @return Response                 
	 */
	private function convert($source_balance,$rate)
	{
		return $source_balance * $rate;
	}

	/**
	 * Grab the client details from the async request.
	 * @param  int $acct_no 
	 * @return Response          
	 */
	public function async_get_details($acct_no)
	{
		$this->load->model('accounts_model');
		$account   = $this->accounts_model->get_acocunt_details($acct_no);
		return $this->output->set_content_type('application/json')
		 	->set_output(json_encode($account));
	}

	/**
	 * Grab the account statement of the client.
	 * @return Response 
	 */
	public function get_account_statement()
	{
		$data['page'] = 'ES';
		$client_no = $this->session->userdata('client_no');
		$this->load->model('accounts_model');
		$data['accounts'] = $this->accounts_model->get_client_accounts($client_no);
		$this->load->model('statement_header_model');
		$data['estatements'] = $this->statement_header_model->get_all_by_client();
		// return print_r($data['statements']);
		return $this->render('accounts/estatements2',$data);
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
	 * Render the specifed view
	 * @param  string $path 
	 * @param  array $data 
	 * @return Response       
	 */
	public function render($path,$data)
	{
		$this->load->view('layouts/header',$data);
		$this->load->view($path,$data);
	}
	

}
