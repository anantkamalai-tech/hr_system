<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
  <h2 class="text-2xl font-bold text-gray-800">
    Task #<?= $task['id'] ?> — <?= esc($task['title']) ?>
  </h2>
  <div class="space-x-2">
    <a href="<?= base_url('tasks/edit/'.$task['id']) ?>" 
       class="inline-flex items-center bg-amber-500 hover:bg-sky-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
       Edit Task
    </a>
    <a href="<?= base_url('tasks') ?>" 
       class="inline-flex items-center bg-gray-700 hover:bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
      Cancel
    </a>
  </div>
</div>

<!-- Task Info Grid -->
<div class="grid md:grid-cols-2 gap-4">
  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
    <div class="text-sm text-gray-500">Project</div>
    <div class="font-semibold text-gray-800"><?= esc($task['project_name'] ?: '—') ?></div>
  </div>

  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
    <div class="text-sm text-gray-500">Assignee</div>
    <div class="font-semibold text-gray-800"><?= esc($task['employee_name'] ?: '—') ?></div>
  </div>

  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
    <div class="text-sm text-gray-500">Due Date • Estimate</div>
    <div class="font-semibold text-gray-800">
      <?= esc($task['due_date'] ?: '—') ?> • <?= (float)($task['estimate'] ?? 0) ?> hrs
    </div>
  </div>

  <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
    <div class="text-sm text-gray-500">Priority • Status</div>
    <div class="font-semibold text-gray-800 flex items-center space-x-2">
      <?php if ($task['priority'] == 'P1'): ?>
        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">Critical</span>
      <?php elseif ($task['priority'] == 'P2'): ?>
        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-medium">High</span>
      <?php else: ?>
        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">Normal</span>
      <?php endif; ?>

      <span>•</span>

      <span class="capitalize"><?= esc($task['status']) ?></span>
    </div>
  </div>
</div>

<!-- Description -->
<div class="bg-white border border-gray-200 rounded-xl p-5 mt-6 shadow-sm">
  <div class="text-sm text-gray-500 mb-1">Description</div>
  <div class="text-gray-700 whitespace-pre-line leading-relaxed">
    <?= esc($task['description'] ?: '—') ?>
  </div>
</div>

<!-- Dependencies -->
<?php if (!empty($task['dependencies'])): ?>
<div class="bg-white border border-gray-200 rounded-xl p-5 mt-4 shadow-sm">
  <div class="text-sm text-gray-500 mb-1">Dependencies</div>
  <div class="text-gray-700"><?= esc($task['dependencies']) ?></div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
