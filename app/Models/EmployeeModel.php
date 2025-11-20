<?php namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model {
    protected $table='employees';
    protected $primaryKey='id';
    protected $allowedFields=[
        'emp_code','name','email','password','mobile','gender','dob','address','role','dept','designation',
        'join_date','experience','emerg_name','emerg_phone','pan','aadhar','uan','tech_stack',
        'education','salary','photo','doc_aadhar','doc_pan','doc_resume','doc_offer','bank_name','ifsc','account_no'
    ];
}
