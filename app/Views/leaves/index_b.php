<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">🌴 Leave Applications</h2>

<?php if (session()->getFlashdata('success')): ?>
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php elseif (session()->getFlashdata('error')): ?>
  <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<!-- Apply Leave -->
<div class="bg-white shadow rounded-xl p-6 mb-8">
  <h3 class="text-xl font-semibold mb-4">Apply for Leave</h3>

  <form method="post" action="<?= base_url('leaves/store') ?>" class="grid md:grid-cols-2 gap-4">
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
      <label class="block mb-1 text-gray-700">Leave Type</label>
      <select name="leave_type" class="w-full border-gray-300 rounded-md" required>
        <option>Casual Leave</option>
        <option>Sick Leave</option>
        <option>Earned Leave</option>
        <option>Emergency Leave</option>
      </select>
    </div>

    <div>
      <label class="block mb-1 text-gray-700">From Date</label>
      <input type="date" name="from_date" class="w-full border-gray-300 rounded-md" required>
    </div>

    <div>
      <label class="block mb-1 text-gray-700">To Date</label>
      <input type="date" name="to_date" class="w-full border-gray-300 rounded-md" required>
    </div>

    <div class="md:col-span-2">
      <label class="block mb-1 text-gray-700">Reason</label>
      <textarea name="reason" rows="3" class="w-full border-gray-300 rounded-md" required></textarea>
    </div>

    <div class="md:col-span-2 flex justify-end">
      <button class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700">Submit Leave</button>
    </div>
  </form>
</div>

<!-- Leave List -->
<div class="bg-white p-6 rounded-xl shadow overflow-x-auto">
  <h3 class="text-xl font-semibold mb-4">📋 Leave History</h3>

  <table class="min-w-full border text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="py-2 px-4 border-b">Employee</th>
        <th class="py-2 px-4 border-b">Leave Type</th>
        <th class="py-2 px-4 border-b">From</th>
        <th class="py-2 px-4 border-b">To</th>
        <th class="py-2 px-4 border-b">Reason</th>
        <th class="py-2 px-4 border-b">Status</th>
        <th class="py-2 px-4 border-b text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($leaves as $leave): ?>
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b"><?= esc($leave['employee_name']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($leave['leave_type']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($leave['from_date']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($leave['to_date']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($leave['reason']) ?></td>
          <td class="py-2 px-4 border-b">
            <?php if ($leave['status'] == 'Approved'): ?>
              <span class="text-green-600 font-semibold">Approved</span>
            <?php elseif ($leave['status'] == 'Rejected'): ?>
              <span class="text-red-600 font-semibold">Rejected</span>
            <?php else: ?>
              <span class="text-yellow-600 font-semibold">Pending</span>
            <?php endif; ?>
          </td>
          <td class="py-2 px-4 border-b text-center">
            <?php if ($leave['status'] == 'Pending'): ?>
              <a href="<?= base_url('leaves/approve/'.$leave['id']) ?>" class="text-green-600 hover:underline">✔ Approve</a> |
              <a href="<?= base_url('leaves/reject/'.$leave['id']) ?>" class="text-red-600 hover:underline">✖ Reject</a>
            <?php endif; ?>
            <a href="<?= base_url('leaves/delete/'.$leave['id']) ?>" class="text-gray-500 hover:underline" onclick="return confirm('Delete leave?')">🗑 Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
