<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $session;
    protected $userModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->session = session();
        $this->userModel = new UserModel();
    }

    // 🔹 Show Login Form
    public function login()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    // 🔹 Handle Login Request
    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Email and password required');
        }

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Incorrect password');
        }

        $this->session->set([
            'isLoggedIn' => true,
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
        ]);

        return redirect()->to('/');
    }

    // 🔹 Logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
