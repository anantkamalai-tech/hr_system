<?php
namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Projects extends Controller
{
    protected $projectModel;
    protected $taskModel;
    protected $employeeModel;

    public function __construct()
    {
        helper(['url','form']);
        $this->projectModel  = new ProjectModel();
        $this->taskModel     = new TaskModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function index()
    {
        return view('projects/index', [
            'title'    => 'Projects',
            'projects' => $this->projectModel->withTaskCounts()
        ]);
    }

    public function create()
    {
        return view('projects/form', [
            'title'   => 'Add Project',
            'project' => null,
            'employees' => $this->employeeModel->findAll() // ✅ all employees
        ]);
    }

    // public function store()
    // {
    //     $rules = [
    //         'name'        => 'required|min_length[3]',
    //         'capacity'    => 'permit_empty|numeric',
    //         'wip_limit'   => 'permit_empty|integer',
    //         'buffer_days' => 'permit_empty|integer',
    //         'start_date'  => 'permit_empty|valid_date',
    //         'end_date'    => 'permit_empty|valid_date',
    //     ];
    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->with('error', implode(', ', $this->validator->getErrors()))->withInput();
    //     }

    //     $this->projectModel->insert($this->request->getPost());
    //     return redirect()->to('/projects')->with('success','Project created successfully');
    // }
    
    public function store()
{
    $rules = [
        'name'        => 'required|min_length[3]',
        'capacity'    => 'permit_empty|numeric',
        'wip_limit'   => 'permit_empty|integer',
        'buffer_days' => 'permit_empty|integer',
        'start_date'  => 'permit_empty|valid_date',
        'end_date'    => 'permit_empty|valid_date',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->with('error', implode(', ', $this->validator->getErrors()))
            ->withInput();
    }

    // ✅ handle multiple employee selection
    $assignedTo = $this->request->getPost('assigned_to');
    $assignedToString = is_array($assignedTo) ? implode(',', $assignedTo) : null;

    $data = [
        'name'        => $this->request->getPost('name'),
        'capacity'    => $this->request->getPost('capacity'),
        'wip_limit'   => $this->request->getPost('wip_limit'),
        'buffer_days' => $this->request->getPost('buffer_days'),
        'start_date'  => $this->request->getPost('start_date'),
        'end_date'    => $this->request->getPost('end_date'),
        'description'    => $this->request->getPost('description'),
        'manager'    => $this->request->getPost('manager'),
        'assigned_to' => $assignedToString,
    ];

    $this->projectModel->insert($data);

    return redirect()->to('/projects')->with('success', 'Project created successfully');
}


    public function edit($id)
    {
        $project = $this->projectModel->find($id);
        if (!$project) return redirect()->to('/projects')->with('error','Project not found');

        return view('projects/form', [
            'title'   => 'Edit Project',
            'project' => $project,
            'employees' => $this->employeeModel->findAll() // ✅ all employees
        ]);
    }

    // public function update($id)
    // {
    //     $rules = [
    //         'name'        => 'required|min_length[3]',
    //         'capacity'    => 'permit_empty|numeric',
    //         'wip_limit'   => 'permit_empty|integer',
    //         'buffer_days' => 'permit_empty|integer',
    //         'start_date'  => 'permit_empty|valid_date',
    //         'end_date'    => 'permit_empty|valid_date',
    //     ];
    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->with('error', implode(', ', $this->validator->getErrors()))->withInput();
    //     }

    //     $this->projectModel->update($id, $this->request->getPost());
    //     return redirect()->to('/projects/view/'.$id)->with('success','Project updated successfully');
    // }
    
    public function update($id)
{
    $rules = [
        'name'        => 'required|min_length[3]',
        'capacity'    => 'permit_empty|numeric',
        'wip_limit'   => 'permit_empty|integer',
        'buffer_days' => 'permit_empty|integer',
        'start_date'  => 'permit_empty|valid_date',
        'end_date'    => 'permit_empty|valid_date',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->with('error', implode(', ', $this->validator->getErrors()))
            ->withInput();
    }

    $assignedTo = $this->request->getPost('assigned_to');
    $assignedToString = is_array($assignedTo) ? implode(',', $assignedTo) : null;

    $data = [
        'name'        => $this->request->getPost('name'),
        'capacity'    => $this->request->getPost('capacity'),
        'wip_limit'   => $this->request->getPost('wip_limit'),
        'buffer_days' => $this->request->getPost('buffer_days'),
        'start_date'  => $this->request->getPost('start_date'),
        'end_date'    => $this->request->getPost('end_date'),
        'manager'    => $this->request->getPost('manager'),
        'description'    => $this->request->getPost('description'),
        'assigned_to' => $assignedToString,
    ];

    $this->projectModel->update($id, $data);

    return redirect()->to('/projects' . $id)
        ->with('success', 'Project updated successfully');
}


    public function view($id)
    {
        $project = $this->projectModel->find($id);
        if (!$project) throw new \CodeIgniter\Exceptions\PageNotFoundException('Project not found');

        return view('projects/view', [
            'title'     => 'Project Details',
            'project'   => $project,
            'tasks'     => $this->taskModel->byProject($id),
            'employees' => $this->employeeModel->findAll()
        ]);
    }

    public function storeTask($projectId)
    {
        $rules = [
            'title'    => 'required|min_length[3]',
            'estimate' => 'permit_empty|numeric',
            'due_date' => 'permit_empty|valid_date',
            'priority' => 'permit_empty|in_list[P1,P2,P3]',
            'status'   => 'permit_empty|in_list[backlog,inprogress,review,done]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', implode(', ', $this->validator->getErrors()))->withInput();
        }

        $this->taskModel->insert([
            'project_id'  => $projectId,
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'assigned_to' => $this->request->getPost('assigned_to') ?: null,
            'estimate'    => $this->request->getPost('estimate') ?: 0,
            'due_date'    => $this->request->getPost('due_date') ?: null,
            'priority'    => $this->request->getPost('priority') ?: 'P3',
            'status'      => $this->request->getPost('status') ?: 'backlog',
            'dependencies'=> $this->request->getPost('dependencies') ?: null,
        ]);

        return redirect()->to('/projects/view/'.$projectId)->with('success','Task added');
    }

    public function delete($id)
    {
        $this->projectModel->delete($id);
        return redirect()->to('/projects')->with('success','Project deleted');
    }
    
    public function detail($id)
{
    $project = $this->projectModel->find($id);
    if (!$project) throw new \CodeIgniter\Exceptions\PageNotFoundException('Project not found');

    return view('projects/detail', [
        'title'     => 'Project Details',
        'project'   => $project,
        'tasks'     => $this->taskModel->byProject($id),
        'employees' => $this->employeeModel->findAll()
    ]);
}

public function myProjects()
{
    $session = session();
    $employeeId = $session->get('employee_id'); // assuming you store this in session

    if (!$employeeId) {
        return redirect()->to('/login')->with('error', 'Please login first');
    }

    $allProjects = $this->projectModel->findAll();
    $myProjects = [];

    foreach ($allProjects as $project) {
        $assignedIds = explode(',', $project['assigned_to'] ?? '');

        if (in_array($employeeId, $assignedIds)) {
            // ✅ Find project manager (if stored in DB)
            $manager = null;
            if (!empty($project['manager_id'])) {
                $manager = $this->employeeModel->find($project['manager_id']);
            }

            // ✅ Get tasks assigned to this employee for this project
            $tasks = $this->taskModel
                ->where('project_id', $project['id'])
                ->where('assigned_to', $employeeId)
                ->findAll();

            $myProjects[] = [
                'project' => $project,
                'manager' => $manager,
                'tasks'   => $tasks,
            ];
        }
    }

    return view('projects/my_projects', [
        'title' => 'My Projects',
        'myProjects' => $myProjects,
    ]);
}


}


