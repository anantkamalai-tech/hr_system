<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $session;
    protected $employeeModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->session = session();
        $this->employeeModel = new EmployeeModel();
    }

    // 🔹 Show Login Page
    public function login()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    // 🔹 Handle Login Request
    public function doLogin()
    {
        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email and password are required');
        }

        // ✅ Fetch employee
        $employee = $this->employeeModel->where('email', $email)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        // ✅ Check password
        if (!password_verify($password, $employee['password'])) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        // ✅ Set Session
        $this->session->set([
            'isLoggedIn'   => true,
            'employee_id'  => $employee['id'],
            'emp_code'     => $employee['emp_code'],
            'name'         => $employee['name'],
            'email'        => $employee['email'],
            'role'         => $employee['role'],
            'dept'         => $employee['dept'],
            'designation'  => $employee['designation'],
        ]);

        // ✅ Redirect to dashboard
 
        return redirect()->to('/dashboard');
    }

    // 🔹 Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}
