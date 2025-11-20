<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
  <h2 class="text-xl font-bold text-blue-700 mb-4">Leave Applications</h2>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <table class="min-w-full border border-gray-200 rounded-md text-sm">
    <thead class="bg-gray-100">
      <tr>
        <th class="border p-2">Employee</th>
        <th class="border p-2">Type</th>
        <th class="border p-2">Start</th>
        <th class="border p-2">End</th>
        <th class="border p-2">Reason</th>
        <th class="border p-2">Status</th>
        <th class="border p-2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($leaves as $leave): ?>
        <tr>
          <td class="border p-2"><?= esc($leave['employee_name']) ?></td>
          <td class="border p-2"><?= esc($leave['leave_type']) ?></td>
          <td class="border p-2"><?= esc($leave['start_date']) ?></td>
          <td class="border p-2"><?= esc($leave['end_date']) ?></td>
          <td class="border p-2"><?= esc($leave['reason']) ?></td>
          <td class="border p-2">
            <span class="px-2 py-1 rounded text-white 
              <?= $leave['status']=='Approved'?'bg-green-500':($leave['status']=='Rejected'?'bg-red-500':'bg-yellow-500') ?>">
              <?= esc($leave['status']) ?>
            </span>
          </td>
          <td class="border p-2">
            <?php if ($leave['status'] == 'Pending'): ?>
              <a href="<?= base_url('leave/updateStatus/'.$leave['id'].'/Approved') ?>" 
                 class="text-green-600 font-semibold mr-2">Approve</a>
              <a href="<?= base_url('leave/updateStatus/'.$leave['id'].'/Rejected') ?>" 
                 class="text-red-600 font-semibold">Reject</a>
            <?php else: ?>
              <span class="text-gray-400 italic">No Action</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
