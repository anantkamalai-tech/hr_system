<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="flex items-center justify-between mb-8">
  <h2 class="text-2xl font-bold text-gray-800"><?= esc($project['name']) ?></h2>
  <a href="<?= base_url('projects/edit/'.$project['id']) ?>" 
     class="bg-sky-500 text-white px-4 py-2 rounded-lg shadow hover:bg-sky-600 transition">
    Edit Project
  </a>
</div>

<!-- Project Summary -->
<div class="grid md:grid-cols-3 gap-4 mb-8">
  <div class="bg-white shadow rounded-xl border border-gray-200 p-5">
    <p class="text-gray-500 text-sm mb-1">📅 Period</p>
    <p class="font-semibold text-gray-800"><?= esc($project['start_date'] ?: '—') ?> → <?= esc($project['end_date'] ?: '—') ?></p>
  </div>

  <div class="bg-white shadow rounded-xl border border-gray-200 p-5">
    <p class="text-gray-500 text-sm mb-1">⚙️ Capacity / WIP / Buffer</p>
    <p class="font-semibold text-gray-800"><?= esc($project['capacity']) ?>h • WIP <?= esc($project['wip_limit']) ?> • +<?= esc($project['buffer_days']) ?>d</p>
  </div>

  <div class="bg-white shadow rounded-xl border border-gray-200 p-5">
    <p class="text-gray-500 text-sm mb-1">👨‍💼 Manager</p>
    <p class="font-semibold text-gray-800"><?= esc($project['manager'] ?: '—') ?></p>
  </div>
</div>

