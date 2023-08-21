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
$routes->get('teste', 'Home::teste');

$routes->get('disconnected', 'Home::sair');
$routes->get('sendtest',     'Home::sendtest');
$routes->get('lang/{locale}', 'Home::lang');

//grupo login
$routes->group('login', static function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('/', 'Auth::auth');
    $routes->get('signup', 'Auth::signup');
    $routes->post('signup', 'Auth::newuser');
});




//dashboard 
$routes->get('dashboard/block', 'Dashboard::block', ['filter' => \App\Filters\LoggedIn::class]);

$routes->group('dashboard', ['filter' => [\App\Filters\LoggedIn::class, \App\Filters\PlanFilter::class]], static function ($routes) {
    //menu
    $routes->get('', 'Dashboard::index');
    $routes->get('campaigns', 'Dashboard::campaigns');
    $routes->get('instances', 'Dashboard::instance');
    $routes->get('tasks', 'Dashboard::tasks');
    $routes->get('leads', 'Dashboard::leads');
    $routes->get('synchronize', 'Dashboard::synchronize');
    $routes->get('support', 'Dashboard::support');
    $routes->get('help', 'Dashboard::help');

    //perfil
    $routes->get('profile', 'Dashboard::index');
    $routes->get('config', 'Dashboard::index');
    $routes->get('plan', 'Dashboard::index');
    
    //acoes
    $routes->get('block', 'Dashboard::block');
    
});



//chatwoot frontend
$routes->group('chatwoot', ['filter' => 'loggedchatwoot', 'namespace' => 'App\Controllers\Chatwoot'], static function ($routes) {
    $routes->get('',          'Home::index');
    $routes->get('home',      'Home::index');
    $routes->get('campanhas', 'Home::campanhas');
    $routes->get('campanhas/(:num)', 'Home::campanhas/$1');
});

//API'S

use API\Admin as APIAdmin;
use API\Campaigns as APICampaigns;
use API\Config as APIConfig;
use API\Contacts as APIContacts;
use API\Groups as APIGroups;
use API\Instances as APIInstances;
use API\Users as APIUsers;

$routes->get('api/v1/auth/(:any)/(:any)', 'API\Users::auth/$1/$2');

$routes->group('api/v1', ['filter' => 'logged'], static function ($routes) {
    $routes->resource('admin',     ['controller' => APIAdmin::class]);     //
    $routes->resource('contacts',  ['controller' => APIContacts::class]);  //
    $routes->resource('config',    ['controller' => APIConfig::class]);    //
    $routes->resource('campaigns', ['controller' => APICampaigns::class]);

    $routes->group('groups', ['namespace' => 'App\Controllers'], static function ($routes) {
        $routes->resource('',    ['controller' => APIGroups::class]);
        $routes->post('send', 'API\Groups::sendMessage');
    });    //

    $routes->resource('instances', ['controller' => APIInstances::class]); //
    $routes->group('instances', static function ($routes) {
        $routes->post('disconnect', 'API\Instances::disconnect'); //
        $routes->post('restart', 'API\Instances::restart'); //
        $routes->post('conectar', 'API\Instances::conectar'); //
    });

    $routes->resource('users',     ['controller' => APIUsers::class]);     //
    
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
