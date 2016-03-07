<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	/**
	 * Show the transaction history.
	 * @return Response 
	 */
	public function index()
	{
		if(!$this->session->userdata('access_token')){

			return redirect(base_url('auth/login'));
		}

		$data['page']  = 'TH';
		$client_no = $this->session->userdata('client_no');
		$this->load->model('currency_model');
		$this->load->model('accounts_model');
		$data['accounts'] = $this->accounts_model->get_client_accounts($client_no);
		$data['currencies'] = $this->currency_model->get_all();
		$this->load->model('transactions_model');
		$data['title'] = 'Transaction History';
		$data['transactions'] = $this->transactions_model->get_all();
		// return $data['transactions'] = $this->transactions_model->get_all();
		$this->render('transactions/history',$data);
	}

	// test only
	public function test_estatement()
	{
		$this->load->model('transactions_model');
		$this->load->model('account_bal_model');
		//static data 
		$unformatted_start_date = '2016-01-26';
		$unformatted_end_date = '2016-02-02';
		$formatted_start_date = new DateTime($unformatted_start_date);
		$start_date  = $formatted_start_date->format('M d,Y');
		$internal_key = 822;
		$start_balance =  $this->account_bal_model->get_start_balance($internal_key,$unformatted_start_date);
		$data['params'] = array('start_date' => $start_date,'op_bal' => $start_balance);
		
		
		$data['transactions'] = $this->transactions_model
				->get_trans_history($unformatted_start_date,$unformatted_end_date,$internal_key);

		return $this->render('transactions/test_estatement',$data);

	}

	/**
	 * Filter user transactions and prepare estatement
	 * @return Response 
	 */
	public function aysnc_get_transactions()
	{
		// some code here
		$this->load->model('accounts_model');
		$this->load->model('account_bal_model');
		$this->load->model('transactions_model');
		$client_no 	= 	$this->session->userdata('client_no');
		$start_date = 	$this->input->get('start_date');
		$end_date = 	$this->input->get('end_date');
		$ccy = 			$this->input->get('ccy');
		$acct_no = 		$this->input->get('acct_no');
		$account = 		$this->accounts_model->get_account($client_no,$acct_no);
		
		if ( count($account) < 1 ){

			//account not found
			return show_error('Account not found',500);
		}

		$internal_key = $account[0]->INTERNAL_KEY;
		$data['transactions'] = $this->transactions_model->get_trans_history($start_date,$end_date,$internal_key);

		 $start_balance =  $this->account_bal_model->get_start_balance($internal_key,$start_date);
		// return print $this->transactions_model->get_back_date_amt($internal_key,$start_date);
		// $end_balance = $this->transactions_model
		// 					->get_end_balance($internal_key,$start_date,															$end_date,$start_balance);
		
		$end_balance = $this->account_bal_model->get_end_balance($internal_key,$end_date);
		if ( count( $account) < 1){

			return new Exception('Account not found');
		}

		// return $this->output
		// 	->set_content_type('application/json')
		// 	->set_output(json_encode($data));
		
		$branch_name = $this->get_branch_name($account[0]->BRANCH);
		$ccy_desc = $this->get_ccy_desc($account[0]->CCY);

		// statement header params
		$data = array(

					'INTERNAL_KEY'			=> $internal_key,
					'CONTACT_TYPE'			=> NULL,
					'ACCT_NO'				=> $acct_no,
					'ACCT_DESC'				=> $account[0]->ACCT_DESC,
					'CCY'					=> $account[0]->CCY,
					'CCY_DESC'				=> $ccy_desc,
					'BRANCH'				=> $account[0]->BRANCH,
					'BRANCH_NAME'			=> $branch_name,
					'NAME'					=> $account[0]->CLIENT_SHORT,
					'ADDR1'					=> NULL,
					'ADDR2'					=> NULL,
					'ADDR3'					=> NULL,
					'ADDR4'					=> NULL,
					'POSTAL_CODE'			=> NULL,
					'START_BALANCE'			=> $start_balance,
					'END_BALANCE'			=> $end_balance,
					'START_DATE'			=> $start_date,
					'END_DATE'				=> $end_date,
					'PRINT_PRIORITY'		=> 'N',
					'STMT_HANDLING'			=> 'CO',
					'OFFICER_ID'			=> $this->session->userdata('usrname'),
					'SID'					=> NULL
			);
		$seq_no = $this->insert_to_stmt_header($data);

		if ( isset($seq_no)  ){

			$params = array(

						'seq_no' => $seq_no,'response' => 200, 
						'msg' => 'eStatement has been prepared successfully.');
		}else{

			$params = array(
						'response' => 500, 'msg' => 'An error occured.Please try again.');

		}

		return $this->toJson($params);



	}

	public function get_branch_name($branch)
	{
		$this->load->model('branch_model');
		return $this->branch_model->get_branch_name($branch);
	}

	public function get_ccy_desc($ccy)
	{

		$this->load->model('currency_model');
		return $this->currency_model->get_description($ccy);
	}

	/**
	 * Insert to the statement header table.
	 * @param  array $data 
	 * @return Response       
	 */
	public function insert_to_stmt_header($data)
	{
		$this->load->model('statement_header_model');
		return $this->statement_header_model->insert($data);
	}

	/**
	 * View the generated estatement
	 * @param  int $seq_no 
	 * @return Response         
	 */
	public function view_estatement($seq_no)
	{
		$this->load->model('statement_header_model');
		// $this->load->library('m_pdf');
		$this->load->model('transactions_model');
		$statement = $this->statement_header_model->get_statement($seq_no);
		$start_date = $statement[0]->START_DATE;
		$end_date = $statement[0]->END_DATE;
		// return print $end_date;
		$internal_key = $statement[0]->INTERNAL_KEY;
		$data['statement'] = $statement[0];

		// return print_r($statement);
		$data['transactions'] = $this->transactions_model
				->get_trans_history($start_date,$end_date,$internal_key);
		
		$data['start_date'] = $this->formatDate($start_date);
		$data['end_date'] = $this->formatDate($end_date);


		// return print_r($data['transactions']);
		return $this->render('transactions/view_statement3',$data);
	}

	/**
	 * Convert the estatement to pdf format
	 * @param  int $seq_no 
	 * @return Response
	 */
	public function download_in_pdf($seq_no)
	{
		$this->load->model('statement_header_model');
		// $this->load->library('m_pdf');
		$this->load->model('transactions_model');
		$statement = $this->statement_header_model->get_statement($seq_no);
		$start_date = $statement[0]->START_DATE;
		$end_date = $statement[0]->END_DATE;
		$internal_key = $statement[0]->INTERNAL_KEY;
		$data['statement'] = $statement[0];

		// return print_r($statement);
		$data['transactions'] = $this->transactions_model
				->get_trans_history($start_date,$end_date,$internal_key);

		$data['start_date'] = $this->formatDate($start_date);
		$data['end_date'] = $this->formatDate($end_date);


		 $this->load->helper('dompdf');
		 $html = $this->load->view('transactions/view_statement2', $data, true);
     	 return pdf_create($html, 'eStatement as of  '.$start_date. ' to' .$end_date);
	}

	/**
	 * Convert the estatement to csv format
	 * @param  int $seq_no 
	 * @return Response
	 */
	public function download_in_csv($seq_no)
	{
		$this->load->model('statement_header_model');
		// $this->load->library('m_pdf');
		$this->load->model('transactions_model');
		$statement 				= $this->statement_header_model->get_statement($seq_no);
		$start_date 			= $statement[0]->START_DATE;
		$end_date 				= $statement[0]->END_DATE;
		$internal_key 			= $statement[0]->INTERNAL_KEY;
		$data['statement'] 		= $statement[0];

		// return print_r($statement);
		$data['transactions'] = $this->transactions_model
				->get_trans_history($start_date,$end_date,$internal_key);

		$data['start_date'] = $this->formatDate($start_date);
		$data['end_date'] = $this->formatDate($end_date);

		// prepare the csv file
		 $this->load->helper('csv');
		

		$array = array(
			array('Last Name', 'First Name', 'Gender'),
			array('Furtado', 'Nelly', 'female'),
			array('Twain', 'Shania', 'female'),
			array('Farmer', 'Mylene', 'female')
		);
		 
		 // $csv_array_header = array(
		 // 							'Transaction Date',
		 // 							'Transaction Desc',
		 // 							'Cheque/ Seq.No',
		 // 							'Withdrawal',
		 // 							'Deposit',
		 // 							'Balance',
		 // 						);
		return array_to_csv($array, TRUE, 'toto.csv');
		
	}

	public function toJson($value)
	{
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($value));
	}

	public function formatDate($value)
	{
		$d = new DateTime($value);
		return $d->format('M d,Y');
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
