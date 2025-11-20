<?php
namespace App\Models;
use CodeIgniter\Model;

class SOPModel extends Model {
    protected $table = 'employee_sop';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'emp_id', 'department', 'email', 'effective_date', 'consent', 'signature_path'
    ];
}