// namespace App\Controllers;

// use App\Models\ProjectModel;
// use App\Models\TaskModel;
// use App\Models\EmployeeModel;
// use CodeIgniter\Controller;

// class Projects extends Controller
// {
//     protected $projectModel;
//     protected $taskModel;
//     protected $employeeModel;

//     public function __construct()
//     {
//         helper(['url', 'form']);
//         $this->projectModel = new ProjectModel();
//         $this->taskModel = new TaskModel();
//         $this->employeeModel = new EmployeeModel();
//     }

//     // ðŸ”¹ List Projects
//     public function index()
//     {
//         $data = [
//             'title' => 'Projects',
//             'projects' => $this->projectModel->orderBy('id', 'DESC')->findAll()
//         ];
//         return view('projects/index', $data);
//     }

//     // ðŸ”¹ Create Project
//     public function create()
//     {
//         $data = [
//             'title' => 'Add Project',
//             'employees' => $this->employeeModel->findAll(),
//             'project' => null
//         ];
//         return view('projects/create', $data);
//     }

//     public function store()
//     {
//         $this->projectModel->save($this->request->getPost());
//         return redirect()->to('/projects')->with('success', 'Project created successfully');
//     }

//     // ðŸ”¹ Edit Project
//     public function edit($id)
//     {
//         $project = $this->projectModel->find($id);
//         if (!$project) return redirect()->to('/projects')->with('error', 'Project not found');

