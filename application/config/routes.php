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
$route['default_controller'] = 'front_office/c_login/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// custom awank
$route['404']      = 'dashboard/c_404';

$route['dashboard']      = 'dashboard/c_dashboard';
// $route['profil']      	 = 'base/c_profil';

$route['areaduduk']      = 'master/c_areaduduk';
$route['meja']           = 'master/c_meja';
$route['satuan']         = 'master/c_satuan';
$route['bahan']          = 'master/c_bahan';
$route['kategori']       = 'master/c_kategori';
$route['menu']           = 'master/c_menu';

$route['inventorybahan'] = 'transaksi/c_inventorybahan';

$route['bill']     = 'keuangan/c_bill';
$route['pendapatan']     = 'keuangan/c_pendapatan';
$route['belanjabahan']   = 'keuangan/c_belanjabahan';
$route['pindahbuku']     = 'keuangan/c_pindahbuku';
$route['pendingbill']     = 'keuangan/c_pendingbill';

$route['pegawai']        = 'master/c_pegawai';
$route['profil']         = 'master/c_constants';


// waiter
$route['order/(:any)'] = "waiter/c_waiter/order/$1";
$route['take_order'] = "waiter/c_waiter/take_order";

//kasir
$route['kasir'] = "kasir/c_kasir";
$route['kasir/audit'] = "kasir/c_transaksi/audit";
$route['kasir/report_audit'] = "kasir/c_transaksi/report_audit";