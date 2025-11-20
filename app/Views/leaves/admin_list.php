<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--<div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">-->
<div class=" mx-auto bg-white shadow-md rounded-lg p-6">
  <h2 class="text-xl font-bold text-blue-700 mb-4">👨‍💼 All Employee Leave Applications</h2>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <div class="overflow-x-auto">
    <table id="adminLeaveTable" class="min-w-full text-sm border border-gray-200 rounded-md">
      <thead class="bg-gray-100">
        <tr>
          <th class="border p-2 text-left">Employee</th>
          <th class="border p-2 text-left">Type</th>
          <th class="border p-2 text-left">Start</th>
          <th class="border p-2 text-left">End</th>
          <th class="border p-2 text-left">Reason</th>
          <th class="border p-2 text-left">Status</th>
          <th class="border p-2 text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($leaves)): ?>
          <!-- <tr>
            <td colspan="7" class="text-center p-3 text-gray-500">No leave applications found.</td>
          </tr> -->
        <?php else: ?>
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
                  <a href="<?= base_url('admin/leave-status/'.$leave['id'].'/Approved') ?>" class="text-green-600 font-semibold hover:underline">Approve</a> |
                  <a href="<?= base_url('admin/leave-status/'.$leave['id'].'/Rejected') ?>" class="text-red-600 font-semibold hover:underline">Reject</a>
                <?php else: ?>
                  <span class="text-gray-500">—</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ✅ DataTables Integration -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    $('#adminLeaveTable').DataTable({
      "pageLength": 10,
      "lengthMenu": [5, 10, 20, 50],
      "language": {
        "search": "🔍 Search:",
        "lengthMenu": "Show _MENU_ entries",
        "info": "Showing _START_ to _END_ of _TOTAL_ applications",
        "paginate": {
          "first": "First",
          "last": "Last",
          "next": "→",
          "previous": "←"
        }
      },
      "order": [[ 2, "desc" ]], // Sort by Start Date by default
      "columnDefs": [
        { "orderable": false, "targets": 6 } // Disable sorting for Action column
      ]
    });
  });
</script>

<?= $this->endSection() ?>
