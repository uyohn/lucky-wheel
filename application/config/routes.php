<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['test']['GET'] = 'Pages/testPage';

$route['admin/logout']['GET'] = 'Pages/logoutAction';
$route['admin/login']['GET'] = 'Pages/login';
$route['admin/login']['POST'] = 'Pages/loginAction';
$route['admin'] = 'Admin/index';
$route['admin/wheel/(:num)'] = 'Admin/singleWheel/$1';
$route['admin/export/wheel/(:num)'] = 'Admin/exportSingleWheel/$1';

$route['admin/wheel/(:num)/delete']['get'] = 'Admin/deleteWheel/$1';
$route['admin/wheel/(:num)/delete/winner/(:num)']['get'] = 'Admin/deleteWheelWinner/$1/$2';
$route['admin/new/wheel']['post'] = 'Admin/createWheel';
$route['admin/edit/wheel/(:num)']['post'] = 'Admin/editWheelByWheelNumber/$1';

$route['api/wheel/(:num)/options'] = 'Admin/getWheelOptions/$1';


$route['api/wheel/(:num)/create'] = 'Pages/apiCreateWheel/$1';
$route['api/wheel/(:num)/win/(:any)/(:num)'] = 'Pages/apiWheelWin/$1/$2/$3';
