<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
  <h2 class="text-xl font-bold text-blue-700 mb-4">📝 Apply for Leave</h2>

  <form action="<?= base_url('leave/store') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
    <div>
      <label class="block text-gray-700 font-semibold mb-1">Employee</label>
      <select name="employee_id" class="w-full border border-gray-300 rounded-md p-2" required>
        <option value="">Select Employee</option>
        <?php foreach ($employees as $emp): ?>
          <option value="<?= $emp['id'] ?>"><?= esc($emp['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block text-gray-700 font-semibold mb-1">Leave Type</label>
      <select name="leave_type" class="w-full border border-gray-300 rounded-md p-2" required>
        <option value="">Select Type</option>
        <option>Casual Leave</option>
        <option>Sick Leave</option>
        <option>Earned Leave</option>
      </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Start Date</label>
        <input type="date" name="start_date" class="w-full border border-gray-300 rounded-md p-2" required>
      </div>
      <div>
        <label class="block text-gray-700 font-semibold mb-1">End Date</label>
        <input type="date" name="end_date" class="w-full border border-gray-300 rounded-md p-2" required>
      </div>
    </div>

    <div>
      <label class="block text-gray-700 font-semibold mb-1">Reason</label>
      <textarea name="reason" rows="3" class="w-full border border-gray-300 rounded-md p-2" required></textarea>
    </div>

    <div>
      <label class="block text-gray-700 font-semibold mb-1">Attachment (Optional)</label>
      <input type="file" name="attachment" class="w-full border border-gray-300 rounded-md p-2">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
      Submit Leave
    </button>
  </form>
</div>

<?= $this->endSection() ?>
