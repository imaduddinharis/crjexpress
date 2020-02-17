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
$route['default_controller'] = 'routing/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dev'] = 'dev';
$route['dev/sync'] = 'dev/sync';

$route['auth'] = 'auth';
$route['auth/login'] = 'auth/login';

$route['dashboard'] = 'Company/dashboard';

$route['package'] = 'Company/package';
$route['pickup-package'] = 'Company/package/picked';
$route['package/pickup'] = 'Company/package/pickup';
$route['package/drop'] = 'Company/package/drop';
$route['package/receive'] = 'Company/package/receive';
$route['package/detail/(:num)'] = 'Company/package/detail/$1';
$route['package/new-package'] = 'Company/package/add';
$route['package/create'] = 'Company/package/create';
$route['package/invoice/(:any)'] = 'Company/package/invoice/$1';

$route['manage-user'] = 'Company/user';
$route['manage-user/add'] = 'Company/user/add';
$route['manage-user/detail/(:num)'] = 'Company/user/detail/$1';
$route['manage-user/delete'] = 'Company/user/delete';
$route['manage-user/create'] = 'Company/user/create';

$route['price-rules'] = 'Company/price';
$route['price-rules/location'] = 'Company/price/location';
$route['price-rules/location/add'] = 'Company/price/location_add';
$route['price-rules/location/create'] = 'Company/price/location_create';
$route['price-rules/service'] = 'Company/price/service';
$route['price-rules/service/add'] = 'Company/price/service_add';
$route['price-rules/service/create'] = 'Company/price/service_create';

$route['branch-office'] = 'Company/branch_office';
$route['branch-office/add'] = 'Company/branch_office/add';
$route['branch-office/create'] = 'Company/branch_office/create';

$route['office-area'] = 'Company/area';
$route['office-area/add'] = 'Company/area/add';
$route['office-area/create'] = 'Company/area/create';
$route['office-area/add-branch-office/(:num)'] = 'Company/area/add_branch_office/$1';
$route['office-area/create-branch-office'] = 'Company/area/create_branch_office';
$route['office-area/detail/(:num)'] = 'Company/area/detail/$1';

$route['home'] = 'Customer/home';
$route['login'] = 'Customer/login';
$route['login/post'] = 'Customer/login/post';
$route['logout']    = 'Customer/login/logout';
$route['register'] = 'Customer/register';
$route['register/post'] = 'Customer/register/post';
$route['service-crj-express'] = 'Customer/home/service';
$route['feature-crj-express'] = 'Customer/product';
$route['feature-crj-express/pulsa-pra-bayar'] = 'Customer/product/prepaid_mobile';
$route['feature-crj-express/pulsa-pasca-bayar'] = 'Customer/product/postpaid_mobile';
$route['feature-crj-express/pulsa-pra-bayar/top-up-pulsa'] = 'Customer/product/top_up_pulsa';
$route['feature-crj-express/top-up/success'] = 'Customer/product/success';
$route['topup-saldo'] = 'Customer/topup';
$route['topup-saldo/process'] = 'Customer/topup/process';
$route['tracking-crj-express'] = 'Customer/tracking';
$route['callback-url'] = 'Customer/product/notify';
$route['feature-crj-express/pulsa-pasca-bayar/pay'] = 'Customer/product/pay_postpaid_mobile';
$route['feature-crj-express/listrik-pra-bayar'] = 'Customer/product/prepaid_el';
$route['feature-crj-express/listrik-pra-bayar/topup'] = 'Customer/product/prepaid_el_topup';
$route['feature-crj-express/voucher-games'] = 'Customer/product/voucher_games';
$route['feature-crj-express/e-money'] = 'Customer/product/emoney';
$route['feature-crj-express/voucher-games/topup'] = 'Customer/product/voucher_games_topup';
$route['feature-crj-express/e-money/topup'] = 'Customer/product/emoney_topup';

$route['feature-crj-express/listrik-pasca-bayar'] = 'Customer/product/postpaid_el';
$route['feature-crj-express/tagihan-bpjs'] = 'Customer/product/tagihan_bpjs';
$route['feature-crj-express/tagihan-gas'] = 'Customer/product/tagihan_gas';
$route['feature-crj-express/tagihan-pdam'] = 'Customer/product/tagihan_pdam';
$route['feature-crj-express/tagihan-telkom'] = 'Customer/product/tagihan_telkom';
$route['feature-crj-express/tagihan-finance'] = 'Customer/product/tagihan_finance';
$route['feature-crj-express/tagihan-finance/pay'] = 'Customer/product/tagihan_finance_pay';

$route['feature-crj-express/listrik-pasca-bayar/pay'] = 'Customer/product/postpaid_el_pay';
$route['feature-crj-express/tagihan-bpjs/pay'] = 'Customer/product/tagihan_bpjs_pay';
$route['feature-crj-express/tagihan-gas/pay'] = 'Customer/product/tagihan_gas_pay';
$route['feature-crj-express/tagihan-pdam/pay'] = 'Customer/product/tagihan_pdam_pay';
$route['feature-crj-express/tagihan-telkom/pay'] = 'Customer/product/tagihan_telkom_pay';

$route['ppob-transaction'] = 'Company/ppob';
$route['ppob-customer'] = 'Company/ppob/customer';

$route['forgot-password'] = 'Customer/Forgot_password';
$route['forgot-password/post'] = 'Customer/Forgot_password/post';
$route['forgot-password/confirm'] = 'Customer/Forgot_password/confirm';

$route['history'] = 'Customer/history';
$route['confirm'] = 'Customer/register/confirm';

$route['profile'] = 'Customer/profile';