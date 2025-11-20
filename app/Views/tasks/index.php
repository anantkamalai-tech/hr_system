<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
  <h2 class="text-2xl font-bold text-gray-800">Tasks</h2>
  <a href="<?= base_url('tasks/create') ?>" 
     class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition whitespace-nowrap">
     + New Task
  </a>
</div>

<!-- Filters -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
    <label class="text-sm font-medium text-gray-700 block mb-1">Filter by Date:</label>
    <input type="date" id="createdDateFilter" class="border border-gray-300 rounded p-2 w-full">
  </div>
  <div>
    <label class="text-sm font-medium text-gray-700 block mb-1">Filter by Employee:</label>
    <select id="employeeFilter" class="border border-gray-300 rounded p-2 w-full">
      <option value="">All Employees</option>
      <?php foreach ($employees as $emp): ?>
        <option value="<?= esc($emp['name']) ?>"><?= esc($emp['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>


</div>

<!-- Scrollable Table -->
<div id="tableContainer" class="bg-white rounded-xl shadow border border-gray-200 p-4 overflow-x-auto">
  <table id="tasksTable" class="display nowrap w-full">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Title</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Project</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Assignee</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Due Date</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Priority</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Created</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
        <th class="px-4 py-2 text-center text-sm font-medium text-gray-600">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tasks as $t): ?>
      <tr class="border-t hover:bg-gray-50 transition">
        <td class="px-4 py-2 text-sm text-gray-700">#<?= $t['id'] ?></td>
        <td class="px-4 py-2 text-sm text-gray-700"><?= esc($t['title']) ?></td>
        <td class="px-4 py-2 text-sm text-gray-700"><?= esc($t['project_name'] ?: '—') ?></td>
        <td class="px-4 py-2 text-sm text-gray-700"><?= esc($t['employee_name'] ?: '—') ?></td>
        <td class="px-4 py-2 text-sm text-gray-700"><?= esc($t['due_date'] ?: '—') ?></td>
        <td class="px-4 py-2 text-sm">
          <?php if ($t['priority'] == 'P1'): ?>
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Critical</span>
          <?php elseif ($t['priority'] == 'P2'): ?>
            <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-medium">High</span>
          <?php else: ?>
            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Normal</span>
          <?php endif; ?>
        </td>
        <td class="px-4 py-2 text-sm text-gray-700"><?= esc($t['created_at'] ?: '—') ?></td>
        <td class="px-4 py-2 text-sm text-gray-700 capitalize"><?= esc($t['status']) ?></td>
        <td class="px-4 py-2 text-sm text-center space-x-2">
          <a href="<?= base_url('tasks/view/'.$t['id']) ?>" class="text-sky-600 hover:underline">View</a>
          <a href="<?= base_url('tasks/edit/'.$t['id']) ?>" class="text-amber-600 hover:underline">Edit</a>
          <a href="<?= base_url('tasks/delete/'.$t['id']) ?>" 
             onclick="return confirm('Delete this task?')" 
             class="text-red-600 hover:underline">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>

<!-- Scripts -->
<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {

  var table = $('#tasksTable').DataTable({
      responsive: false,        // 🔥 disable hiding
      scrollX: true,            // 🔥 always show horizontal scroll
      autoWidth: false,
      pageLength: 10,
      order: [[0, 'desc']],
      dom: 'Bfrtip',
      buttons: ['excel', 'pdf', 'print'],
      language: {
          search: "_INPUT_",
          searchPlaceholder: "Search tasks..."
      },
      columnDefs: [
          { orderable: false, targets: -1 }
      ]
  });

  // Filter - Employee
  $('#employeeFilter').on('change', function() {
      table.column(3).search($(this).val()).draw();
  });

  // Filter - Single Created Date
  $.fn.dataTable.ext.search.push(function(settings, data) {
      var selected = $('#createdDateFilter').val();
      var created = data[6];
      return (!selected || created.startsWith(selected));
  });

  $('#createdDateFilter').on('change', () => table.draw());
});
</script>
<?= $this->endSection() ?>

