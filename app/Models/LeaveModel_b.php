<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model
{
    protected $table = 'leaves';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employee_id', 'from_date', 'to_date', 'leave_type', 'reason', 'status', 'created_at'
    ];
    protected $useTimestamps = true;
}
