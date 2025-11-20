<?php
namespace App\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\PayslipModel;
use App\Models\EmployeeModel;
use App\Models\AttendanceModel;
use App\Models\LeaveModel;
use CodeIgniter\Controller;

class Payslips extends Controller
{
    protected $payslipModel;
    protected $employeeModel;
    protected $attendanceModel;
    protected $leaveModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->payslipModel = new PayslipModel();
        $this->employeeModel = new EmployeeModel();
        $this->attendanceModel = new AttendanceModel();
        $this->leaveModel = new LeaveModel();
    }

    // List all payslips
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

    // Create payslip form
    public function create()
    {
        $data = [
            'title' => 'Generate Payslip',
            'employees' => $this->employeeModel->findAll(),
        ];
        return view('payslips/form', $data);
    }

    // Fetch Employee + Attendance + Leave Details
    public function getEmployeeDetails($id)
    {
        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Employee not found']);
        }

        $month = (int) ($this->request->getGet('month') ?? date('m'));
        $year  = (int) ($this->request->getGet('year') ?? date('Y'));

        $startOfMonth = sprintf('%04d-%02d-01', $year, $month);
        $endOfMonth   = date('Y-m-t', strtotime($startOfMonth));

        // Count present days (based on check_in)
        $presentDays = $this->attendanceModel
            ->where('employee_id', $id)
            ->where('check_in IS NOT NULL')
            ->where('date >=', $startOfMonth)
            ->where('date <=', $endOfMonth)
            ->groupBy('DATE(date)')
            ->countAllResults();

        // Count approved leave days
        $leaves = $this->leaveModel
            ->where('employee_id', $id)
            ->where('status', 'Approved')
            ->where('start_date <=', $endOfMonth)
            ->where('end_date >=', $startOfMonth)
            ->findAll();

        $approvedLeaveDays = 0;
        foreach ($leaves as $leave) {
            $start = max($leave['start_date'], $startOfMonth);
            $end = min($leave['end_date'], $endOfMonth);
            $approvedLeaveDays += (strtotime($end) - strtotime($start)) / 86400 + 1;
        }

        $workingDays = $this->getWorkingDaysInMonth($month, $year);
        $absentDays = max(0, $workingDays - ($presentDays + $approvedLeaveDays));

        $employee['pay_mode'] = 'Bank Transfer';
        $employee['location'] = $employee['location'] ?? 'Nashik';

        return $this->response->setJSON([
            'employee' => $employee,
            'attendance' => [
                'working_days' => $workingDays,
                'present_days' => $presentDays,
                'approved_leave_days' => $approvedLeaveDays,
                'absent_days' => $absentDays
            ]
        ]);
    }

    // Store payslip (Basic only)
    public function store()
    {
        $post = $this->request->getPost();

        $basic = (float) ($post['basic'] ?? 0);
        $gross = $basic; // Only Basic Salary

        $workingDays = (int) ($post['working_days'] ?? 0);
        $presentDays = (int) ($post['present_days'] ?? 0);
        $approvedLeaves = (int) ($post['approved_leave_days'] ?? 0);

        $absent = max(0, $workingDays - ($presentDays + $approvedLeaves));
        $perDay = $workingDays > 0 ? ($gross / $workingDays) : 0;
        $lopAmount = $perDay * $absent;

        $netPay = $gross - $lopAmount;

        $this->payslipModel->save([
            'employee_id' => $post['employee_id'],
            'month' => $post['month'],
            'year' => $post['year'],
            'basic' => $basic,
            'gross' => round($gross, 2),
            'lop_days' => $absent,
            'lop_amount' => round($lopAmount, 2),
            'net_pay' => round($netPay, 2),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/payslips')->with('success', 'Payslip generated successfully!');
    }

    // Helper: Working Days (Mon–Sat)
    private function getWorkingDaysInMonth($month, $year)
    {
        $working = 0;
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($d = 1; $d <= $days; $d++) {
            $weekday = date('N', strtotime("$year-$month-$d"));
            if ($weekday < 7) $working++; // Mon–Sat
        }
        return $working;
    }
    
    public function view($id)
{
    $payslip = $this->payslipModel
        ->select('payslips.*, employees.emp_code, employees.name, employees.join_date,
                  employees.dept, employees.designation, employees.address, employees.account_no')
        ->join('employees', 'employees.id = payslips.employee_id', 'left')
        ->find($id);

    if (!$payslip) {
        return redirect()->to('/payslips')->with('error', 'Payslip not found');
    }

    return view('payslips/view', ['payslip' => $payslip]);
}

public function generatePDF($id)
{
    $payslip = $this->payslipModel
        ->select('payslips.*, employees.emp_code, employees.name, employees.join_date,
                  employees.dept, employees.designation, employees.address, employees.account_no')
        ->join('employees', 'employees.id = payslips.employee_id', 'left')
        ->find($id);

    if (!$payslip) {
        return redirect()->to('/payslips')->with('error', 'Payslip not found');
    }

    // Load Dompdf
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    $html = view('payslips/pdf_template', ['payslip' => $payslip]);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $fileName = 'Payslip_' . $payslip['name'] . '_' . $payslip['month'] . '_' . $payslip['year'] . '.pdf';
    $dompdf->stream($fileName, ["Attachment" => true]);
}
}