<!-- Add Task Form -->
<div class="bg-white border border-gray-200 shadow rounded-xl p-6 mb-8">
  <h3 class="font-semibold text-lg mb-4 text-gray-800 flex items-center gap-2">
    ➕ Add Task
  </h3>

  <form action="<?= base_url('projects/'.$project['id'].'/tasks/store') ?>" method="post" class="grid md:grid-cols-2 gap-4">
    <!-- Title -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
      <input name="title" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none" required>
    </div>

    <!-- Assigned To -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>
      <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
        <option value="">—</option>
        <?php foreach($employees as $e): ?>
          <option value="<?= $e['id'] ?>"><?= esc($e['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Estimate -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Estimate (hrs)</label>
      <input type="number" step="0.5" name="estimate" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>

    <!-- Due Date -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
      <input type="date" name="due_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>

    <!-- Priority -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
      <select name="priority" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
        <option value="P3">Normal</option>
        <option value="P2">High</option>
        <option value="P1">Critical</option>
      </select>
    </div>

    <!-- Status -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
      <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
        <option value="backlog">Backlog</option>
        <option value="inprogress">In Progress</option>
        <option value="review">Review</option>
        <option value="done">Done</option>
      </select>
    </div>

    <!-- Description -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
      <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"></textarea>
    </div>

    <!-- Dependencies -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-1">Dependencies (task IDs, comma)</label>
      <input name="dependencies" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none" placeholder="e.g., 3,7">
    </div>

    <!-- Submit -->
    <div class="md:col-span-2 flex justify-end">
      <button class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition shadow">Add Task</button>
    </div>
  </form>
</div>

<!-- Kanban Board -->
<div class="grid md:grid-cols-4 gap-4">
  <?php
    $cols = ['backlog'=>'Backlog','inprogress'=>'In Progress','review'=>'Review','done'=>'Done'];
    $grouped = ['backlog'=>[], 'inprogress'=>[], 'review'=>[], 'done'=>[]];
    foreach($tasks as $t){ $grouped[$t['status']][]=$t; }
  ?>

  <?php foreach($cols as $key=>$label): ?>
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
    <div class="flex items-center justify-between mb-3">
      <h4 class="font-semibold text-gray-800"><?= $label ?></h4>
      <span class="text-xs px-2 py-1 bg-gray-100 rounded"><?= count($grouped[$key]) ?></span>
    </div>

    <div class="space-y-3 min-h-[100px]">
      <?php foreach($grouped[$key] as $t): ?>
      <div class="border border-gray-200 rounded-lg p-3 hover:shadow-sm transition">
        <div class="font-medium text-gray-800">#<?= $t['id'] ?> — <?= esc($t['title']) ?></div>
        <div class="text-xs text-gray-500 mt-1">
          <?= esc($t['employee_name'] ?: 'Unassigned') ?> • Est <?= (float)$t['estimate'] ?>h • Due <?= esc($t['due_date'] ?: '—') ?>
        </div>

        <div class="mt-3 flex items-center justify-between">
          <form method="post" action="<?= base_url('tasks/status/'.$t['id']) ?>" class="flex items-center gap-2">
            <select name="status" class="text-sm border border-gray-300 rounded-md px-2 py-1 focus:ring-sky-500 focus:border-sky-500 outline-none">
              <option value="backlog"    <?= $t['status']=='backlog'?'selected':'' ?>>Backlog</option>
              <option value="inprogress" <?= $t['status']=='inprogress'?'selected':'' ?>>In Progress</option>
              <option value="review"     <?= $t['status']=='review'?'selected':'' ?>>Review</option>
              <option value="done"       <?= $t['status']=='done'?'selected':'' ?>>Done</option>
            </select>
            <button class="text-xs bg-gray-800 text-white px-2 py-1 rounded hover:bg-gray-700">Update</button>
          </form>

          <div class="text-sm space-x-3">
            <a href="<?= base_url('tasks/edit/'.$t['id']) ?>" class="text-amber-600 hover:text-amber-800">Edit</a>
            <a href="<?= base_url('tasks/delete/'.$t['id']) ?>" onclick="return confirm('Delete this task?')" class="text-red-600 hover:text-red-800">Delete</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<?= $this->endSection() ?>

<!--rutuja-->
<!--<?= $this->extend('layouts/main') ?>-->
<!--<?= $this->section('content') ?>-->

<!--<div class="flex items-center justify-between mb-6">-->
<!--  <h2 class="text-2xl font-bold"><?= esc($project['name']) ?></h2>-->
<!--  <a href="<?= base_url('projects/edit/'.$project['id']) ?>" class="text-amber-600 hover:underline">Edit Project</a>-->
<!--</div>-->

<!--<div class="grid md:grid-cols-3 gap-4 mb-6">-->
<!--  <div class="bg-white shadow rounded-xl p-4 border">-->
<!--    <div class="text-gray-500 text-sm">Period</div>-->
<!--    <div class="font-semibold"><?= esc($project['start_date'] ?: '—') ?> → <?= esc($project['end_date'] ?: '—') ?></div>-->
<!--  </div>-->
<!--  <div class="bg-white shadow rounded-xl p-4 border">-->
<!--    <div class="text-gray-500 text-sm">Capacity / WIP / Buffer</div>-->
<!--    <div class="font-semibold"><?= esc($project['capacity']) ?>h • WIP <?= esc($project['wip_limit']) ?> • +<?= esc($project['buffer_days']) ?>d</div>-->
<!--  </div>-->
<!--  <div class="bg-white shadow rounded-xl p-4 border">-->
<!--    <div class="text-gray-500 text-sm">Manager</div>-->
<!--    <div class="font-semibold"><?= esc($project['manager'] ?: '—') ?></div>-->
<!--  </div>-->
<!--</div>-->

<!-- Task Create -->
<!--<div class="bg-white shadow rounded-xl p-4 border mb-6">-->
<!--  <h3 class="font-semibold mb-3">Add Task</h3>-->
<!--  <form action="<?= base_url('projects/'.$project['id'].'/tasks/store') ?>" method="post" class="grid md:grid-cols-2 gap-4">-->
<!--    <div>-->
<!--      <label class="block text-sm">Title</label>-->
<!--      <input name="title" class="w-full border-gray-300 rounded-md" required>-->
<!--    </div>-->
<!--    <div>-->
<!--      <label class="block text-sm">Assigned To</label>-->
<!--      <select name="assigned_to" class="w-full border-gray-300 rounded-md">-->
<!--        <option value="">—</option>-->
<!--        <?php foreach($employees as $e): ?>-->
<!--          <option value="<?= $e['id'] ?>"><?= esc($e['name']) ?></option>-->
<!--        <?php endforeach; ?>-->
<!--      </select>-->
<!--    </div>-->
<!--    <div>-->
<!--      <label class="block text-sm">Estimate (hrs)</label>-->
<!--      <input type="number" step="0.5" name="estimate" class="w-full border-gray-300 rounded-md">-->
<!--    </div>-->
<!--    <div>-->
<!--      <label class="block text-sm">Due Date</label>-->
<!--      <input type="date" name="due_date" class="w-full border-gray-300 rounded-md">-->
<!--    </div>-->
<!--    <div>-->
<!--      <label class="block text-sm">Priority</label>-->
<!--      <select name="priority" class="w-full border-gray-300 rounded-md">-->
<!--        <option value="P3">Normal</option><option value="P2">High</option><option value="P1">Critical</option>-->
<!--      </select>-->
<!--    </div>-->
<!--    <div>-->
<!--      <label class="block text-sm">Status</label>-->
<!--      <select name="status" class="w-full border-gray-300 rounded-md">-->
<!--        <option value="backlog">Backlog</option>-->
<!--        <option value="inprogress">In Progress</option>-->
<!--        <option value="review">Review</option>-->
<!--        <option value="done">Done</option>-->
<!--      </select>-->
<!--    </div>-->
<!--    <div class="md:col-span-2">-->
<!--      <label class="block text-sm">Description</label>-->
<!--      <textarea name="description" class="w-full border-gray-300 rounded-md" rows="2"></textarea>-->
<!--    </div>-->
<!--    <div class="md:col-span-2">-->
<!--      <label class="block text-sm">Dependencies (task IDs, comma)</label>-->
<!--      <input name="dependencies" class="w-full border-gray-300 rounded-md" placeholder="e.g., 3,7">-->
<!--    </div>-->

<!--    <div class="md:col-span-2">-->
<!--      <button class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700">Add Task</button>-->
<!--    </div>-->
<!--  </form>-->
<!--</div>-->

<!-- Kanban -->
<!--<div class="grid md:grid-cols-4 gap-4">-->
<!-- -->
<!--    $cols = ['backlog'=>'Backlog','inprogress'=>'In Progress','review'=>'Review','done'=>'Done'];-->
<!--    $grouped = ['backlog'=>[], 'inprogress'=>[], 'review'=>[], 'done'=>[]];-->
<!--    foreach($tasks as $t){ $grouped[$t['status']][]=$t; }-->
<!--  ?>-->
<!--  <?php foreach($cols as $key=>$label): ?>-->
<!--  <div class="bg-white shadow rounded-xl p-3 border">-->
<!--    <div class="flex items-center justify-between mb-2">-->
<!--      <h4 class="font-semibold"><?= $label ?></h4>-->
<!--      <span class="text-xs px-2 py-1 bg-gray-100 rounded"><?= count($grouped[$key]) ?></span>-->
<!--    </div>-->
<!--    <div class="space-y-3">-->
<!--      <?php foreach($grouped[$key] as $t): ?>-->
<!--        <div class="border rounded-lg p-3">-->
<!--          <div class="font-medium">#<?= $t['id'] ?> — <?= esc($t['title']) ?></div>-->
<!--          <div class="text-xs text-gray-500">-->
<!--            <?= esc($t['employee_name'] ?: 'Unassigned') ?> • Est <?= (float)$t['estimate'] ?>h • Due <?= esc($t['due_date'] ?: '—') ?>-->
<!--          </div>-->
<!--          <div class="mt-2 flex items-center justify-between">-->
<!--            <form method="post" action="<?= base_url('tasks/status/'.$t['id']) ?>" class="flex items-center gap-2">-->
<!--              <select name="status" class="text-sm border-gray-300 rounded-md">-->
<!--                <option value="backlog"    <?= $t['status']=='backlog'?'selected':'' ?>>Backlog</option>-->
<!--                <option value="inprogress" <?= $t['status']=='inprogress'?'selected':'' ?>>In Progress</option>-->
<!--                <option value="review"     <?= $t['status']=='review'?'selected':'' ?>>Review</option>-->
<!--                <option value="done"       <?= $t['status']=='done'?'selected':'' ?>>Done</option>-->
<!--              </select>-->
<!--              <button class="text-xs bg-gray-800 text-white px-2 py-1 rounded">Update</button>-->
<!--            </form>-->
<!--            <div class="text-sm space-x-3">-->
<!--              <a href="<?= base_url('tasks/edit/'.$t['id']) ?>" class="text-amber-600 hover:underline">Edit</a>-->
<!--              <a href="<?= base_url('tasks/delete/'.$t['id']) ?>" class="text-red-600 hover:underline" onclick="return confirm('Delete this task?')">Delete</a>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      <?php endforeach; ?>-->
<!--    </div>-->
<!--  </div>-->
<!--  <?php endforeach; ?>-->
<!--</div>-->

<!--<?= $this->endSection() ?>-->




<!--<= $this->extend('layouts/main') ?>-->
<!--<= $this->section('content') ?>-->

<!--<h2 class="text-3xl font-semibold mb-6"><= esc($project['title']) ?></h2>-->

<!--<div class="bg-white p-6 rounded-xl shadow mb-6">-->
<!--  <div class="grid md:grid-cols-2 gap-4">-->
<!--    <p><strong>Start Date:</strong> <= esc($project['start_date']) ?></p>-->
<!--    <p><strong>End Date:</strong> <= esc($project['end_date']) ?></p>-->
<!--    <p><strong>Assigned To:</strong> <= esc($project['assigned_to']) ?></p>-->
<!--    <p><strong>Status:</strong> <= esc($project['status']) ?></p>-->
<!--  </div>-->
<!--  <div class="mt-4 flex gap-3">-->
<!--    <a href="<= base_url('projects/edit/'.$project['id']) ?>" class="px-3 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">✏️ Edit</a>-->
<!--    <a href="<= base_url('projects/delete/'.$project['id']) ?>" onclick="return confirm('Delete project?')" class="px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">🗑️ Delete</a>-->
<!--  </div>-->
<!--</div>-->

<!-- Add Task -->
<!--<div class="bg-white p-6 rounded-xl shadow mb-6">-->
<!--  <h3 class="text-2xl font-semibold mb-4">Add Task</h3>-->
<!--  <form method="post" action="<= base_url('projects/task/'.$project['id'].'/store') ?>" class="grid md:grid-cols-2 gap-4">-->
<!--    <input type="text" name="title" placeholder="Task Title" class="border-gray-300 rounded-md" required>-->
<!--    <select name="assigned_to" class="border-gray-300 rounded-md">-->
<!--      <option value="">Assign To</option>-->
<!--      <php foreach ($employees as $emp): ?>-->
<!--        <option value="<= esc($emp['name']) ?>"><= esc($emp['name']) ?></option>-->
<!--      <php endforeach; ?>-->
<!--    </select>-->
<!--    <textarea name="description" placeholder="Task Description" rows="2" class="border-gray-300 rounded-md md:col-span-2"></textarea>-->
<!--    <input type="date" name="due_date" class="border-gray-300 rounded-md">-->
<!--    <select name="status" class="border-gray-300 rounded-md">-->
<!--      <option>Pending</option>-->
<!--      <option>Ongoing</option>-->
<!--      <option>Completed</option>-->
<!--    </select>-->
<!--    <button class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 md:col-span-2">Add Task</button>-->
<!--  </form>-->
<!--</div>-->

<!-- Task List -->
<!--<div class="bg-white p-6 rounded-xl shadow">-->
<!--  <h3 class="text-2xl font-semibold mb-4">Tasks</h3>-->
<!--  <table class="min-w-full border text-sm">-->
<!--    <thead class="bg-gray-100 text-gray-700">-->
<!--      <tr>-->
<!--        <th class="py-2 px-4 border-b">Title</th>-->
<!--        <th class="py-2 px-4 border-b">Assigned To</th>-->
<!--        <th class="py-2 px-4 border-b">Due Date</th>-->
<!--        <th class="py-2 px-4 border-b">Status</th>-->
<!--        <th class="py-2 px-4 border-b text-center">Actions</th>-->
<!--      </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--      <php foreach ($tasks as $t): ?>-->
<!--        <tr class="hover:bg-gray-50">-->
<!--          <td class="py-2 px-4 border-b"><= esc($t['title']) ?></td>-->
<!--          <td class="py-2 px-4 border-b"><= esc($t['assigned_to']) ?></td>-->
<!--          <td class="py-2 px-4 border-b"><= esc($t['due_date']) ?></td>-->
<!--          <td class="py-2 px-4 border-b">-->
<!--            <select class="status-dropdown border-gray-300 rounded" data-id="<= $t['id'] ?>">-->
<!--              <php foreach(['Pending','Ongoing','Completed'] as $status): ?>-->
<!--                <option value="<= $status ?>" <= $t['status']==$status?'selected':'' ?>><= $status ?></option>-->
<!--              <php endforeach; ?>-->
<!--            </select>-->
<!--          </td>-->
<!--          <td class="py-2 px-4 border-b text-center">-->
<!--            <a href="<= base_url('projects/task/delete/'.$t['id']) ?>" onclick="return confirm('Delete task?')" class="text-red-600 hover:underline">🗑️ Delete</a>-->
<!--          </td>-->
<!--        </tr>-->
<!--      <php endforeach; ?>-->
<!--    </tbody>-->
<!--  </table>-->
<!--</div>-->

<!--<script>-->
<!--  document.querySelectorAll('.status-dropdown').forEach(sel => {-->
<!--    sel.addEventListener('change', async (e) => {-->
<!--      const id = e.target.dataset.id;-->
<!--      const status = e.target.value;-->
<!--      await fetch('<= base_url('projects/task/update-status') ?>/' + id, {-->
<!--        method: 'POST',-->
<!--        headers: {'Content-Type': 'application/x-www-form-urlencoded'},-->
<!--        body: 'status=' + encodeURIComponent(status)-->
<!--      });-->
<!--    });-->
<!--  });-->
<!--</script>-->

<!--<= $this->endSection() ?>-->
