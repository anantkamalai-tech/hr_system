<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyReportModel extends Model
{
    protected $table = 'daily_reports';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employee_id', 'date', 'tasks_completed', 'issues', 'next_plan', 'remarks', 'created_at'
    ];
    protected $useTimestamps = true;
}
