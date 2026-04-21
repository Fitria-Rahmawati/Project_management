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
// Register
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/process', 'RegisterController::process');

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
// Tambahkan route untuk profile (berlaku untuk semua role)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('profile', 'ProfileController::index');
    $routes->get('profile/edit', 'ProfileController::edit');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->get('profile/change-password', 'ProfileController::changePassword');
    $routes->post('profile/update-password', 'ProfileController::updatePassword');
    $routes->post('profile/upload-avatar', 'ProfileController::uploadAvatar');
    $routes->get('profile/remove-avatar', 'ProfileController::removeAvatar');

    $routes->get('notifications', 'NotificationController::index');
    $routes->get('notifications/read/(:num)', 'NotificationController::read/$1');
});
/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
| role : superadmin
*/
$routes->group('superadmin', ['filter' => 'role:superadmin'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Companies
    $routes->get('companies', 'CompanyController::index');
    $routes->get('companies/create', 'CompanyController::create');
    $routes->post('companies/store', 'CompanyController::store');
    $routes->get('companies/(:num)', 'CompanyController::show/$1');
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
 $routes->group('monitoring', ['namespace' => 'App\Controllers\superadmin'], function($routes) {
    $routes->get('/', 'MonitoringController::index');
    $routes->get('data', 'MonitoringController::data');
    $routes->get('chart', 'MonitoringController::chart');
    $routes->get('monitoring/export', 'MonitoringController::export');
 });
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
    $routes->get('admin/projects/get-pm/(:num)', 'Admin\Projects::getPM/$1');

    // Teams
    $routes->get('teams', 'ProjectMembers::index', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/(:num)', 'ProjectMembers::show/$1', [
        'filter' => 'permission:view_teams'
    ]);
    $routes->get('teams/create', 'ProjectMembers::create', [
        'filter' => 'permission:manage_teams'

    ]);
    $routes->post('teams/store', 'ProjectMembers::store', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/edit/(:num)', 'ProjectMembers::edit/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->post('teams/update/(:num)', 'ProjectMembers::update/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/delete/(:num)', 'ProjectMembers::delete/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/status/(:num)', 'ProjectMembers::toggleStatus/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->post('teams/add_member/(:num)', 'ProjectMembers::addMember/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/remove_member/(:num)/(:num)', 'ProjectMembers::removeMember/$1/$2', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/assign_project/(:num)', 'ProjectMembers::assignProject/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/unassign_project/(:num)', 'ProjectMembers::unassignProject/$1', [
        'filter' => 'permission:manage_teams'
    ]);
    $routes->get('teams/projects/(:num)', 'ProjectMembers::teamProjects/$1', [
        'filter' => 'permission:view_teams'
    ]);
    $routes->get('teams/members/(:num)', 'ProjectMembers::teamMembers/$1', [
        'filter' => 'permission:view_teams'
    ]);
    $routes->get('teams/available_members/(:num)', 'ProjectMembers::availableMembers/$1', [
        'filter' => 'permission:manage_teams'
    ]);

    // Issues
    $routes->get('issues', 'Issues::index', [
        'filter' => 'permission:manage_issues'
    ]);
        $routes->get('issues/(:num)', 'Issues::show/$1', [
            'filter' => 'permission:view_issues'
        ]);
    $routes->get('issues/create', 'Issues::create', [
        'filter' => 'permission:manage_issues'
    ]);
    $routes->post('issues/store', 'Issues::store', [
        'filter' => 'permission:manage_issues'
    ]);
    $routes->get('issues/edit/(:num)', 'Issues::edit/$1', [
        'filter' => 'permission:manage_issues'
    ]);
    $routes->post('issues/update/(:num)', 'Issues::update/$1', [
        'filter' => 'permission:manage_issues'
    ]);
    $routes->get('issues/delete/(:num)', 'Issues::delete/$1', [
        'filter' => 'permission:manage_issues'
    ]);
//employee
// Employees Management (tanpa filter admin dulu untuk test)
    $routes->get('employees', 'Employees::index', [
        'filter' => 'permission:view_employees'
    ]);
    $routes->get('employees/create', 'Employees::create', [
        'filter' => 'permission:manage_employees'
    ]);
    $routes->post('employees/store', 'Employees::store', [
        'filter' => 'permission:manage_employees'
    ]);
    $routes->get('employees/edit/(:num)', 'Employees::edit/$1', [
        'filter' => 'permission:manage_employees'
    ]);
    $routes->post('employees/update/(:num)', 'Employees::update/$1', [
        'filter' => 'permission:manage_employees'
    ]);
    $routes->get('employees/delete/(:num)', 'Employees::delete/$1', [
        'filter' => 'permission:manage_employees'
    ]);
    $routes->get('employees/show/(:num)', 'Employees::show/$1', [
        'filter' => 'permission:manage_employees'
    ]);
    $routes->get('employees/reset-password/(:num)', 'Employees::resetPassword/$1');

    // Reports
    $routes->group('reports', ['namespace' => 'App\Controllers\Admin'], function($routes) {
        $routes->get('/', 'ReportController::index');
        $routes->get('projects', 'ReportController::projects');
        $routes->get('issues', 'ReportController::issues');
        $routes->get('team', 'ReportController::team');
        $routes->get('clients', 'ReportController::clients');
        $routes->get('export/(:any)', 'ReportController::export/$1');
        $routes->get('print-team', 'ReportController::printTeam');
        $routes->get('print-projects', 'ReportController::printProjects');
        $routes->get('print-issues', 'ReportController::printIssues');
        $routes->get('print-clients', 'ReportController::printClients');
        $routes->get('export-projects', 'ReportController::exportProjectsPDF');
        $routes->get('export-issues', 'ReportController::exportIssuesPDF');
        $routes->get('export-team', 'ReportController::exportTeamPDF');
        $routes->get('export-client', 'ReportController::exportClientsPDF');
    });
});

