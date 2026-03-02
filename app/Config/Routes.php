<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('AuthController');
$routes->setDefaultMethod('login');
$routes->setAutoRoute(false);

// AUTH
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::process');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
| role : superadmin
*/
$routes->group('superadmin', ['filter' => 'role:superadmin'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'SuperadminController::index');

    // Companies
    $routes->get('companies', 'CompanyController::index');
    $routes->get('companies/create', 'CompanyController::create');
    $routes->post('companies/store', 'CompanyController::store');
    $routes->get('companies/edit/(:num)', 'CompanyController::edit/$1');
    $routes->post('companies/update/(:num)', 'CompanyController::update/$1');
    $routes->get('companies/delete/(:num)', 'CompanyController::delete/$1');
    $routes->get('companies/status/(:num)', 'CompanyController::toggleStatus/$1');

    // Users
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');
    $routes->get('users/status/(:num)', 'UserController::toggleStatus/$1');

    // Roles & Permissions
    $routes->get('roles', 'RoleController::index');
    $routes->get('roles/edit/(:num)', 'RoleController::edit/$1');
    $routes->post('roles/update/(:num)', 'RoleController::update/$1');

    // Monitoring
    $routes->get('monitoring', 'MonitoringController::index');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| role : admin
*/
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'AdminController::index');

    // Projects
    $routes->get('projects', 'ProjectController::index', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/(:num)', 'ProjectController::show/$1', [
        'filter' => 'permission:view_projects'
    ]);
    $routes->get('projects/create', 'ProjectController::create', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->post('projects/store', 'ProjectController::store', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/edit/(:num)', 'ProjectController::edit/$1', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->post('projects/update/(:num)', 'ProjectController::update/$1', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/delete/(:num)', 'ProjectController::delete/$1', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/status/(:num)', 'ProjectController::toggleStatus/$1', [
        'filter' => 'permission:manage_projects'
    ]);

    // Teams
    $routes->get('teams', 'TeamController::index', [
        'filter' => 'permission:manage_teams'
    ]);

    // Issues
    $routes->get('issues', 'IssueController::index', [
        'filter' => 'permission:manage_issues'
    ]);

    // Reports
    $routes->get('reports', 'ReportController::index', [
        'filter' => 'permission:view_reports'
    ]);
});

/*
|--------------------------------------------------------------------------
| CLIENT
|--------------------------------------------------------------------------
| role : client
*/
$routes->group('client', ['filter' => 'role:client'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'ClientController::index');

    // Projects
    $routes->get('projects', 'ClientProjectController::index', [
        'filter' => 'permission:view_projects'
    ]);

    // Progress
    $routes->get('progress', 'ClientProgressController::index', [
        'filter' => 'permission:view_progress'
    ]);

    // Issues
    $routes->get('issues', 'ClientIssueController::index', [
        'filter' => 'permission:create_issues'
    ]);
});

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
| role : staff
*/
$routes->group('staff', ['filter' => 'role:staff'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'StaffController::index');

    // Tasks
    $routes->get('tasks', 'TaskController::index', [
        'filter' => 'permission:view_tasks'
    ]);

    // Progress
    $routes->get('progress', 'StaffProgressController::index', [
        'filter' => 'permission:update_progress'
    ]);

    // Issues
    $routes->get('issues', 'StaffIssueController::index', [
        'filter' => 'permission:update_issues'
    ]);
});

/*
|--------------------------------------------------------------------------
| FORBIDDEN
|--------------------------------------------------------------------------
*/
$routes->get('/forbidden', 'ErrorController::forbidden');