<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\ProjectModel; 
use CodeIgniter\Controller;

class Attendance extends Controller
{
    protected $attendanceModel;
    protected $projectModel;
    protected $session;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->attendanceModel = new AttendanceModel();
        $this->projectModel = new ProjectModel();
        $this->session = session();
    }

    // ✅ Attendance Dashboard
    // public function index()
    // {
    //     $employee_id = $this->session->get('employee_id');
    //     $employee_name = $this->session->get('name'); // session key

    //     if (!$employee_id) {
    //         return redirect()->to('/login')->with('error', 'Please log in first.');
    //     }

    //     // Latest attendance for top buttons
    //     $attendance = $this->attendanceModel
    //         ->where('employee_id', $employee_id)
    //         ->orderBy('date', 'DESC')
    //         ->first();

    //     // All attendance records for table
    //     $attendances = $this->attendanceModel
    //         ->where('employee_id', $employee_id)
    //         ->orderBy('date', 'DESC')
    //         ->findAll();

    //     // Projects (for dropdown)
    //     $projects = $this->projectModel->findAll();

    //     return view('attendance/index', [
    //         'employee_name' => $employee_name,
    //         'attendance' => $attendance,
    //         'attendances' => $attendances,
    //         'projects' => $projects
    //     ]);
    // }
    
    public function index()
{
    $employee_id = $this->session->get('employee_id');
    $employee_name = $this->session->get('name');

    if (!$employee_id) {
        return redirect()->to('/login')->with('error', 'Please log in first.');
    }

    $today = date('Y-m-d');

    // ✅ Fetch only today's attendance for CheckIn/Out logic
    $attendance = $this->attendanceModel
        ->where('employee_id', $employee_id)
        ->where('date', $today)
        ->first();

    // ✅ Fetch all records for table
    $attendances = $this->attendanceModel
        ->where('employee_id', $employee_id)
        ->orderBy('date', 'DESC')
        ->findAll();

    // Projects (for dropdown)
    $projects = $this->projectModel->findAll();

    return view('attendance/index', [
        'employee_name' => $employee_name,
        'attendance' => $attendance,
        'attendances' => $attendances,
        'projects' => $projects
    ]);
}

    // ✅ Check-In
    public function checkIn()
    {
        $employee_id = $this->session->get('employee_id');
        $today = date('Y-m-d');

        if (!$employee_id) {
            return redirect()->to('/login')->with('error', 'Session expired. Please log in again.');
        }

        // Check if already checked in today
        $already = $this->attendanceModel
            ->where('employee_id', $employee_id)
            ->where('date', $today)
            ->first();

        if ($already) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        $this->attendanceModel->insert([
            'employee_id' => $employee_id,
            'date'        => $today,
            'check_in'    => date('H:i:s'),
            'report_submitted' => 0
        ]);

        return redirect()->back()->with('success', 'Checked in successfully.');
    }

    // ✅ Submit Daily Report (legacy method, optional)
    public function submitReport()
    {
        $employee_id = $this->session->get('employee_id');
        $today = date('Y-m-d');

        if (!$employee_id) {
            return redirect()->to('/login')->with('error', 'Please log in again.');
        }

        $attendance = $this->attendanceModel
            ->where('employee_id', $employee_id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Please check in before submitting the report.');
        }

        $this->attendanceModel->update($attendance['id'], [
            'report_submitted' => 1
        ]);

        return redirect()->back()->with('success', 'Daily report submitted successfully.');
    }

    // ✅ Check-Out (only after report submission)
    public function checkOut()
    {
        $employee_id = $this->session->get('employee_id');
        $today = date('Y-m-d');

        if (!$employee_id) {
            return redirect()->to('/login')->with('error', 'Please log in again.');
        }

        $attendance = $this->attendanceModel
            ->where('employee_id', $employee_id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Please check in first.');
        }

        if (!isset($attendance['report_submitted']) || $attendance['report_submitted'] == 0) {
            return redirect()->back()->with('error', 'Submit your report before checking out.');
        }

        if (!empty($attendance['check_out'])) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }

        $check_in = strtotime($attendance['check_in']);
        $check_out = time();
        $hours = round(($check_out - $check_in) / 3600, 2);

        $this->attendanceModel->update($attendance['id'], [
            'check_out' => date('H:i:s'),
            'total_hours' => $hours
        ]);

        return redirect()->back()->with('success', 'Checked out successfully.');
    }

    // ✅ Save Daily Report from modal
    public function saveReport()
    {
        $employee_id = $this->session->get('employee_id');
        if (!$employee_id) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        // Get POST data
        $name = $this->request->getPost('name');
        $date = $this->request->getPost('date');
        $project = $this->request->getPost('project');
        $work_description = $this->request->getPost('work_description');

        // Validate required fields
        if (!$project || !$work_description) {
            return redirect()->back()->with('error', 'Please fill in all required fields.');
        }

        // Check if attendance exists for this date
        $attendance = $this->attendanceModel
            ->where('employee_id', $employee_id)
            ->where('date', $date)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Please Check In first.');
        }

        // Update attendance with report details
        $this->attendanceModel->update($attendance['id'], [
            'project_name' => $project,
            'work_description' => $work_description,
            'report_submitted' => 1
        ]);

        $this->session->setFlashdata('success', 'Report saved. You can now Time Out from Attendance.');

        return redirect()->to('/attendance');
    }
}
