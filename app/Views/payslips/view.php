<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-white shadow-md rounded-lg p-8 max-w-3xl mx-auto">

  <div class="border-b pb-4 mb-4">
    <p><strong>Employee Name:</strong> <?= esc($payslip['name']) ?></p>
    <p><strong>Employee Code:</strong> <?= esc($payslip['emp_code']) ?></p>
    <p><strong>Date of Joining:</strong> <?= esc($payslip['join_date']) ?></p>
    <p><strong>Department:</strong> <?= esc($payslip['dept']) ?></p>
    <p><strong>Designation:</strong> <?= esc($payslip['designation']) ?></p>
    <p><strong>Location:</strong> <?= esc($payslip['address']) ?></p>
    <p><strong>Account No:</strong> <?= esc($payslip['account_no']) ?></p>
  </div>

  <table class="w-full text-left border">
    <thead>
      <tr class="bg-gray-100">
        <th class="p-2 border">Particulars</th>
        <th class="p-2 border text-right">Amount (₹)</th>
      </tr>
    </thead>
    <tbody>
      <tr><td class="p-2 border">Basic Salary</td><td class="p-2 border text-right"><?= number_format($payslip['basic'],2) ?></td></tr>
      <tr><td class="p-2 border">Gross Salary</td><td class="p-2 border text-right"><?= number_format($payslip['gross'],2) ?></td></tr>
      <tr><td class="p-2 border">Loss of Pay (<?= $payslip['lop_days'] ?> Days)</td><td class="p-2 border text-right text-red-600">-<?= number_format($payslip['lop_days'],2) ?></td></tr>
      <tr class="font-bold bg-green-50"><td class="p-2 border">Net Payable</td><td class="p-2 border text-right text-green-700"><?= number_format($payslip['net_pay'],2) ?></td></tr>
    </tbody>
  </table>

  <p class="mt-6 text-gray-600 text-sm text-center italic">
    This is a system-generated payslip. No signature required.
  </p>

  <div class="text-center mt-6">
    <a href="<?= base_url('payslips/pdf/'.$payslip['id']) ?>" 
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">⬇️ Download PDF</a>
    <a href="<?= base_url('payslips') ?>" 
       class="px-4 py-2 border rounded hover:bg-gray-100 ml-2">Back</a>
  </div>
</div>

<?= $this->endSection() ?>