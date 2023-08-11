<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
$routes->get('/', 'Home::index');
//$routes->get('/groups', 'Home::groups');

//rotas sem proteção

$routes->get('/disconnected', 'Home::sair');

$routes->group('login', static function ($routes) {
    $routes->get('/', 'Auth::index');
});

//chatwoot frontend
$routes->group('chatwoot', ['filter' => 'loggedchatwoot', 'namespace' => 'App\Controllers\Chatwoot'], static function ($routes) {
    $routes->get('',          'Home::index');
    $routes->get('home',      'Home::index');
    $routes->get('campanhas', 'Home::campanhas');
    $routes->get('campanhas/(:num)', 'Home::campanhas/$1');
});

//API'S
use API\Admin;
use API\Contacts;
use API\Config;
use API\Groups;
use API\Instances;
use API\Users;

$routes->get('api/v1/auth/(:any)/(:any)', 'API\Users::auth/$1/$2'); 

$routes->group('api/v1', ['filter' => 'logged'], static function ($routes) {
    $routes->resource('admin',     ['controller' => Admin::class]);     //
    $routes->resource('contacts',  ['controller' => Contacts::class]);  //
    $routes->resource('config',    ['controller' => Config::class]);    //

    $routes->group('groups', ['namespace' => 'App\Controllers'], static function ($routes) {
        $routes->resource('',    ['controller' => Groups::class]);
        $routes->post('send', 'API\Groups::sendMessage');
    });    //
    $routes->resource('instances', ['controller' => Instances::class]); //
    $routes->resource('users',     ['controller' => Users::class]);     //
        //
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
