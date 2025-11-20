<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\ProjectModel;
use App\Models\AttendanceModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $session;

    public function __construct()
    {
        helper(['url']);
        $this->session = session();
    }

    // public function index()
    // {
    //     if (!$this->session->get('isLoggedIn')) {
    //         return redirect()->to('/login');
    //     }

    //     $employeeModel = new EmployeeModel();
    //     $projectModel = new ProjectModel();
    //     $attendanceModel = new AttendanceModel();

    //     $data = [
    //         'title'          => 'Dashboard',
    //         'user_name'      => $this->session->get('user_name'),
    //         'totalEmployees' => $employeeModel->countAllResults(),
    //         'totalProjects'  => $projectModel->countAllResults(),
    //         'todayCheckedIn' => $attendanceModel->countTodayCheckIn()
    //     ];

    //     return view('dashboard/index', $data);
    // }

    public function index()
{
    if (!$this->session->get('isLoggedIn')) {
        return redirect()->to('/login');
    }

    $role = $this->session->get('role');
    $userId = $this->session->get('employee_id');

    $employeeModel   = new EmployeeModel();
    $projectModel    = new ProjectModel();
    $attendanceModel = new AttendanceModel();

    $data = [
        'title'     => 'Dashboard',
        'role'      => $role,
        'user_name' => $this->session->get('name'),
    ];

    // Admin Data
    if ($role === 'Admin') {
        $data['totalEmployees'] = $employeeModel->countAllResults();
        $data['totalProjects']  = $projectModel->countAllResults();
        $data['todayCheckedIn'] = $attendanceModel->countTodayCheckIn();
    }

    // Employee Data
    if ($role !== 'Admin') {
        $data['assignedProjects'] = $projectModel
            ->where('assigned_to', $userId)
            ->findAll();

        $data['todayStatus'] = $attendanceModel->getTodayStatus($userId);
    }

    return view('dashboard/index', $data); // only one view
}

}
