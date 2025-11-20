<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">💼 Payslips</h2>

<?php if(session()->getFlashdata('success')): ?>
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<a href="<?= base_url('payslips/create') ?>" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 mb-4 inline-block">➕ Generate New</a>

<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
  <table class="min-w-full border text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="py-2 px-4 border-b">Employee</th>
        <th class="py-2 px-4 border-b">Month</th>
        <th class="py-2 px-4 border-b">Year</th>
        <th class="py-2 px-4 border-b">Net Pay</th>
        <th class="py-2 px-4 border-b text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($payslips as $p): ?>
      <tr class="hover:bg-gray-50">
        <td class="py-2 px-4 border-b"><?= esc($p['employee_name']) ?></td>
        <td class="py-2 px-4 border-b"><?= esc($p['month']) ?></td>
        <td class="py-2 px-4 border-b"><?= esc($p['year']) ?></td>
        <td class="py-2 px-4 border-b text-green-700 font-semibold">₹<?= number_format($p['net_pay'], 2) ?></td>
        <td class="py-2 px-4 border-b text-center">
          <a href="<?= base_url('payslips/view/'.$p['id']) ?>" class="text-sky-600 hover:underline">View</a> |
          <a href="<?= base_url('payslips/edit/'.$p['id']) ?>" class="text-yellow-600 hover:underline">Edit</a> |
          <a href="<?= base_url('payslips/delete/'.$p['id']) ?>" onclick="return confirm('Delete this payslip?')" class="text-red-600 hover:underline">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
