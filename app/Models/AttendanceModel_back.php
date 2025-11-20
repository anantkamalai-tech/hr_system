<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'id';
    protected $allowedFields = ['employee_id', 'date', 'check_in', 'check_out', 'status', 'remarks'];
    protected $useTimestamps = false;
/**
     * Count how many employees checked in today
     */
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

    /**
     * Mark check-in for employee
     */
    public function checkIn($employee_id)
    {
        $today = date('Y-m-d');
        return $this->insert([
            'employee_id' => $employee_id,
            'date' => $today,
            'check_in' => date('H:i:s'),
            'status' => 'Present'
        ]);
    }

    /**
     * Mark check-out for employee
     */
    public function checkOut($employee_id)
    {
        $today = date('Y-m-d');
        return $this->where('employee_id', $employee_id)
                    ->where('date', $today)
                    ->set('check_out', date('H:i:s'))
                    ->update();
    }
}
