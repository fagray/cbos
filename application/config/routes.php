<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'account';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['auth/login'] = 'auth/login';
$route['auth/validate'] = 'auth/post_login';
$route['sample'] = 'auth/sample';
$route['auth/session/logout'] = 'auth/destroy';
$route['accounts/transactions/transfer'] = 'account/get_transfer';
$route['accounts/transactions/(:num)/details'] = 'account/view_transaction_details/$1';
$route['accounts/(:num)/transfers/new'] = 'account/new_transfer/$1';
$route['accounts/(:num)/transfers/new/(:any)'] = 'account/new_multiple_transfer/$1';
$route['accounts/(:num)/transactions'] = 'account/get_transactions_by_account/$1';
$route['accounts/e-statements'] = 'account/get_account_statement';
$route['accounts/transactions/history'] = 'transaction/index';
$route['accounts/settings/change-password'] = 'auth/get_change_password';
$route['accounts/post_change_password'] = 'auth/post_change_new_account_password';

// helper routes && async request
$route['accounts/new/settings/(:any)/(:any)'] = 'auth/change_new_account_password'; // change password view
$route['accounts/settings/change_password'] = 'auth/post_change_new_account_password';
$route['accounts/async_get_details/(:num)'] = 'account/async_get_details/$1';
$route['accounts/async_cbos_process_transfer'] = 'account/async_cbos_post_transfer';
$route['accounts/async_other_process_transfer'] = 'account/async_others_post_transfer';
$route['accounts/transactions/aysnc_get_transactions'] = 'transaction/aysnc_get_transactions';
$route['accounts/async_check_account_number'] = 'account/aysnc_check_account_number';




$route['accounts/transactions/estatement/(:num)'] = 'transaction/view_estatement/$1';
$route['accounts/transactions/estatement/(:num)/download/pdf'] = 'transaction/download_in_pdf/$1';
$route['accounts/transactions/estatement/(:num)/download/csv'] = 'transaction/download_in_csv/$1';
$route['accounts/transactions/test'] = 'transaction/test_estatement';


$route['branches'] = 'branch/index';

/**
 * Admin Routes
 */

// Main Routes
$route['acesmain'] ='admin/auth'; 
$route['acesmain/logout'] ='admin/auth/destroy'; 
$route['acesmain/auth/validate'] ='admin/auth/post_login'; 
$route['acesmain/home'] ='admin/main'; 
$route['acesmain/clients'] ='admin/clients/index'; 
$route['acesmain/clients/(:num)/details'] ='admin/clients/view/$1'; 
$route['acesmain/clients/(:num)/transactions'] ='admin/client_accounts/get_all_transactions/$1'; 
$route['acesmain/system/clients/(:any)'] ='admin/client_accounts/create'; 
$route['acesmain/system/clients/access/process'] ='admin/client_accounts/store'; 
$route['acesmain/transactions'] ='admin/user_transactions/index'; 
$route['acesmain/transactions/(:any)/details'] ='admin/user_transactions/view/$1'; 
$route['acesmain/system/currency/rates'] ='currency/index'; 
$route['acesmain/system/currency/rates/new'] ='currency/insert'; 
$route['acesmain/system/currency/rates/update'] ='currency/update_conv_rate'; 


// Helper Routes and async request
$route['acesmain/system/misc/accounts/generate-password'] = 'admin/auth/generate_password';
$route['acesmain/clients/find'] = 'clients/find'; // async request for clients searching
$route['acesmain/clients/access/remove'] = 'admin/client_accounts/remove_access'; // async request for clients searching
$route['acesmain/transactions/process'] = 'admin/user_transactions/process_request'; // async request for clients searching
$route['acesmain/accounts/change_password'] = 'admin/client_accounts/chage_client_password'; // async request for changing password
$route['acesmain/accounts/search'] = 'admin/client_accounts/find_account_details'; // async request for finding account details
$route['acesmain/clients/accounts/list'] = 'admin/client_accounts/accounts_list'; // async request for finding account details

$route['acesmain/accounts/logout'] = 'admin/client_accounts/logout_user'; // async request for logging out a user
