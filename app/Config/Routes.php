<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/admin', 'AdminController::index');
$routes->get('/admin/create', 'AdminController::create');
$routes->post('/admin/store', 'AdminController::store');
$routes->get('/admin/edit/(:num)', 'AdminController::edit/$1');
$routes->post('/admin/update/(:num)', 'AdminController::update/$1');
$routes->get('/admin/delete/(:num)', 'AdminController::delete/$1');

$routes->get('/kurir', 'KurirController::index');
$routes->get('/kurir/create', 'KurirController::create');
$routes->post('/kurir/store', 'KurirController::store');
$routes->get('/kurir/edit/(:num)', 'KurirController::edit/$1');
$routes->post('/kurir/update/(:num)', 'KurirController::update/$1');
$routes->get('/kurir/delete/(:num)', 'KurirController::delete/$1');


$routes->get('/login', 'LoginController::index');
$routes->post('/login/auth', 'LoginController::auth');
$routes->get('/logout', 'LoginController::logout');

$routes->get('/', 'Home::index', ['filter' => 'auth']);


$routes->get('/admin', 'AdminController::index');
$routes->get('/kurir', 'KurirController::index');
$routes->get('/pengantaran', 'PengantaranController::index');
$routes->get('/bukti', 'BuktiController::index');
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}