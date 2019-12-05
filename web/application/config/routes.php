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
$route['default_controller'] = 'routing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dev'] = 'dev';
$route['dev/sync'] = 'dev/sync';

$route['auth'] = 'auth';
$route['auth/login'] = 'auth/login';

$route['dashboard'] = 'Company/dashboard';

$route['package'] = 'Company/package';
$route['package/detail/(:num)'] = 'Company/package/detail/$1';
$route['package/new-package'] = 'Company/package/add';
$route['package/create'] = 'Company/package/create';
$route['package/invoice/(:any)'] = 'Company/package/invoice/$1';

$route['manage-user'] = 'Company/user';
$route['manage-user/add'] = 'Company/user/add';
$route['manage-user/detal/(:num)'] = 'Company/user/detail/$1';
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