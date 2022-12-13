<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Login::index', ['namespace' => 'App\Controllers']);
$routes->get('/logout', 'Login::logout', ['namespace' => 'App\Controllers']);
$routes->post('/', 'Login::post', ['namespace' => 'App\Controllers']);
$routes->get('/home', 'Home::index', ['namespace' => 'App\Controllers']);
$routes->get('/user', 'User::index', ['namespace' => 'App\Controllers']);
$routes->post('/user', 'User::store', ['namespace' => 'App\Controllers']);
$routes->get('/user/status/(:num)', 'User::status/$1', ['namespace' => 'App\Controllers']);
$routes->get('/user/(:num)', 'User::edit/$1', ['namespace' => 'App\Controllers']);
$routes->put('/user/(:num)', 'User::put/$1', ['namespace' => 'App\Controllers']);
$routes->get('/user/create', 'User::create', ['namespace' => 'App\Controllers']);
$routes->delete('/user', 'User::trash', ['namespace' => 'App\Controllers']);
$routes->get('/install', 'Install::index', ['namespace' => 'App\Controllers']);
$routes->post('/install', 'Install::store', ['namespace' => 'App\Controllers']);
$routes->get('/worker', 'Worker::index', ['namespace' => 'App\Controllers']);
$routes->post('/worker', 'Worker::store', ['namespace' => 'App\Controllers']);
$routes->get('/worker/except', 'Worker::exceptWorker', ['namespace' => 'App\Controllers']);
$routes->get('/worker/create', 'Worker::create', ['namespace' => 'App\Controllers']);
$routes->get('/worker/status/(:num)', 'Worker::status/$1', ['namespace' => 'App\Controllers']);
$routes->get('/worker/(:num)', 'Worker::edit/$1', ['namespace' => 'App\Controllers']);
$routes->put('/worker/(:num)', 'Worker::put/$1', ['namespace' => 'App\Controllers']);
$routes->delete('/worker', 'Worker::trash', ['namespace' => 'App\Controllers']);

$routes->get('/calc', 'Calc::index', ['namespace' => 'App\Controllers']);
$routes->get('/calc/create', 'Calc::create', ['namespace' => 'App\Controllers']);
$routes->get('/calc/(:num)', 'Calc::edit/$1', ['namespace' => 'App\Controllers']);
$routes->get('/calc/detail/(:num)', 'Calc::detail/$1', ['namespace' => 'App\Controllers']);
$routes->put('/calc/(:num)', 'Calc::put/$1', ['namespace' => 'App\Controllers']);
$routes->post('/calc', 'Calc::store', ['namespace' => 'App\Controllers']);
$routes->delete('/calc', 'Calc::trash', ['namespace' => 'App\Controllers']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}