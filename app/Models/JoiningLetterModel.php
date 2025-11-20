<?php
namespace App\Models;
use CodeIgniter\Model;

class JoiningLetterModel extends Model {
    protected $table = 'employee_joining_letters';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'company_name','company_address','company_contact','cin',
        'emp_name','emp_id','designation','department','join_date',
        'location','work_mode','ctc','probation','notice_period','manager','work_hours',
        'notes','include_hindi','include_legal','logo_path','sign_path','pdf_path'
    ];
}
