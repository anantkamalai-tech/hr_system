<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="mx-auto space-y-10">

  <!-- 📝 Apply Leave Section -->
  <div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-bold text-blue-700 mb-4">📝 Apply for Leave</h2>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('leave/store') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block text-gray-700 font-semibold mb-1">Employee Name</label>
        <input type="text" value="<?= esc($employee_name) ?>" readonly
               class="w-full border border-gray-300 rounded-md p-2 bg-gray-100">
      </div>

      <div>
        <label class="block text-gray-700 font-semibold mb-1">Leave Type</label>
        <select name="leave_type" class="w-full border border-gray-300 rounded-md p-2" required>
          <option value="">Select Type</option>
          <option>Casual Leave</option>
          <option>Sick Leave</option>
          <!-- <option>Earned Leave</option> -->
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

      <button type="submit"
              class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
        Submit Leave
      </button>
    </form>
  </div>

  <!-- 📅 My Leaves Section -->
  <div class="bg-white shadow-md rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">📅 My Leave Applications</h3>

    <div class="overflow-x-auto">
      <table id="leaveTable" class="min-w-full text-sm border border-gray-200 rounded-md">
        <thead class="bg-gray-100">
          <tr>
            <th class="border p-2 text-left">Type</th>
            <th class="border p-2 text-left">Start</th>
            <th class="border p-2 text-left">End</th>
            <th class="border p-2 text-left">Reason</th>
            <th class="border p-2 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($leaves)): ?>
            <?php foreach ($leaves as $leave): ?>
              <tr>
                <td class="border p-2"><?= esc($leave['leave_type']) ?></td>
                <td class="border p-2"><?= esc($leave['start_date']) ?></td>
                <td class="border p-2"><?= esc($leave['end_date']) ?></td>
                <td class="border p-2"><?= esc($leave['reason']) ?></td>
                <td class="border p-2">
                  <span class="px-2 py-1 rounded text-white 
                    <?= $leave['status']=='Approved'
                        ? 'bg-green-500'
                        : ($leave['status']=='Rejected'
                            ? 'bg-red-500'
                            : 'bg-yellow-500') ?>">
                    <?= esc($leave['status']) ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ✅ DataTables Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    $('#leaveTable').DataTable({
      pageLength: 5,
      lengthMenu: [5, 10, 20],
      language: {
        emptyTable: "No leaves applied yet.",
        search: "🔍 Search:",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ leaves",
        paginate: {
          first: "First",
          last: "Last",
          next: "→",
          previous: "←"
        }
      },
      order: [[1, "desc"]] // Sort by Start Date descending
    });
  });
</script>

<?= $this->endSection() ?>
