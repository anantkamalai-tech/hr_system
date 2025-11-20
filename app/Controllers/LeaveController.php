<?php

namespace App\Controllers;
use App\Models\LeaveModel;
use App\Models\EmployeeModel;

class LeaveController extends BaseController
{
    protected $leaveModel;

    public function __construct()
    {
        $this->leaveModel = new LeaveModel();
    }

    // 🧑‍💼 Employee: Apply Leave + View Own Leaves
    public function index()
    {
        $employee_id = session()->get('employee_id');
        $employee_name = session()->get('name');

        if (!$employee_id) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $leaves = $this->leaveModel
            ->where('employee_id', $employee_id)
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('leaves/apply_leave', [
            'employee_name' => $employee_name,
            // 'leaves' => $leaves
            'leaves' => $leaves ?? [],
        ]);
    }

    // 💾 Store Leave Application
    public function store()
    {
        $employee_id = session()->get('employee_id');

        $file = $this->request->getFile('attachment');
        $fileName = null;

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/leave_docs/', $fileName);
        }

        $this->leaveModel->insert([
            'employee_id' => $employee_id,
            'leave_type' => $this->request->getPost('leave_type'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'reason' => $this->request->getPost('reason'),
            'attachment' => $fileName,
            'status' => 'Pending'
        ]);

        return redirect()->to('leave')->with('success', 'Leave application submitted!');
    }

    // 👨‍💼 Admin: All Leaves
    public function adminList()
    {
        $leaves = $this->leaveModel
            ->select('leave_applications.*, employees.name as employee_name')
            ->join('employees', 'employees.id = leave_applications.employee_id')
            ->orderBy('leave_applications.id', 'DESC')
            ->findAll();

        return view('leaves/admin_list', ['leaves' => $leaves]);
    }

    // 🔄 Update Status (Approve / Reject)
    public function updateStatus($id, $status)
    {
        $this->leaveModel->update($id, ['status' => $status]);
        return redirect()->to('admin/leave-list')->with('success', 'Leave status updated!');
    }
}
