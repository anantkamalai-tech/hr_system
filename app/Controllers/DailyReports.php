<?php

namespace App\Controllers;

use App\Models\DailyReportModel;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class DailyReports extends Controller
{
    protected $reportModel;
    protected $employeeModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->reportModel = new DailyReportModel();
        $this->employeeModel = new EmployeeModel();
    }

    // 🔹 Show list of all daily reports
    public function index()
    {
        $data = [
            'title' => 'Daily Developer Reports',
            'reports' => $this->reportModel
                ->select('daily_reports.*, employees.name as employee_name')
                ->join('employees', 'employees.id = daily_reports.employee_id', 'left')
                ->orderBy('daily_reports.date', 'DESC')
                ->findAll(),
            'employees' => $this->employeeModel->findAll()
        ];

        return view('dailyreports/index', $data);
    }

    // 🔹 Store a new daily report
    public function store()
    {
        $data = [
            'employee_id' => $this->request->getPost('employee_id'),
            'date' => $this->request->getPost('date'),
            'tasks_completed' => $this->request->getPost('tasks_completed'),
            'issues' => $this->request->getPost('issues'),
            'next_plan' => $this->request->getPost('next_plan'),
            'remarks' => $this->request->getPost('remarks'),
        ];

        $this->reportModel->insert($data);

        return redirect()->to('/dailyreports')->with('success', 'Daily report submitted successfully!');
    }
}
