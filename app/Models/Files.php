<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Files extends Controller
{
    public function employeeFile($filename)
    {
        $path = WRITEPATH . 'uploads/employees/' . $filename; // adjust if needed

        if (!file_exists($path)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File not found');
        }

        return $this->response->download($path, null);
    }
}
