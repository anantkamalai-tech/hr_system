<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-2"><?= esc($title) ?></h2>

<form method="post" action="<?= isset($task) ? base_url('tasks/update/'.$task['id']) : base_url('tasks/store') ?>" 
      class="bg-white p-8 rounded-xl shadow-md space-y-5 border border-gray-200">

  <!-- Project & Assigned To -->
  <div class="grid md:grid-cols-2 gap-5">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Project</label>
      <select name="project_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none" required>
        <?php foreach($projects as $p): ?>
          <option value="<?= $p['id'] ?>" <?= isset($task) && $task['project_id']==$p['id']?'selected':'' ?>><?= esc($p['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
<div>
  <label class="block text-sm font-medium text-gray-700 mb-1">Assigned To</label>

  <?php if(!empty($isEmployee) && $isEmployee): ?>
    <!-- Employee user: show their name only -->
    <input type="hidden" name="assigned_to" value="<?= esc($employeeId) ?>">
    <div class="border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-gray-600">
      <?= esc(session()->get('name')) ?>
    </div>
  <?php else: ?>
    <!-- Admin user: show dropdown -->
    <select name="assigned_to" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
      <option value="">— Select Employee —</option>
      <?php foreach($employees as $e): ?>
        <option value="<?= $e['id'] ?>" <?= isset($task) && $task['assigned_to']==$e['id']?'selected':'' ?>><?= esc($e['name']) ?></option>
      <?php endforeach; ?>
    </select>
  <?php endif; ?>
</div>
  </div>

  <!-- Title -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
    <input name="title" value="<?= esc($task['title'] ?? '') ?>" 
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none" required>
  </div>

  <!-- Description -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
    <textarea name="description" rows="4" 
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"><?= esc($task['description'] ?? '') ?></textarea>
  </div>

  <!-- Estimate & Due Date -->
  <div class="grid md:grid-cols-2 gap-5">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Estimate (hrs)</label>
      <input type="number" step="0.5" name="estimate" value="<?= esc($task['estimate'] ?? '0') ?>" 
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
      <input type="date" name="due_date" value="<?= esc($task['due_date'] ?? '') ?>" 
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>
  </div>

  <!-- Priority & Status -->
  <div class="grid md:grid-cols-2 gap-5">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
      <select name="priority" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
        <option value="P3" <?= isset($task) && $task['priority']=='P3'?'selected':'' ?>>Normal</option>
        <option value="P2" <?= isset($task) && $task['priority']=='P2'?'selected':'' ?>>High</option>
        <option value="P1" <?= isset($task) && $task['priority']=='P1'?'selected':'' ?>>Critical</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
      <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
        <option value="backlog"    <?= isset($task) && $task['status']=='backlog'?'selected':'' ?>>Backlog</option>
        <option value="inprogress" <?= isset($task) && $task['status']=='inprogress'?'selected':'' ?>>In Progress</option>
        <option value="review"     <?= isset($task) && $task['status']=='review'?'selected':'' ?>>Review</option>
        <option value="done"       <?= isset($task) && $task['status']=='done'?'selected':'' ?>>Done</option>
      </select>
    </div>
  </div>

  <!-- Dependencies -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Dependencies (Task IDs, comma separated)</label>
    <input name="dependencies" value="<?= esc($task['dependencies'] ?? '') ?>" 
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
  </div>

  <!-- Submit Button -->
  <div class="pt-4">
    <button class="bg-sky-600 text-white px-5 py-2.5 rounded-lg hover:bg-sky-700 transition">
      <?= isset($task) ? 'Update Task' : 'Create Task' ?>
    </button>

        <a href="<?= base_url('tasks') ?>" 
       class="inline-flex items-center bg-gray-700 hover:bg-gray-500 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
      Cancel
    </a>
  </div>
  
</form>

<?= $this->endSection() ?>
