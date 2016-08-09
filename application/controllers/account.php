<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
	}

	/**
	 * Show the main page for the client.
	 * @return Response 
	 */
	public function index()
	{

		if(! $this->session->userdata('access_token'))
		{
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
	 *
	 * @param      int    $acct_no  
	 *
	 * @return     Response
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
		$this->load->model('clients_model');
		$data['banks']  		= $this->clients_model->get_client_banks();
		$data['currencies'] 	= $this->currency_model->get_all();
		$data['account'] 		= $this->accounts_model->get_acocunt_details($acct_no);
		$data['user_accounts'] 	= $this->accounts_model
						->get_client_remaining_accounts($client_no,$acct_no); // client accounts
		

		return $this->render('transactions/fund_transfer_process',$data);
	}

	public function view_transaction_details($trans_id)
	{
		$data['page'] = 'FT';
		$this->load->model('user_transactions_model');
		$data['account'] = $this->user_transactions_model->get_transaction_details($trans_id);
		// return print_r($data['account']);
		// return print_r($data['account']);
		return $this->render('transactions/view',$data);

	}

	/**
	 * Check if the account exist.
	 *
	 * @param      int       $acct_no
	 *
	 * @return     Response
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
	 * @param      int   $acct_no
	 *
	 * @return     Response
	 */
	public function async_cbos_post_transfer()
	{
		// load the necessary models
		$this->load->model('accounts_model');
		$this->load->model('user_transactions_model');
		
		// validate the data
		$source_acct_no = $this->input->get('source_acct_no');

		// check if the source account exists
		if ( ! $this->account_exist($source_acct_no)) {
			$params = array('response' => 500,'msg' => 'Source account number is invalid.');
			return $this->toJson($params);
		}

		// grab the transfer amount
		$transfer_amount = $this->input->get('tran_amount');

		// get account details of the source amount
		$account  = $this->accounts_model->get_acocunt_details($source_acct_no);

		// curren balance of the account
		$source_balance  = $account[0]->ACTUAL_BAL; 

		// the transfer currency
		$transfer_ccy  = $this->input->get('ccy');

		// convert the balance to positive number
		if ( $source_balance < 0 && $source_balance != 0 ){

			$source_balance = $source_balance * -1;
		}


		// check if the transfer amount is greater than its source amount
		if ( $transfer_amount > $source_balance ){

			$params = array('response' => 500,'msg' => 'Transfer amount cannot exceed the actual balance.Please add more funds to your account. Thank you.');
			return $this->toJson($params);
		}


		$data = array(

						'INTERNAL_KEY'		=> $account[0]->INTERNAL_KEY,
						'TRAN_DATE'			=> date('Y-m-d'),
						'TRAN_TYPE'			=> $this->input->get('tran_type'),
						'ACCT_NO'			=> $this->input->get('source_acct_no'),
						'BENEF_ACCT_NO'		=> $this->input->get('benef_acct_no'),
						'TRAN_CCY'			=> $transfer_ccy,
						'TRAN_AMT'			=> $this->input->get('tran_amount'),
						'REQUEST_TIMESTAMP'	=> date('Y-m-d g:i:s'),
						'TRAN_DESC'			=> $this->input->get('trans_desc'),
						'CLIENT_NO'			=> $this->session->userdata('client_no'),
						'CLIENT_TERMINAL'	=> $this->input->ip_address()
			);

			if ( ! $this->initiate_transfer($data)) {

				$params = array('response' => 500,'msg' => 'Transfer has been aborted. Transfer error.');
				return $this->toJson($params);
			}

			// send an email notification to the sender, cancel for now
			// $type = 'CBOS';
			// $sender_client_no = $account[0]->CLIENT_NO;
			// $this->user_transactions_model->send_email_confirmation($sender_client_no,$data,$type);

			$params = array('response' => 200,'msg' => 'Transfer has been received.');

			return $this->toJson($params);
		

	}

	public function process_cbos_transfer()
	{
		// load the necessary models
		$this->load->model('accounts_model');
		$this->load->model('user_transactions_model');
		
		// validate the data
		$source_acct_no = $this->input->post('source_acct_no');

		// check if the source account exists
		if ( ! $this->account_exist($source_acct_no)) {
			$params = array('response' => 500,'msg' => 'Source account number is invalid.');
			return $this->toJson($params);
		}

		// grab the transfer amount
		$transfer_amount = $this->input->post('tran_amount');

		// get account details of the source amount
		$account  = $this->accounts_model->get_acocunt_details($source_acct_no);

		// curren balance of the account
		$source_balance  = $account[0]->ACTUAL_BAL; 

		// the transfer currency
		$transfer_ccy  = $this->input->post('ccy');

		// convert the balance to positive number
		if ( $source_balance < 0 && $source_balance != 0 ){

			$source_balance = $source_balance * -1;
		}


		// check if the transfer amount is greater than its source amount
		if ( $transfer_amount > $source_balance ){

			$params = array('response' => 500,'msg' => 'Transfer amount cannot exceed the actual balance.Please add more funds to your account. Thank you.');
			return $this->toJson($params);
		}


		$data = array(

						'INTERNAL_KEY'		=> $account[0]->INTERNAL_KEY,
						'TRAN_DATE'			=> date('Y-m-d'),
						'TRAN_TYPE'			=> $this->input->post('tran_type'),
						'ACCT_NO'			=> $this->input->post('source_acct_no'),
						'BENEF_ACCT_NO'		=> $this->input->post('benef_acct_no'),
						'TRAN_CCY'			=> $transfer_ccy,
						'TRAN_AMT'			=> $this->input->post('tran_amount'),
						'REQUEST_TIMESTAMP'	=> date('Y-m-d g:i:s'),
						'TRAN_DESC'			=> $this->input->post('trans_desc'),
						'CLIENT_NO'			=> $this->session->userdata('client_no'),
						'CLIENT_TERMINAL'	=> $this->input->ip_address()
			);

			if ( ! $this->initiate_transfer($data)) {

				$params = array('response' => 500,'msg' => 'Transfer has been aborted. Transfer error.');
				return $this->toJson($params);
			}

			// send an email notification to the sender, cancel for now
			// $type = 'CBOS';
			// $sender_client_no = $account[0]->CLIENT_NO;
			// $this->user_transactions_model->send_email_confirmation($sender_client_no,$data,$type);

			// $params = array('response' => 200,'msg' => 'Transfer has been received.');
			 // $this->toJson($params);
			$this->session->set_flashdata('msg-success','Fund transfer has been received successfully.');
			return redirect(base_url('accounts/transactions/transfer'));
	}

	/**
	 * Initiate the Other transfer.
	 * @param      int   $acct_no
	 * @return     Response
	 */
	public function async_others_post_transfer()
	{

		$this->load->model('accounts_model');
		$this->load->model('user_transactions_model');
		
		// validate the data
		$source_acct_no = $this->input->get('_other_source_acct_no');

		$transfer_amount = $this->input->get('_other_trans_amount');

		$account  = $this->accounts_model->get_acocunt_details($source_acct_no);
		$source_balance  = $account[0]->ACTUAL_BAL;

		$source_ccy  = $account[0]->CCY;
		$transfer_ccy  = $this->input->get('_other_ccy');

		
		if ( $source_balance < 0 && $source_balance != 0 ){

			$source_balance = $source_balance * -1;
		}
		
		// check if the transfer amount is greater than its source amount
		if ( $transfer_amount > $source_balance ){

			$params = array('response' => 500,'msg' => 'Transfer amount cannot exceed the actual balance.');
			return $this->toJson($params);

		}

		$data = array(

					'INTERNAL_KEY'				=> $account[0]->INTERNAL_KEY,
					'TRAN_DATE'					=> date('Y-m-d'),
					'TRAN_TYPE'					=> $this->input->get('_other_tran_type'),
					'ACCT_NO'					=> $this->input->get('_other_source_acct_no'),
					'BENEF_ACCT_NO'				=> $this->input->get('_other_benef_acct_no'),
					'TRAN_CCY'					=> $this->input->get('_other_ccy'),
					'ACCT_NAME'					=> $this->input->get('_other_acct_name'),
					'BANK_NAME'					=> $this->input->get('_other_bank_name'),
					'SWIFT_CODE'				=> $this->input->get('_other_swift_code'),
					'TIBAN_NUM'					=> $this->input->get('_other_tiban_number'),
					'TRAN_AMT'					=> $transfer_amount,
					'TRAN_DESC'					=> $this->input->get('_other_trans_desc'),
					'REQUEST_TIMESTAMP'			=> date('Y-m-d H:i:s'),
					'CLIENT_NO'					=> $account[0]->CLIENT_NO,
					'CLIENT_TERMINAL'			=> $this->input->ip_address()
		);

			

		if ( $this->initiate_transfer($data)){

			//$this->update_balance($updated_balance_params)
			
			// send an email notification to the sender
			$sender_client_no = $account[0]->CLIENT_NO;
			$type = 'OBT';
			$this->user_transactions_model->send_email_confirmation($sender_client_no,$data,$type);

			$params = array('response' => 200,'msg' => 'Transfer has been received.');
			return $this->toJson($params);
		}

			$params = array('response' => 500,'msg' => 'Transfer has been aborted. Transfer error.');
			return $this->toJson($params);


	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $acct_no  (description)
	 *
	 * @return     <type>
	 */
	public function new_multiple_transfer($acct_no)		
	{
		$this->load->model('accounts_model');
		$this->load->model('accounts_model');
		$this->load->model('currency_model');
		$this->load->model('clients_model');
		$client_no = $this->session->userdata('client_no');
		// check if the account exist
		$account = $this->accounts_model->check_account_number($acct_no);

		if ( ! $account ){

			$params = array('response' => 500,'msg' => 'Account number does not exist.');
			return $this->toJson($params);

		}
		$data['page'] 			= 'FT';
		$data['banks']  		= $this->clients_model->get_banks();
		$data['currencies'] 	= $this->currency_model->get_all();
		$data['account'] 		= $this->accounts_model->get_acocunt_details($acct_no);
		$data['user_accounts'] 	= $this->accounts_model
						->get_client_remaining_accounts($client_no,$acct_no);

		return $this->render('transactions/fund_transfer_multiple',$data);
	}


	public function negate($value)
	{
		return $value * -1;
	}


	/**
	 * Initiate the fund transfer process.
	 *
	 * @param      array     $data
	 *
	 * @return     Response
	 */
	private function initiate_transfer($data)
	{
		$this->load->model('user_transactions_model');
		
		return $this->user_transactions_model->transfer_funds($data);
		
		
	}


	/**
	 * Get all the transactions based on a certain account.
	 *
	 * @param      int       $acct_no
	 *
	 * @return     Response
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
	 *
	 * @param      string    $ccy_from
	 * @param      string    $ccy_to
	 *
	 * @return     Response
	 */
	public function get_conversion_rate($ccy_from,$ccy_to)
	{
		$this->load->model('currency_rates_model');
		return $this->currency_rates_model->get_currency_rate($ccy_from,$ccy_to);
	}

	

	/**
	 * Grab the client details from the async request.
	 *
	 * @param      int       $acct_no
	 *
	 * @return     Response
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
	 *
	 * @return     Response
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
	 *
	 * @param      array     $value
	 *
	 * @return     Response
	 */
	public function toJson($value='')
	{
		 return $this->output->set_content_type('application/json')
            ->set_output(json_encode($value));
	}

	/**
	 * Render the specifed view
	 *
	 * @param      string  $path
	 * @param      array   $data
	 *
	 * @return     Response
	 */
	public function render($path,$data)
	{
		$this->load->view('layouts/header',$data);
		$this->load->view($path,$data);
	}
	

}
