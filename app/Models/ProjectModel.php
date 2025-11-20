<?php
namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table         = 'projects';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'name','description','start_date','end_date',
        'capacity','wip_limit','buffer_days','manager','assigned_to'
    ];
    protected $useTimestamps = true;

    public function withTaskCounts(): array
    {
        return $this->select('projects.*,
            (SELECT COUNT(*) FROM tasks t WHERE t.project_id = projects.id) AS total_tasks,
            (SELECT COUNT(*) FROM tasks t WHERE t.project_id = projects.id AND t.status="done") AS done_tasks
        ')
        ->orderBy('id','DESC')
        ->findAll();
    }
}
