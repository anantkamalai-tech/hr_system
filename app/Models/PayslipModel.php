<?php
namespace App\Models;
use CodeIgniter\Model;

class PayslipModel extends Model
{
    protected $table = 'payslips';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employee_id', 'month', 'year',
        'working_days', 'present_days', 'paid_leave', 'half_days', 'overtime_hours',
        'basic', 'hra', 'convey', 'special', 'other_earn', 'variable_pay',
        'pf', 'esi', 'pt', 'tds', 'other_ded', 'lop_days', 'gross', 'deductions', 'net_pay'
    ];
    protected $useTimestamps = true;
}
