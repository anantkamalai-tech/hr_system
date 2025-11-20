<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">📝 Daily Developer Reports</h2>

<?php if (session()->getFlashdata('success')): ?>
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<!-- Add New Report -->
<div class="bg-white shadow rounded-xl p-6 mb-8">
  <h3 class="text-xl font-semibold mb-4">Submit New Report</h3>

  <form method="post" action="<?= base_url('dailyreports/store') ?>" class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block mb-1 text-gray-700">Employee</label>
      <select name="employee_id" class="w-full border-gray-300 rounded-md" required>
        <option value="">Select Employee</option>
        <?php foreach ($employees as $emp): ?>
          <option value="<?= esc($emp['id']) ?>"><?= esc($emp['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block mb-1 text-gray-700">Date</label>
      <input type="date" name="date" class="w-full border-gray-300 rounded-md" value="<?= date('Y-m-d') ?>" required>
    </div>

    <div class="md:col-span-2">
      <label class="block mb-1 text-gray-700">Tasks Completed</label>
      <textarea name="tasks_completed" rows="3" class="w-full border-gray-300 rounded-md" required></textarea>
    </div>

    <div class="md:col-span-2">
      <label class="block mb-1 text-gray-700">Issues / Blockers</label>
      <textarea name="issues" rows="2" class="w-full border-gray-300 rounded-md"></textarea>
    </div>

    <div class="md:col-span-2">
      <label class="block mb-1 text-gray-700">Next Day Plan</label>
      <textarea name="next_plan" rows="2" class="w-full border-gray-300 rounded-md"></textarea>
    </div>

    <div class="md:col-span-2">
      <label class="block mb-1 text-gray-700">Remarks</label>
      <input type="text" name="remarks" class="w-full border-gray-300 rounded-md">
    </div>

    <div class="md:col-span-2 flex justify-end">
      <button class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700">Submit Report</button>
    </div>
  </form>
</div>

<!-- Report Table -->
<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
  <h3 class="text-xl font-semibold mb-4">📋 Submitted Reports</h3>
  <table class="min-w-full border text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="py-2 px-4 border-b">Date</th>
        <th class="py-2 px-4 border-b">Employee</th>
        <th class="py-2 px-4 border-b">Tasks Completed</th>
        <th class="py-2 px-4 border-b">Issues</th>
        <th class="py-2 px-4 border-b">Next Plan</th>
        <th class="py-2 px-4 border-b">Remarks</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reports as $r): ?>
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b"><?= esc($r['date']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($r['employee_name']) ?></td>
          <td class="py-2 px-4 border-b"><?= nl2br(esc($r['tasks_completed'])) ?></td>
          <td class="py-2 px-4 border-b"><?= nl2br(esc($r['issues'])) ?></td>
          <td class="py-2 px-4 border-b"><?= nl2br(esc($r['next_plan'])) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($r['remarks']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
