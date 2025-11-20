<!--<?= $this->extend('layouts/main') ?>-->
<!--<?= $this->section('content') ?>-->

<!--<div class="bg-white p-8 rounded-xl shadow max-w-3xl mx-auto">-->
<!--  <h2 class="text-2xl font-semibold mb-4 text-center text-sky-700">Salary Slip</h2>-->

<!--  <div class="border-b pb-4 mb-4">-->
<!--    <p><strong>Employee:</strong> <?= esc($payslip['name']) ?></p>-->
<!--    <p><strong>Department:</strong> <?= esc($payslip['dept']) ?></p>-->
<!--    <p><strong>Designation:</strong> <?= esc($payslip['designation']) ?></p>-->
<!--    <p><strong>Period:</strong> <?= esc($payslip['month']).' '.$payslip['year'] ?></p>-->
<!--  </div>-->

<!--  <table class="min-w-full text-sm border mb-6">-->
<!--    <thead class="bg-gray-100">-->
<!--      <tr>-->
<!--        <th class="border px-4 py-2 text-left">Earnings</th>-->
<!--        <th class="border px-4 py-2 text-right">Amount (₹)</th>-->
<!--        <th class="border px-4 py-2 text-left">Deductions</th>-->
<!--        <th class="border px-4 py-2 text-right">Amount (₹)</th>-->
<!--      </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--      <tr><td>Basic</td><td class="text-right"><?= $payslip['basic'] ?></td><td>PF</td><td class="text-right"><?= $payslip['pf'] ?></td></tr>-->
<!--      <tr><td>HRA</td><td class="text-right"><?= $payslip['hra'] ?></td><td>ESI</td><td class="text-right"><?= $payslip['esi'] ?></td></tr>-->
<!--      <tr><td>Conveyance</td><td class="text-right"><?= $payslip['convey'] ?></td><td>PT</td><td class="text-right"><?= $payslip['pt'] ?></td></tr>-->
<!--      <tr><td>Special</td><td class="text-right"><?= $payslip['special'] ?></td><td>TDS</td><td class="text-right"><?= $payslip['tds'] ?></td></tr>-->
<!--      <tr><td>Variable</td><td class="text-right"><?= $payslip['variable_pay'] ?></td><td>Other Ded.</td><td class="text-right"><?= $payslip['other_ded'] ?></td></tr>-->
<!--    </tbody>-->
<!--    <tfoot class="font-semibold">-->
<!--      <tr><td>Total Earnings</td><td class="text-right"><?= $payslip['gross'] ?></td><td>Total Deductions</td><td class="text-right"><?= $payslip['deductions'] ?></td></tr>-->
<!--      <tr class="bg-green-50"><td colspan="3" class="text-right">Net Pay</td><td class="text-right text-green-700 font-bold">₹<?= number_format($payslip['net_pay'], 2) ?></td></tr>-->
<!--    </tfoot>-->
<!--  </table>-->

<!--  <div class="text-center mt-6">-->
<!--    <button onclick="window.print()" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700">🖨 Print</button>-->
<!--    <a href="<?= base_url('payslips') ?>" class="ml-3 text-gray-600 hover:underline">← Back</a>-->
<!--  </div>-->
<!--</div>-->

<!--<?= $this->endSection() ?>-->

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

