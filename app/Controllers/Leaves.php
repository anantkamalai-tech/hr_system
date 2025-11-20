<?php

namespace App\Controllers;

use App\Models\LeaveModel;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Leaves extends Controller
{
    protected $leaveModel;
    protected $employeeModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->leaveModel = new LeaveModel();
        $this->employeeModel = new EmployeeModel();
    }

    // 🔹 Show list of leaves
    public function index()
    {
        $data = [
            'title' => 'Leave Applications',
            'leaves' => $this->leaveModel
                ->select('leaves.*, employees.name as employee_name')
                ->join('employees', 'employees.id = leaves.employee_id', 'left')
                ->orderBy('leaves.created_at', 'DESC')
                ->findAll(),
            'employees' => $this->employeeModel->findAll(),
        ];

        return view('leaves/index', $data);
    }

    // 🔹 Store new leave
    public function store()
    {
        $data = [
            'employee_id' => $this->request->getPost('employee_id'),
            'from_date'   => $this->request->getPost('from_date'),
            'to_date'     => $this->request->getPost('to_date'),
            'leave_type'  => $this->request->getPost('leave_type'),
            'reason'      => $this->request->getPost('reason'),
            'status'      => 'Pending',
        ];

        $this->leaveModel->insert($data);
        return redirect()->to('/leaves')->with('success', 'Leave application submitted successfully!');
    }

    // 🔹 Approve leave
    public function approve($id)
    {
        $this->leaveModel->update($id, ['status' => 'Approved']);
        return redirect()->back()->with('success', 'Leave approved successfully!');
    }

    // 🔹 Reject leave
    public function reject($id)
    {
        $this->leaveModel->update($id, ['status' => 'Rejected']);
        return redirect()->back()->with('error', 'Leave rejected!');
    }

    // 🔹 Delete leave
    public function delete($id)
    {
        $this->leaveModel->delete($id);
        return redirect()->back()->with('success', 'Leave deleted successfully.');
    }
}
