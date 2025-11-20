<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use CodeIgniter\Controller;

class AdminAttendance extends Controller
{
    protected $attendanceModel;
    protected $session;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->attendanceModel = new AttendanceModel();
        $this->session = session();
        date_default_timezone_set('Asia/Kolkata'); // India Time
    }

    // ✅ Show Attendance List
    public function index()
    {
        $builder = $this->attendanceModel;

        // Search by employee name
        $search = $this->request->getGet('search');
        if ($search) {
            $builder->join('employees', 'employees.id = attendance.employee_id')
                    ->like('employees.name', $search);
        } else {
            $builder->join('employees', 'employees.id = attendance.employee_id');
        }

        // Filter by week or month
        $filter = $this->request->getGet('filter'); // 'week' or 'month'
        if ($filter == 'week') {
            $startOfWeek = date('Y-m-d', strtotime('monday this week'));
            $endOfWeek   = date('Y-m-d', strtotime('sunday this week'));
            $builder->where('attendance.date >=', $startOfWeek)
                    ->where('attendance.date <=', $endOfWeek);
        } elseif ($filter == 'month') {
            $currentMonth = date('Y-m');
            $builder->like('attendance.date', $currentMonth);
        }

        $builder->orderBy('attendance.date', 'DESC');

        $attendances = $builder->select('attendance.*, employees.name as employee_name')->findAll();

        return view('attendance/attendance_list', [
            'attendances' => $attendances,
            'search' => $search,
            'filter' => $filter
        ]);
    }
}
