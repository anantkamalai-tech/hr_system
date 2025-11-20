<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Employees extends Controller
{
    protected $employeeModel;
    protected $session;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->employeeModel = new EmployeeModel();
        $this->session = session();
    }

    // ðŸ”¹ List all employees
    public function index()
    {
        $data = [
            'title' => 'Employees',
            'employees' => $this->employeeModel->orderBy('id', 'DESC')->findAll(),
        ];
        return view('employees/index', $data);
    }

    // ðŸ”¹ Create form
    public function create()
    {
        return view('employees/create', ['title' => 'Add Employee']);
    }

    // ðŸ”¹ Store new employee
    // public function store()
    // {
    //     $photo = $this->request->getFile('photo');
    //     $photoName = null;
    //     if ($photo && $photo->isValid()) {
    //         $photoName = $photo->getRandomName();
    //         $photo->move(FCPATH . 'uploads/employees/photos', $photoName);
    //     }

    //     $data = $this->request->getPost();
    //     $data['photo'] = $photoName;

    //     // âœ… Hash password before insert
    //     if (!empty($data['password'])) {
    //         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    //     }

    //     // document uploads
    //     foreach (['doc_aadhar', 'doc_pan', 'doc_resume', 'doc_offer'] as $docField) {
    //         $file = $this->request->getFile($docField);
    //         if ($file && $file->isValid()) {
    //             $fileName = $file->getRandomName();
    //             $file->move(FCPATH . 'uploads/employees/docs', $fileName);
    //             $data[$docField] = $fileName;
    //         }
    //     }

    //     $this->employeeModel->insert($data);
    //     return redirect()->to('/employees')->with('success', 'Employee added successfully');
    // }
    
    // public function store()
    // {
    //     $photo = $this->request->getFile('photo');
    //     $photoName = null;
    //     if ($photo && $photo->isValid()) {
    //         $photoName = $photo->getRandomName();
    //         $photo->move(FCPATH . 'uploads/employees/photos', $photoName);
    //     }
    
    //     $data = $this->request->getPost();
    //     $data['photo'] = $photoName;
    
    //     // ✅ Hash password before insert
    //     $plainPassword = $data['password']; // store for email
    //     if (!empty($data['password'])) {
    //         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    //     }
    
    //     // document uploads
    //     foreach (['doc_aadhar', 'doc_pan', 'doc_resume', 'doc_offer'] as $docField) {
    //         $file = $this->request->getFile($docField);
    //         if ($file && $file->isValid()) {
    //             $fileName = $file->getRandomName();
    //             $file->move(FCPATH . 'uploads/employees/docs', $fileName);
    //             $data[$docField] = $fileName;
    //         }
    //     }
    
    //     // ✅ Insert into DB
    //     $this->employeeModel->insert($data);
    
    //     // ✅ Send email after successful insert
    //     $email = \Config\Services::email();
    
    //     $email->setTo($data['email']);
    //     $email->setFrom('anantkamalsoftwarelab@gmail.com', 'HR Department');
    //     $email->setSubject('🎉 Welcome to the Company - Your Login Details');
    
    //     $message = "
    //         <h2>Welcome, {$data['name']}!</h2>
    //         <p>Your employee account has been successfully created.</p>
    //         <p><strong>Login Details:</strong></p>
    //         <table style='border-collapse:collapse;'>
    //             <tr><td>Email:</td><td>{$data['email']}</td></tr>
    //             <tr><td>Password:</td><td>{$plainPassword}</td></tr>
    //         </table>
    //         <br>
    //         <p>You can log in here: <a href='" . base_url('login') . "'>" . base_url('login') . "</a></p>
    //         <p style='color:gray;font-size:13px;'>Please change your password after logging in for the first time.</p>
    //     ";
    
    //     $email->setMessage($message);
    
    //     if (!$email->send()) {
    //         log_message('error', 'Email sending failed: ' . print_r($email->printDebugger(), true));
    //     }
    
    //     return redirect()->to('/employees')->with('success', 'Employee added successfully and email sent.');
    // }
    
    public function store_old()
    {
        $photo = $this->request->getFile('photo');
        $photoName = null;
        if ($photo && $photo->isValid()) {
            $photoName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/employees/photos', $photoName);
        }
    
        $data = $this->request->getPost();
        $data['photo'] = $photoName;
    
        // ✅ Hash password and store plain password for email
        $plainPassword = $data['password'];
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
    
        // ✅ Handle document uploads
        foreach (['doc_aadhar', 'doc_pan', 'doc_resume', 'doc_offer'] as $docField) {
            $file = $this->request->getFile($docField);
            if ($file && $file->isValid()) {
                $fileName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/employees/docs', $fileName);
                $data[$docField] = $fileName;
            }
        }
    
        // ✅ Insert into database
        $this->employeeModel->insert($data);
    
        // ✅ Send welcome email
        $email = \Config\Services::email();
    
        $email->setTo($data['email']);
        $email->setFrom('anantkamalsoftwarelab@gmail.com', 'HR Department');
        $email->setSubject('Welcome to the Company - Your Login Details');
    
        $message = "
            <h2>Welcome, {$data['name']}!</h2>
            <p>Your employee account has been successfully created.</p>
            <p><strong>Login Details:</strong></p>
            <table style='border-collapse:collapse;'>
                <tr><td>Email:</td><td>{$data['email']}</td></tr>
                <tr><td>Password:</td><td>{$plainPassword}</td></tr>
            </table>
            <br>
            <p>You can log in here: <a href='" . base_url('login') . "'>" . base_url('login') . "</a></p>
            <p style='color:gray;font-size:13px;'>Please change your password after logging in for the first time.</p>
        ";
    
        $email->setMessage($message);
    
        if (!$email->send()) {
            log_message('error', 'Email sending failed: ' . print_r($email->printDebugger(['headers', 'subject']), true));
        }
    
        return redirect()->to('/employees')->with('success', 'Employee added successfully and email sent.');
    }
    
    public function store()
    {
        // ✅ Handle profile photo upload
        $photo = $this->request->getFile('photo');
        $photoName = null;
        if ($photo && $photo->isValid()) {
            $photoName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/employees/photos', $photoName);
        }
    
        // ✅ Collect POST data
        $data = $this->request->getPost();
        $data['photo'] = $photoName;
    
        // ✅ Hash password but keep plain text for email
        $plainPassword = $data['password'];
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
    
        // ✅ Handle document uploads
        foreach (['doc_aadhar', 'doc_pan', 'doc_resume', 'doc_offer'] as $docField) {
            $file = $this->request->getFile($docField);
            if ($file && $file->isValid()) {
                $fileName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/employees/docs', $fileName);
                $data[$docField] = $fileName;
            }
        }
    
        // ✅ Save employee record in DB
        $this->employeeModel->insert($data);
    
        // ✅ Load PHPMailer (local mail)
        require ROOTPATH . 'vendor/autoload.php';
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
        try {
            // ✅ Use Hostinger’s local Exim (no SMTP, no SSL)
            $mail->isMail();
    
            // ✅ Sender (must exist in your Hostinger email accounts)
            $mail->setFrom('support@brahmavalley.edu.in', 'HR Department');
    
            // ✅ Recipient
            $mail->addAddress($data['email'], $data['name']);
    
            // ✅ Email Content
            $mail->isHTML(true);
            $mail->Subject = '🎉 Welcome to the Company - Your Login Details';
            $mail->Body = "
                <h2>Welcome, {$data['name']}!</h2>
                <p>Your employee account has been successfully created.</p>
                <p><strong>Login Details:</strong></p>
                <table style='border-collapse:collapse;'>
                    <tr><td><b>Email:</b></td><td>{$data['email']}</td></tr>
                    <tr><td><b>Password:</b></td><td>{$plainPassword}</td></tr>
                </table>
                <br>
                <p>You can log in here: 
                    <a href='" . base_url('login') . "'>" . base_url('login') . "</a>
                </p>
                <p style='color:gray;font-size:13px;'>
                    Please change your password after logging in for the first time.
                </p>
            ";
    
            // ✅ Send email
            $mail->send();
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            // ✅ Log any errors for debugging
            log_message('error', 'Employee email failed: ' . $mail->ErrorInfo);
        }
    
        // ✅ Redirect after saving
        return redirect()->to('/employees')
            ->with('success', 'Employee added successfully and welcome email sent.');
    }


   



    // ðŸ”¹ Edit form
    public function edit($id)
    {
        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Employee not found');
        }

        return view('employees/edit', [
            'title' => 'Edit Employee',
            'employee' => $employee
        ]);
    }

    // ðŸ”¹ Update employee
    // public function update($id)
    // {
    //     $employee = $this->employeeModel->find($id);
    //     if (!$employee) {
    //         return redirect()->to('/employees')->with('error', 'Employee not found');
    //     }

    //     $data = $this->request->getPost();

    //     // âœ… Hash password only if new password entered
    //     if (!empty($data['password'])) {
    //         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    //     } else {
    //         $data['password'] = $employee['password']; // keep old password
    //     }

    //     // photo upload
    //     $photo = $this->request->getFile('photo');
    //     if ($photo && $photo->isValid()) {
    //         $photoName = $photo->getRandomName();
    //         $photo->move(FCPATH . 'uploads/employees/photos', $photoName);
    //         $data['photo'] = $photoName;
    //     } else {
    //         $data['photo'] = $employee['photo'];
    //     }

    //     // document uploads
    //     foreach (['doc_aadhar', 'doc_pan', 'doc_resume', 'doc_offer'] as $docField) {
    //         $file = $this->request->getFile($docField);
    //         if ($file && $file->isValid()) {
    //             $fileName = $file->getRandomName();
    //             $file->move(FCPATH . 'uploads/employees/docs', $fileName);
    //             $data[$docField] = $fileName;
    //         } else {
    //             $data[$docField] = $employee[$docField];
    //         }
    //     }

    //     $this->employeeModel->update($id, $data);
    //     return redirect()->to('/employees')->with('success', 'Employee updated successfully');
    // }

    public function update($id)
{
    $employee = $this->employeeModel->find($id);
    if (!$employee) {
        return redirect()->to('/employees')->with('error', 'Employee not found');
    }

    $data = $this->request->getPost();

    // -----------------------------------
    // ✅ PASSWORD UPDATE + SEND EMAIL
    // -----------------------------------
    $plainPassword = null;

    if (!empty($data['password'])) {
        // New password entered → Hash & store plain for email
        $plainPassword = $data['password'];
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    } else {
        // No password entered → keep old password
        $data['password'] = $employee['password'];
    }

    // -----------------------------------
    // ✅ PHOTO UPLOAD
    // -----------------------------------
    $photo = $this->request->getFile('photo');
    if ($photo && $photo->isValid()) {
        $photoName = $photo->getRandomName();
        $photo->move(FCPATH . 'uploads/employees/photos', $photoName);
        $data['photo'] = $photoName;
    } else {
        $data['photo'] = $employee['photo'];
    }

    // -----------------------------------
    // ✅ DOCUMENT UPLOADS
    // -----------------------------------
    foreach (['doc_aadhar', 'doc_pan', 'doc_resume', 'doc_offer'] as $docField) {
        $file = $this->request->getFile($docField);
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/employees/docs', $fileName);
            $data[$docField] = $fileName;
        } else {
            $data[$docField] = $employee[$docField];
        }
    }

    // -----------------------------------
    // ✅ UPDATE EMPLOYEE RECORD
    // -----------------------------------
    $this->employeeModel->update($id, $data);

    // -----------------------------------
    // ✅ SEND PASSWORD CHANGE EMAIL (ONLY IF PASSWORD UPDATED)
    // -----------------------------------
    if (!empty($plainPassword)) {

        require ROOTPATH . 'vendor/autoload.php';
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Hostinger local mail
            $mail->isMail();
            $mail->setFrom('support@brahmavalley.edu.in', 'HR Department');
            $mail->addAddress($data['email'], $data['name'] ?? $employee['name']);

            $mail->isHTML(true);
            $mail->Subject = '🔐 Your Password Has Been Updated';

            $mail->Body = "
                <h2>Hello, {$employee['name']}!</h2>
                <p>Your account password has been updated successfully.</p>

                <p><strong>New Login Details:</strong></p>
                <table style='border-collapse:collapse;'>
                    <tr><td><b>Email:</b></td><td>{$data['email']}</td></tr>
                    <tr><td><b>New Password:</b></td><td>{$plainPassword}</td></tr>
                </table>

                <br>
                <p>You can log in here: 
                    <a href='" . base_url('login') . "'>" . base_url('login') . "</a>
                </p>

                <p style='color:gray;font-size:13px;'>If you didn't request this change, contact HR immediately.</p>
            ";

            $mail->send();

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            log_message('error', 'Password change email failed: ' . $mail->ErrorInfo);
        }
    }

    return redirect()->to('/employees')->with('success', 'Employee updated successfully');
}

    // ðŸ”¹ Delete
    public function delete($id)
    {
        $this->employeeModel->delete($id);
        return redirect()->to('/employees')->with('success', 'Employee deleted successfully');
    }

    // ðŸ”¹ Profile View
    public function profile($id)
    {
        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Employee not found');
        }

        return view('employees/profile', [
            'title' => 'Employee Profile',
            'employee' => $employee
        ]);
    }
}
