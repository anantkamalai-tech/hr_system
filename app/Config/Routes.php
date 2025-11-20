<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // More secure, prevents auto routing

// ------------------------------------------------------------
// Public (Login / Logout)
// ------------------------------------------------------------
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');
$routes->get('testmail', 'Employees::testmail');
$routes->get('mailtest', 'MailTest::index');


$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    });
// ------------------------------------------------------------
// Employees Module
// ------------------------------------------------------------
$routes->group('employees', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Employees::index');
    $routes->get('create', 'Employees::create');
    $routes->post('store', 'Employees::store');
    $routes->get('edit/(:num)', 'Employees::edit/$1');
    $routes->post('update/(:num)', 'Employees::update/$1');
    $routes->get('delete/(:num)', 'Employees::delete/$1');
    $routes->get('profile/(:num)', 'Employees::profile/$1');
});

// ------------------------------------------------------------
// Projects & Tasks
// ------------------------------------------------------------
$routes->group('projects', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Projects::index');
    $routes->get('create', 'Projects::create');
    $routes->post('store', 'Projects::store');
    $routes->get('edit/(:num)', 'Projects::edit/$1');
    $routes->post('update/(:num)', 'Projects::update/$1');
    $routes->get('view/(:num)', 'Projects::view/$1');
    $routes->post('task/(:num)/store', 'Projects::storeTask/$1');
    $routes->post('task/update-status/(:num)', 'Projects::updateTaskStatus/$1');
    $routes->get('task/delete/(:num)', 'Projects::deleteTask/$1');
    $routes->get('delete/(:num)', 'Projects::delete/$1');
     $routes->get('detail/(:num)', 'Projects::detail/$1');
     $routes->get('my-projects', 'Projects::myProjects');
});





// ------------------------------------------------------------
// Attendance
// ------------------------------------------------------------
// $routes->group('attendance', ['filter' => 'auth'], function ($routes) {
//     $routes->get('/', 'Attendance::index');
//     $routes->post('checkin', 'Attendance::checkIn');
//     $routes->post('checkout', 'Attendance::checkOut');
// });

$routes->group('attendance', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Attendance::index');
$routes->post('checkIn', 'Attendance::checkIn');
$routes->post('checkOut', 'Attendance::checkOut');
$routes->post('submitReport', 'Attendance::submitReport');
$routes->post('saveReport', 'Attendance::saveReport');
});


// ------------------------------------------------------------
// Daily Reports
// ------------------------------------------------------------
$routes->group('dailyreports', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DailyReports::index');
    $routes->post('store', 'DailyReports::store');
});


// ------------------------------------------------------------
// Leaves
// ------------------------------------------------------------
// $routes->group('leaves', ['filter' => 'auth'], function ($routes) {
//     $routes->get('/', 'Leaves::index');
//     $routes->post('store', 'Leaves::store');
//     $routes->get('approve/(:num)', 'Leaves::approve/$1');
//     $routes->get('reject/(:num)', 'Leaves::reject/$1');
//     $routes->get('delete/(:num)', 'Leaves::delete/$1');
// });

// $routes->get('leave', 'LeaveController::index');
// $routes->get('leave/create', 'LeaveController::create');
// $routes->post('leave/store', 'LeaveController::store');
// $routes->get('leave/updateStatus/(:num)/(:alpha)', 'LeaveController::updateStatus/$1/$2');
// Employee side
$routes->group('leave', ['filter' => 'auth'], function ($routes) {
$routes->get('/', 'LeaveController::index');
$routes->post('store', 'LeaveController::store');
});
// Admin side
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
$routes->get('leave-list', 'LeaveController::adminList');
$routes->get('leave-status/(:num)/(:alpha)', 'LeaveController::updateStatus/$1/$2');
});


// ------------------------------------------------------------
// Payslips
// ------------------------------------------------------------
// $routes->group('payslips', ['filter' => 'auth'], function ($routes) {
//     $routes->get('/', 'Payslips::index');
//     $routes->get('create', 'Payslips::create');
//     $routes->post('store', 'Payslips::store');
//     $routes->get('edit/(:num)', 'Payslips::edit/$1');
//     $routes->post('update/(:num)', 'Payslips::update/$1');
//     $routes->get('delete/(:num)', 'Payslips::delete/$1');
//     $routes->get('view/(:num)', 'Payslips::view/$1');
// });
$routes->group('payslips', ['filter' => 'auth'], function ($routes) {
$routes->get('/', 'Payslips::index');
$routes->get('create', 'Payslips::create');
$routes->post('store', 'Payslips::store');
$routes->get('getEmployeeDetails/(:num)', 'Payslips::getEmployeeDetails/$1');

$routes->get('view/(:num)', 'Payslips::view/$1');
$routes->get('pdf/(:num)', 'Payslips::generatePDF/$1');
});


// Projects
$routes->group('projects', ['filter' => 'auth'], function ($routes) {
    $routes->get('/',                'Projects::index');
    $routes->get('create',           'Projects::create');
    $routes->post('store',           'Projects::store');
    $routes->get('edit/(:num)',      'Projects::edit/$1');
    $routes->post('update/(:num)',   'Projects::update/$1');
    $routes->get('view/(:num)',      'Projects::view/$1');
    $routes->get('delete/(:num)',    'Projects::delete/$1');

    // nested task create under a project
    $routes->post('(:num)/tasks/store', 'Projects::storeTask/$1');
});

// Tasks (standalone CRUD)
$routes->group('tasks', ['filter' => 'auth'], function ($routes) {
    $routes->get('/',                'Tasks::index');
    $routes->get('create',           'Tasks::create');
    $routes->post('store',           'Tasks::store');
    $routes->get('edit/(:num)',      'Tasks::edit/$1');
    $routes->post('update/(:num)',   'Tasks::update/$1');
    $routes->get('view/(:num)',      'Tasks::view/$1');
    $routes->get('delete/(:num)',    'Tasks::delete/$1');

    // quick AJAX status update
    $routes->post('status/(:num)',   'Tasks::updateStatus/$1');
});

$routes->group('employee', ['filter' => 'auth'], function ($routes) {
$routes->get('tasks', 'Tasks::employeeTasks');
$routes->post('tasks/update/(:num)', 'Tasks::employeeUpdateStatus/$1');
$routes->get('tasks/view/(:num)', 'Tasks::employeeView/$1');
});



// ------------------------------------------------------------
// Reports
// ------------------------------------------------------------
$routes->group('reports', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Reports::index');
    $routes->get('attendance.csv', 'Reports::attendanceCSV');
    $routes->get('daily.csv', 'Reports::dailyCSV');
    $routes->get('tasks.csv', 'Reports::tasksCSV');
});

// ------------------------------------------------------------
// Settings
// ------------------------------------------------------------
$routes->group('settings', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Settings::index');
    $routes->post('save', 'Settings::save');
});

// ------------------------------------------------------------
// Include System Routes (optional but recommended)
// ------------------------------------------------------------
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}


//sop
$routes->group('sop', ['filter' => 'auth'], function ($routes) {
$routes->get('/', 'SOP::index');
$routes->post('save', 'SOP::save');
});
//joining letter
$routes->group('joiningletter', ['filter' => 'auth'], function ($routes) {
$routes->get('/', 'JoiningLetter::index');
$routes->post('save', 'JoiningLetter::save');
$routes->get('download/(:num)', 'JoiningLetter::download/$1');
});

$routes->get('admin/attendance', 'AdminAttendance::index');
$routes->get('uploads/employees/docs(:any)', 'Files::employeeFile/$1');
