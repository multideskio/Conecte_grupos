<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');



//rotas sem proteção
$routes->get('teste', 'Home::teste');

$routes->get('g/(:any)/(:any)', 'Home::group/$1/$2');

$routes->post('teste', 'Home::teste');

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
    $routes->get('campaigns/create', 'Dashboard::createCampaigns');
    $routes->get('campaigns/(:any)', 'Dashboard::campaigns');

    $routes->get('participants', 'Dashboard::participants');


    $routes->get('schedule/(:any)', 'Dashboard::scheduledsView/$1');


    $routes->get('send/(:any)', 'Dashboard::sendView/$1');


    $routes->get('instances', 'Dashboard::instance');
    $routes->get('files', 'Dashboard::files');
    $routes->get('tasks', 'Dashboard::tasks');
    $routes->get('leads', 'Dashboard::leads');
    $routes->get('synchronize', 'Dashboard::synchronize');
    $routes->get('support', 'Dashboard::support');
    $routes->get('help', 'Dashboard::help');


    $routes->get('groups', 'Dashboard::groupsView');


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

use API\Admin     as APIAdmin;
use API\Campaigns as APICampaigns;
use API\Config    as APIConfig;
use API\Contacts  as APIContacts;
use API\Groups    as APIGroups;
use API\Instances as APIInstances;
use API\Users     as APIUsers;
use API\Messages  as APIMessages;
use API\Webhook   as APIWebhook;
use API\Participants   as APIParticipants;

$routes->get('api/v1/auth/(:any)/(:any)', 'API\Users::auth/$1/$2');

//$routes->get('api/v1/webhook/(:any)', 'API\Webhook::events/$1');
$routes->post('api/v1/webhook/(:any)', 'API\Webhook::events/$1');

$routes->group('api/v1', ['filter' => 'logged'], static function ($routes) {

    $routes->get('messages/data/(:num)/(:any)', 'API\Messages::datatable/$1/$2');
    $routes->get('datatable/data/(:num)', 'API\Groups::datatable/$1');
    $routes->get('datatable/logs/(:num)', 'API\Groups::logs/$1');

    $routes->get('datatable/particpants/(:num)', 'API\Participants::datatable/$1');

    $routes->resource('admin',     ['controller' => APIAdmin::class]);     //
    $routes->resource('webhook',   ['controller' => APIWebhook::class]);   //
    $routes->resource('contacts',  ['controller' => APIContacts::class]);  //
    $routes->resource('config',    ['controller' => APIConfig::class]);    //

    //Busca slugs existentes
    $routes->get('campaigns/slug/(:any)', 'API\Campaigns::verifySlug/$1');


    $routes->resource('campaigns', ['controller' => APICampaigns::class]); //
    $routes->resource('messages',  ['controller' => APIMessages::class]);  //

    $routes->group('groups', ['namespace' => 'App\Controllers'], static function ($routes) {
        $routes->post('send', 'API\Groups::sendMessage');
        $routes->put('sincronize/(:any)', 'API\Groups::sincronize/$1');

        $routes->post('scheduleds', 'API\Groups::scheduleds');
    });    //

    $routes->resource('groups',    ['controller' => APIGroups::class]);

    $routes->resource('instances', ['controller' => APIInstances::class]); //
    $routes->group('instances', static function ($routes) {
        $routes->post('disconnect', 'API\Instances::disconnect'); //
        $routes->post('restart', 'API\Instances::restart'); //
        $routes->post('conectar', 'API\Instances::conectar'); //
    });

    $routes->resource('users',     ['controller' => APIUsers::class]);     //

    //
});
//AGENDAMENTO ACIONADO POR N8N
$routes->post('api/v1/auth/scheduleds/n8n', 'API\Groups::scheduledsn8n');
$routes->post('api/v1/auth/scheduleds/n8n/send/(:num)', 'API\Groups::scheduledsn8nsend/$1');
