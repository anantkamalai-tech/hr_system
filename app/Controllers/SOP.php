<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SOPModel;

class SOP extends BaseController
{
    public function index()
    {
        return view('sop/sop_form');
    }

    public function save()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid JSON data']);
        }

        // ✅ Handle signature
        if (empty($data['signature'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Signature missing']);
        }

        $signatureData = $data['signature'];
        $signature = str_replace('data:image/png;base64,', '', $signatureData);
        $signature = str_replace(' ', '+', $signature);
        $signatureImage = base64_decode($signature);

        $fileName = 'signature_' . time() . '.png';
        $uploadDir = FCPATH . 'uploads/signatures/';
        $filePath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        file_put_contents($filePath, $signatureImage);

        // ✅ Save in DB
        $sopModel = new SOPModel();
        $sopModel->insert([
            'name' => $data['name'] ?? '',
            'emp_id' => $data['empId'] ?? '',
            'department' => $data['dept'] ?? '',
            'email' => $data['email'] ?? '',
            'effective_date' => $data['date'] ?? date('Y-m-d'),
            'consent' => !empty($data['consent']) ? 1 : 0,
            'signature_path' => 'uploads/signatures/' . $fileName
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'SOP consent saved successfully!',
            'signature_url' => base_url('uploads/signatures/' . $fileName)
        ]);
    }
}
