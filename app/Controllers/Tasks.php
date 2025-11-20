<?php
namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\ProjectModel;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Tasks extends Controller
{
    protected $taskModel;
    protected $projectModel;
    protected $employeeModel;

    public function __construct()
    {
        helper(['url','form']);
        $this->taskModel     = new TaskModel();
        $this->projectModel  = new ProjectModel();
        $this->employeeModel = new EmployeeModel();
    }

    // public function index()
    // {
    //     $tasks = $this->taskModel
    //         ->select('tasks.*, projects.name AS project_name, employees.name AS employee_name')
    //         ->join('projects','projects.id = tasks.project_id','left')
    //         ->join('employees','employees.id = tasks.assigned_to','left')
    //         ->orderBy('tasks.id','DESC')
    //         ->findAll();

    //     return view('tasks/index', [
    //         'title' => 'Tasks',
    //         'tasks' => $tasks
    //     ]);
    // }
    
    public function index()
{
    $tasks = $this->taskModel
        ->select('tasks.*, projects.name AS project_name, employees.name AS employee_name')
        ->join('projects','projects.id = tasks.project_id','left')
        ->join('employees','employees.id = tasks.assigned_to','left')
        ->orderBy('tasks.id','DESC')
        ->findAll();

    // Get all employees for the filter dropdown
    $employees = $this->employeeModel->findAll();

    return view('tasks/index', [
        'title'     => 'Tasks',
        'tasks'     => $tasks,
        'employees' => $employees  // <-- add this line
    ]);
}


    // public function create()
    // {
    //     return view('tasks/form', [
    //         'title'     => 'Add Task',
    //         'task'      => null,
    //         'projects'  => $this->projectModel->findAll(),
    //         'employees' => $this->employeeModel->findAll()
    //     ]);
    // }

    // public function store()
    // {
    //     $rules = [
    //         'project_id' => 'required|integer',
    //         'title'      => 'required|min_length[3]',
    //         'estimate'   => 'permit_empty|numeric',
    //         'due_date'   => 'permit_empty|valid_date',
    //         'priority'   => 'permit_empty|in_list[P1,P2,P3]',
    //         'status'     => 'permit_empty|in_list[backlog,inprogress,review,done]',
    //     ];
    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->with('error', implode(', ', $this->validator->getErrors()))->withInput();
    //     }

    //     $this->taskModel->insert($this->request->getPost());
    //     return redirect()->to('/tasks')->with('success','Task created');
    // }
    
    public function create()
{
    $session = session();
   
    $role = $session->get('role'); // assuming you store role in session
    $employeeId = $session->get('employee_id');
    //   print_r($employeeId);die;
    // For admin: show all employees
    // For employee: hide Assigned To dropdown
    $employees = [];
    if ($role === 'Admin') {
        $employees = $this->employeeModel->findAll();
    }

    return view('tasks/form', [
        'title'      => 'Add Task',
        'task'       => null,
        'projects'   => $this->projectModel->findAll(),
        'employees'  => $employees,
        'isEmployee' => ($role !== 'Admin'),
        'employeeId' => $employeeId
    ]);
}

public function store()
{
    $session = session();
    $role = $session->get('role');
    $employeeId = $session->get('employee_id');

    $data = $this->request->getPost();

    // Auto-assign to employee if not admin
    if ($role !== 'Admin') {
        $data['assigned_to'] = $employeeId;
    }
   
    $this->taskModel->insert($data);
     if ($role == 'Admin') {
    return redirect()->to('/tasks')->with('success', 'Task created successfully!');
     }else
     {
       return redirect()->to('/employee/tasks')->with('success', 'Task created successfully!');   
     }
}



    public function edit($id)
    {
        $task = $this->taskModel->find($id);
        if (!$task) return redirect()->to('/tasks')->with('error','Task not found');

        return view('tasks/form', [
            'title'     => 'Edit Task',
            'task'      => $task,
            'projects'  => $this->projectModel->findAll(),
            'employees' => $this->employeeModel->findAll()
        ]);
    }

    public function update($id)
    {
        $this->taskModel->update($id, $this->request->getPost());
        return redirect()->to('/tasks')->with('success','Task updated');
    }

    public function view($id)
    {
        $task = $this->taskModel
            ->select('tasks.*, projects.name AS project_name, employees.name AS employee_name')
            ->join('projects','projects.id = tasks.project_id','left')
            ->join('employees','employees.id = tasks.assigned_to','left')
            ->find($id);

        if (!$task) throw new \CodeIgniter\Exceptions\PageNotFoundException('Task not found');

        return view('tasks/view', [
            'title' => 'Task Details',
            'task'  => $task
        ]);
    }

    public function delete($id)
    {
        $this->taskModel->delete($id);
        return redirect()->to('/tasks')->with('success','Task deleted');
    }

    // AJAX status-only update
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        if (!in_array($status, ['backlog','inprogress','review','done'])) {
            return $this->response->setStatusCode(422)->setJSON(['error'=>'Invalid status']);
        }
        $this->taskModel->update($id, ['status'=>$status]);
        return $this->response->setJSON(['success'=>true]);
    }
    
    // =========================================
// Employee: View Assigned Tasks
// =========================================
public function employeeTasks()
{
    $employeeId = session()->get('employee_id');
    if (!$employeeId) {
        return redirect()->to('/login')->with('error', 'Please log in as an employee');
    }

    $tasks = $this->taskModel
        ->select('tasks.*, projects.name AS project_name')
        ->join('projects', 'projects.id = tasks.project_id', 'left')
        ->where('tasks.assigned_to', $employeeId)
        ->orderBy('tasks.id', 'DESC')
        ->findAll();

    return view('tasks/employee_tasks', [
        'title' => 'My Tasks',
        'tasks' => $tasks
    ]);
}

// =========================================
// Employee: Update Status or Add Comment
// =========================================
public function employeeUpdateStatus($id)
{
    $employeeId = session()->get('employee_id');
    $task = $this->taskModel->find($id);

    if (!$task || $task['assigned_to'] != $employeeId) {
        return $this->response->setStatusCode(403)->setJSON(['error' => 'Unauthorized']);
    }

    $status  = $this->request->getPost('status');
    $comment = $this->request->getPost('comment');

    $data = [];

    if ($status && in_array($status, ['backlog', 'inprogress', 'review', 'done'])) {
        $data['status'] = $status;
    }

    if (!empty($comment)) {
        $data['comment'] = $comment;
    }

    if (empty($data)) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'No data provided']);
    }

    $this->taskModel->update($id, $data);
    return $this->response->setJSON(['success' => true]);
}

public function employeeView($id)
{
    $employeeId = session()->get('employee_id');
    $task = $this->taskModel
        ->select('tasks.*, projects.name AS project_name')
        ->join('projects', 'projects.id = tasks.project_id', 'left')
        ->find($id);

    if (!$task || $task['assigned_to'] != $employeeId) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Task not found or unauthorized');
    }

    return view('tasks/employee_view', [
        'title' => 'Task Details',
        'task'  => $task
    ]);
}

}
