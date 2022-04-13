<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* 

Customer Routes

*/
// AUTH
$route['register'] = 'CustomerController/register';
$route['do_register'] = 'CustomerController/do_register';
$route['login'] = 'CustomerController/login';
$route['do_login'] = 'CustomerController/do_login';
$route['logout'] = 'CustomerController/logout';
// PROFILE
$route['profile'] = 'CustomerController/profile';
$route['update_profile'] = 'CustomerController/update_profile';
//DASHBOARD
$route['dashboard'] = 'CustomerController/dashboard';
//Buy Service
$route['buy_service/(:num)'] = 'CustomerController/buy_service/$1';
$route['checkout'] = 'CustomerController/checkout';
//ORDERS
$route['orders'] = 'CustomerController/orders';

/* 

Service Provider Routes

*/
// AUTH
$route['provider/register'] = 'ProviderController/register';
$route['provider/do_register'] = 'ProviderController/do_register';
$route['provider/login'] = 'ProviderController/login';
$route['provider/do_login'] = 'ProviderController/do_login';
$route['provider/logout'] = 'ProviderController/logout';
// PROFILE
$route['provider/profile'] = 'ProviderController/profile';
$route['provider/update_profile'] = 'ProviderController/update_profile';
//DASHBOARD
$route['provider/dashboard'] = 'ProviderController/dashboard';
//SERVICES CRUD
$route['provider/services'] = 'ProviderController/services';
$route['provider/add_service'] = 'ProviderController/add_service';
$route['provider/store_service'] = 'ProviderController/store_service';
$route['provider/edit_service/(:num)'] = 'ProviderController/edit_service/$1';
$route['provider/update_service/(:num)'] = 'ProviderController/update_service/$1';
$route['provider/delete_service/(:num)'] = 'ProviderController/delete_service/$1';
//ORDERS
$route['provider/orders'] = 'ProviderController/orders';
$route['provider/accept_order/(:num)'] = 'ProviderController/accept_order/$1';
$route['provider/reject_order/(:num)'] = 'ProviderController/reject_order/$1';