/*
|--------------------------------------------------------------------------
| CLIENT
|--------------------------------------------------------------------------
| role : client
*/
$routes->group('client', ['filter' => 'role:client'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Projects
    $routes->get('projects', 'Client\ProjectController::index', [
        'filter' => 'permission:view_projects'
    ]);
    $routes->get('projects/(:num)', 'Client\ProjectController::show/$1', [
        'filter' => 'permission:view_projects'
    ]);
   $routes->post('projects/comment/(:num)', 'Client\ProjectController::addComment/$1'); 
     $routes->get('export-project/(:num)', 'Client\ProjectController::exportPdf/$1');

    // Progress
    $routes->get('progress', 'Client\ProgressController::index', [
        'filter' => 'permission:view_progress_reports'
    ]);
    $routes->get('progress/detail/(:num)', 'Client\ProgressController::detail/$1', [
        'filter' => 'permission:view_progress_reports'
    ]);
    $routes->get('export-progress', 'Client\ProgressController::exportPdf', [
        'filter' => 'permission:view_progress_reports'
    ]);

    // Issues
    $routes->get('issues', 'Client\IssueController::index', [
        'filter' => 'permission:view_issues'
    ]);
    $routes->get('issues/create', 'Client\IssueController::create', [
        'filter' => 'permission:report_issue'
    ]);
    $routes->post('issues/store', 'Client\IssueController::store', [ 
        'filter' => 'permission:report_issue'
    ]);
    $routes->get('issues/(:num)', 'Client\IssueController::show/$1', [
        'filter' => 'permission:view_issues'
    ]);
    $routes->get('issues/edit/(:num)', 'Client\IssueController::edit/$1', [
        'filter' => 'permission:report_issue' 
    ]);
    $routes->get('export-issue/(:num)', 'Client\IssueController::exportPdf/$1');
    
});

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
| role : staff
*/
$routes->group('staff', ['filter' => 'role:staff'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Tasks 
    $routes->get('tasks', 'Staff\TaskController::index', [
        'filter' => 'permission:view_tasks'
    ]);
    $routes->get('tasks/(:num)', 'Staff\TaskController::show/$1', [
        'filter' => 'permission:view_tasks'
    ]);
    $routes->post('tasks/update-status/(:num)', 'Staff\TaskController::updateStatus/$1', [
        'filter' => 'permission:update_progress'
    ]);
    $routes->post('tasks/comment/(:num)', 'Staff\TaskController::addComment/$1', [
        'filter' => 'permission:view_tasks'
    ]);
    $routes->post('tasks/log-time/(:num)', 'Staff\TaskController::logTime/$1', [
        'filter' => 'permission:update_progress'
    ]);

    // Issues 
    $routes->get('issues', 'Staff\IssueController::index', [
        'filter' => 'permission:view_issues'
    ]);
    $routes->get('issues/create', 'Staff\IssueController::create', [
        'filter' => 'permission:report_issue'
    ]);
    $routes->post('issues/store', 'Staff\IssueController::store', [
        'filter' => 'permission:report_issue'
    ]);

    // Projects
    $routes->get('projects', 'Staff\ProjectController::index', [
        'filter' => 'permission:view_projects'
    ]);
    $routes->get('projects/(:num)', 'Staff\ProjectController::show/$1', [
        'filter' => 'permission:view_projects'
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