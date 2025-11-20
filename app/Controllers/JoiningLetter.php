<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\JoiningLetterModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class JoiningLetter extends BaseController
{
    public function index()
    {
        return view('joining_letter/form');
    }

    public function save()
    {
        helper(['form', 'filesystem']);
        $model = new JoiningLetterModel();

        $data = [
            'company_name'   => $this->request->getPost('company_name'),
            'company_address'=> $this->request->getPost('company_address'),
            'company_contact'=> $this->request->getPost('company_contact'),
            'cin'            => $this->request->getPost('cin'),
            'emp_name'       => $this->request->getPost('emp_name'),
            'emp_id'         => $this->request->getPost('emp_id') ?: 'EMP-'.date('Y').'-'.rand(1000,9999),
            'designation'    => $this->request->getPost('designation'),
            'department'     => $this->request->getPost('department'),
            'join_date'      => $this->request->getPost('join_date'),
            'location'       => $this->request->getPost('location'),
            'work_mode'      => $this->request->getPost('work_mode'),
            'ctc'            => $this->request->getPost('ctc'),
            'probation'      => $this->request->getPost('probation'),
            'notice_period'  => $this->request->getPost('notice_period'),
            'manager'        => $this->request->getPost('manager'),
            'work_hours'     => $this->request->getPost('work_hours'),
            'notes'          => $this->request->getPost('notes'),
            'include_hindi'  => $this->request->getPost('include_hindi') === 'yes' ? 1 : 0,
            'include_legal'  => $this->request->getPost('include_legal') === 'yes' ? 1 : 0,
        ];

        // Upload logo
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid()) {
            $logoName = $logo->getRandomName();
            $logo->move(FCPATH.'uploads/logos', $logoName);
            $data['logo_path'] = 'uploads/logos/'.$logoName;
        }

        // Upload signature
        $sign = $this->request->getFile('signature');
        if ($sign && $sign->isValid()) {
            $signName = $sign->getRandomName();
            $sign->move(FCPATH.'uploads/signatures', $signName);
            $data['sign_path'] = 'uploads/signatures/'.$signName;
        }

        // Save record
        $id = $model->insert($data);

        // Generate PDF
        $pdfPath = $this->generatePDF($data, $id);
        $model->update($id, ['pdf_path' => $pdfPath]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Joining letter saved successfully!',
            'preview_url' => base_url($pdfPath),
            'download_url' => base_url('joiningletter/download/'.$id)
        ]);
    }

    private function generatePDF($data, $id)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $html = view('joining_letter/pdf_template', ['data' => $data]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filePath = 'uploads/joining_letters/joining_letter_'.$id.'.pdf';
        if (!is_dir(FCPATH.'uploads/joining_letters')) {
            mkdir(FCPATH.'uploads/joining_letters', 0777, true);
        }

        file_put_contents(FCPATH.$filePath, $dompdf->output());
        return $filePath;
    }

    // 👇 For PDF download option
    public function download($id)
    {
        $model = new JoiningLetterModel();
        $record = $model->find($id);

        if (!$record || empty($record['pdf_path'])) {
            return $this->response->setStatusCode(404)->setBody('File not found.');
        }

        return $this->response->download(FCPATH . $record['pdf_path'], null);
    }
}
