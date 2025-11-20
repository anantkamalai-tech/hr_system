<?php
namespace App\Controllers;

use App\Models\PayslipModel;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Payslips extends Controller
{
    protected $payslipModel;
    protected $employeeModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->payslipModel = new PayslipModel();
        $this->employeeModel = new EmployeeModel();
    }

    // ✅ List all payslips
    public function index()
    {
        $data = [
            'title' => 'Payslips',
            'payslips' => $this->payslipModel
                ->select('payslips.*, employees.name as employee_name')
                ->join('employees', 'employees.id = payslips.employee_id', 'left')
                ->orderBy('payslips.id', 'DESC')->findAll(),
        ];
        return view('payslips/index', $data);
    }

    // ✅ Create form
    public function create()
    {
        $data = [
            'title' => 'Generate Payslip',
            'employees' => $this->employeeModel->findAll(),
        ];
        return view('payslips/form', $data);
    }

    // ✅ Store Payslip
    public function store()
    {
        $post = $this->request->getPost();
        $gross = $post['basic'] + $post['hra'] + $post['convey'] + $post['special'] + $post['other_earn'] + $post['variable_pay'];
        $deductions = $post['pf'] + $post['esi'] + $post['pt'] + $post['tds'] + $post['other_ded'];
        $net = $gross - $deductions;

        $post['gross'] = $gross;
        $post['deductions'] = $deductions;
        $post['net_pay'] = $net;

        $this->payslipModel->save($post);
        return redirect()->to('/payslips')->with('success', 'Payslip generated successfully!');
    }

    // ✅ Edit form
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Payslip',
            'payslip' => $this->payslipModel->find($id),
            'employees' => $this->employeeModel->findAll(),
        ];
        return view('payslips/form', $data);
    }

    // ✅ Update
    public function update($id)
    {
        $post = $this->request->getPost();
        $gross = $post['basic'] + $post['hra'] + $post['convey'] + $post['special'] + $post['other_earn'] + $post['variable_pay'];
        $deductions = $post['pf'] + $post['esi'] + $post['pt'] + $post['tds'] + $post['other_ded'];
        $net = $gross - $deductions;

        $post['gross'] = $gross;
        $post['deductions'] = $deductions;
        $post['net_pay'] = $net;

        $this->payslipModel->update($id, $post);
        return redirect()->to('/payslips')->with('success', 'Payslip updated successfully!');
    }

    // ✅ Delete
    public function delete($id)
    {
        $this->payslipModel->delete($id);
        return redirect()->back()->with('success', 'Payslip deleted.');
    }

    // ✅ View printable payslip
    public function view($id)
    {
        $data = [
            'title' => 'Payslip Details',
            'payslip' => $this->payslipModel
                ->select('payslips.*, employees.name, employees.dept, employees.designation')
                ->join('employees', 'employees.id=payslips.employee_id', 'left')
                ->find($id),
        ];
        return view('payslips/view', $data);
    }
}
