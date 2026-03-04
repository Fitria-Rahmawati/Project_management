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
    $routes->get('dashboard', 'Dashboard::index');

    // Projects
    $routes->get('projects', 'Projects::index', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/(:num)', 'Projects::show/$1', [
        'filter' => 'permission:view_projects'
    ]);
    $routes->get('projects/create', 'Projects::create', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->post('projects/store', 'Projects::store', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/edit/(:num)', 'Projects::edit/$1', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->post('projects/update/(:num)', 'Projects::update/$1', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/delete/(:num)', 'Projects::delete/$1', [
        'filter' => 'permission:manage_projects'
    ]);
    $routes->get('projects/status/(:num)', 'Projects::toggleStatus/$1', [
        'filter' => 'permission:manage_projects'
    ]);

    // Teams
    $routes->get('teams', 'TeamController::index', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/(:num)', 'TeamController::show/$1', [
        'filter' => 'permission:view_teams'
    ]);
    $routes->get('teams/create', 'TeamController::create', [
        'filter' => 'permission:manage_teams'

    ]);
    $routes->post('teams/store', 'TeamController::store', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/edit/(:num)', 'TeamController::edit/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->post('teams/update/(:num)', 'TeamController::update/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/delete/(:num)', 'TeamController::delete/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/status/(:num)', 'TeamController::toggleStatus/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->post('teams/add_member/(:num)', 'TeamController::addMember/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/remove_member/(:num)/(:num)', 'TeamController::removeMember/$1/$2', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/assign_project/(:num)', 'TeamController::assignProject/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/unassign_project/(:num)', 'TeamController::unassignProject/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/projects/(:num)', 'TeamController::teamProjects/$1', [
        'filter' => 'permission:view_teams'
    ]);
    $routes->get('teams/members/(:num)', 'TeamController::teamMembers/$1', [
        'filter' => 'permission:view_teams'
    ]);
    $routes->get('teams/available_members/(:num)', 'TeamController::availableMembers/$1', [
        'filter' => 'permission:manage_teams'
    ]);

    // Issues
    $routes->get('issues', 'IssueController::index', [
        'filter' => 'permission:manage_issues'
    ]);
        $routes->get('issues/(:num)', 'IssueController::show/$1', [
            'filter' => 'permission:view_issues'
        ]);
    $routes->get('issues/create', 'IssueController::create', [
        'filter' => 'permission:create_issues'
    ]);
    $routes->post('issues/store', 'IssueController::store', [
        'filter' => 'permission:create_issues'
    ]);
    $routes->get('issues/edit/(:num)', 'IssueController::edit/$1', [
        'filter' => 'permission:update_issues'
    ]);
    $routes->post('issues/update/(:num)', 'IssueController::update/$1', [
        'filter' => 'permission:update_issues'
    ]);
    $routes->get('issues/delete/(:num)', 'IssueController::delete/$1', [
        'filter' => 'permission:manage_issues'
    ]);

    // Reports
    $routes->get('reports', 'ReportController::index', [
        'filter' => 'permission:view_reports'
    ]);
    $routes->get('reports/generate', 'ReportController::generate', [
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
$routes->get('forbidden', 'ErrorController::forbidden');
$routes->get('/forbidden', 'ErrorController::forbidden');
$routes->get('/403', 'ErrorController::forbidden');