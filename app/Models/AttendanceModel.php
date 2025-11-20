<?php namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model {
    protected $table = 'attendance';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employee_id', 'date', 'check_in', 'check_out', 'total_hours', 'report_submitted','project_name','work_description'
    ];
    
        public function countTodayCheckIn()
    {
        $today = date('Y-m-d');
        return $this->where('date', $today)
                    ->where('check_in IS NOT NULL', null, false)
                    ->countAllResults();
    }

    /**
     * Get today’s attendance list with employee names
     */
    public function getTodayAttendance()
    {
        $today = date('Y-m-d');
        return $this->select('attendance.*, employees.name as employee_name')
                    ->join('employees', 'employees.id = attendance.employee_id', 'left')
                    ->where('attendance.date', $today)
                    ->findAll();
    }

    public function getTodayStatus($employeeId)
{
    $row = $this->where('employee_id', $employeeId)
                ->where('DATE(check_in)', date('Y-m-d'))
                ->first();

    return $row ? 'Checked In' : null;
}
}
