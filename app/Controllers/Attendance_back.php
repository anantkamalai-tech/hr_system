<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Attendance extends Controller
{
    protected $attendanceModel;
    protected $employeeModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->attendanceModel = new AttendanceModel();
        $this->employeeModel = new EmployeeModel();
    }

    // 🔹 Show all attendance records
    public function index()
    {
        $data = [
            'title' => 'Attendance',
            'attendance' => $this->attendanceModel
                ->select('attendance.*, employees.name as employee_name')
                ->join('employees', 'employees.id = attendance.employee_id', 'left')
                ->orderBy('attendance.date', 'DESC')
                ->findAll(),
            'employees' => $this->employeeModel->findAll()
        ];

        return view('attendance/index', $data);
    }

    // 🔹 Record check-in
    public function checkIn()
    {
        $employeeId = $this->request->getPost('employee_id');
        $date = date('Y-m-d');
        $time = date('H:i:s');

        $exists = $this->attendanceModel->where(['employee_id' => $employeeId, 'date' => $date])->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Employee already checked in today.');
        }

        $this->attendanceModel->insert([
            'employee_id' => $employeeId,
            'date' => $date,
            'check_in' => $time,
        ]);

        return redirect()->back()->with('success', 'Check-in recorded successfully.');
    }

    // 🔹 Record check-out
    public function checkOut()
    {
        $employeeId = $this->request->getPost('employee_id');
        $date = date('Y-m-d');
        $time = date('H:i:s');

        $record = $this->attendanceModel->where(['employee_id' => $employeeId, 'date' => $date])->first();
        if (!$record) {
            return redirect()->back()->with('error', 'No check-in record found for today.');
        }

        $this->attendanceModel->update($record['id'], ['check_out' => $time]);
        return redirect()->back()->with('success', 'Check-out recorded successfully.');
    }
}