//         $data = [
//             'title' => 'Edit Project',
//             'project' => $project,
//             'employees' => $this->employeeModel->findAll()
//         ];
//         return view('projects/create', $data);
//     }

//     public function update($id)
//     {
//         $this->projectModel->update($id, $this->request->getPost());
//         return redirect()->to('/projects/view/'.$id)->with('success', 'Project updated successfully');
//     }

//     // ðŸ”¹ View Project + Tasks
//     public function view($id)
//     {
//         $project = $this->projectModel->find($id);
//         if (!$project) throw new \CodeIgniter\Exceptions\PageNotFoundException('Project not found');

//         $data = [
//             'title' => 'Project Details',
//             'project' => $project,
//             'tasks' => $this->taskModel->where('project_id', $id)->findAll(),
//             'employees' => $this->employeeModel->findAll()
//         ];
//         return view('projects/view', $data);
//     }

//     // ðŸ”¹ Add Task
//     public function storeTask($projectId)
//     {
//         $this->taskModel->insert([
//             'project_id' => $projectId,
//             'title' => $this->request->getPost('title'),
//             'description' => $this->request->getPost('description'),
//             'assigned_to' => $this->request->getPost('assigned_to'),
//             'due_date' => $this->request->getPost('due_date'),
//             'status' => $this->request->getPost('status'),
//         ]);
//         return redirect()->to('/projects/view/'.$projectId)->with('success', 'Task added successfully');
//     }

//     // ðŸ”¹ Update Task Status
//     public function updateTaskStatus($id)
//     {
//         $status = $this->request->getPost('status');
//         $this->taskModel->update($id, ['status' => $status]);
//         return $this->response->setJSON(['success' => true]);
//     }

//     // ðŸ”¹ Delete Task
//     public function deleteTask($id)
//     {
//         $task = $this->taskModel->find($id);
//         if ($task) {
//             $this->taskModel->delete($id);
//             return redirect()->to('/projects/view/'.$task['project_id'])->with('success', 'Task deleted');
//         }
//         return redirect()->back()->with('error', 'Task not found');
//     }

//     // ðŸ”¹ Delete Project
//     public function delete($id)
//     {
//         $this->projectModel->delete($id);
//         return redirect()->to('/projects')->with('success', 'Project deleted successfully');
//     }
// }
