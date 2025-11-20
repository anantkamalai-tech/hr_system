<?php
namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table         = 'tasks';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'project_id','title','description','assigned_to','estimate',
        'due_date','priority','status','dependencies','comment'
    ];
    protected $useTimestamps = true;

    public function byProject(int $projectId): array
    {
        return $this->select('tasks.*, employees.name AS employee_name')
            ->join('employees','employees.id = tasks.assigned_to','left')
            ->where('tasks.project_id',$projectId)
            ->orderBy('tasks.id','DESC')
            ->findAll();
    }
}
