<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Employee Attendance</h2>

<?php if (session()->getFlashdata('success')): ?>
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php elseif (session()->getFlashdata('error')): ?>
  <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<!-- Check-in Form -->
<form method="post" action="<?= base_url('attendance/checkin') ?>" class="mb-6 grid md:grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow">
  <select name="employee_id" class="border-gray-300 rounded-md" required>
    <option value="">Select Employee</option>
    <?php foreach ($employees as $emp): ?>
      <option value="<?= esc($emp['id']) ?>"><?= esc($emp['name']) ?></option>
    <?php endforeach; ?>
  </select>
  <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Check-In</button>
</form>

<!-- Check-out Form -->
<form method="post" action="<?= base_url('attendance/checkout') ?>" class="mb-6 grid md:grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow">
  <select name="employee_id" class="border-gray-300 rounded-md" required>
    <option value="">Select Employee</option>
    <?php foreach ($employees as $emp): ?>
      <option value="<?= esc($emp['id']) ?>"><?= esc($emp['name']) ?></option>
    <?php endforeach; ?>
  </select>
  <button class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700">Check-Out</button>
</form>

<!-- Attendance Table -->
<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
  <table class="min-w-full border text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="py-2 px-4 border-b">Employee</th>
        <th class="py-2 px-4 border-b">Date</th>
        <th class="py-2 px-4 border-b">Check-In</th>
        <th class="py-2 px-4 border-b">Check-Out</th>
        <th class="py-2 px-4 border-b">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($attendance as $a): ?>
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b"><?= esc($a['employee_name']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($a['date']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($a['check_in'] ?? '-') ?></td>
          <td class="py-2 px-4 border-b"><?= esc($a['check_out'] ?? '-') ?></td>
          <td class="py-2 px-4 border-b"><?= esc($a['status']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
