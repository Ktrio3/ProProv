<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/login', 'Login::index', ['as' => "login"]);
$routes->post('/login', 'Login::login');

$routes->get('/logout', 'Login::logout');

//$routes->get('/video-test', 'Training1::bypass');

$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Home::index');
    // $routes->get('/dump', 'Home::dump');

    $routes->get('/demographics', 'Demographics::index');
    $routes->get('/demographics/(:num)', 'Demographics::questions/$1');
    $routes->post('/demographics/(:num)', 'Demographics::submit/$1');

    $routes->get('/training-1', 'Training1::index');
    $routes->get('/training-1/(:num)', 'Training1::training/$1');
    $routes->post('/training-1', 'Training1::save');

    $routes->get('/training-2', 'Training2::index');
    $routes->get('/training-2/(:num)', 'Training2::training/$1');
    $routes->post('/training-2', 'Training2::save');

    $routes->get('training-materials', 'TrainingMats::index');
    $routes->get('training-materials/rego', 'TrainingMats::rego');
    $routes->get('training-materials/prov', 'TrainingMats::prov');
    $routes->get('training-materials/proprov', 'TrainingMats::proprov');

    $routes->get('/proprov', 'Proprov::index');
    $routes->get('/proprov/(:num)', 'Proprov::task/$1');
    $routes->post('/proprov/(:num)', 'Proprov::run/$1');
    $routes->post('/proprov-check', 'Proprov::check');
    $routes->post('/proprov-time', 'Proprov::checkTime');

    $routes->get('/rego', 'Rego::index');
    $routes->get('/rego/(:num)', 'Rego::task/$1');
    $routes->post('/rego/(:num)', 'Rego::run/$1');
    $routes->post('/rego-check', 'Rego::check');
    $routes->post('/rego-time', 'Rego::checkTime');

    $routes->get('/exit', 'ExitSurvey::index');
    $routes->get('/exit/(:num)', 'ExitSurvey::questions/$1');
    $routes->post('/exit/(:num)', 'ExitSurvey::submit/$1');
});



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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
