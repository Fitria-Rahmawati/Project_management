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

// ================= SUPERADMIN =================
$routes->group('superadmin', ['filter' => 'auth,role:superadmin'], function ($routes) {
    $routes->get('companies', 'CompanyController::index');
    $routes->get('users', 'UserController::index');
    $routes->get('roles', 'RoleController::index');
    $routes->get('monitoring', 'MonitoringController::index');
});

// ================= ADMIN =================
$routes->group('admin', ['filter' => 'auth,role:admin'], function ($routes) {
    $routes->get('projects', 'ProjectController::index');
    $routes->get('teams', 'TeamController::index');
    $routes->get('issues', 'IssueController::index');
    $routes->get('reports', 'ReportController::index');
});

// ================= CLIENT =================
$routes->group('client', ['filter' => 'auth,role:client'], function ($routes) {
    $routes->get('projects', 'ClientProjectController::index');
    $routes->get('progress', 'ClientProgressController::index');
    $routes->get('issues', 'ClientIssueController::index');
});

// ================= STAFF =================
$routes->group('staff', ['filter' => 'auth,role:staff'], function ($routes) {
    $routes->get('tasks', 'TaskController::index');
    $routes->get('progress', 'StaffProgressController::index');
    $routes->get('issues', 'StaffIssueController::index');
});