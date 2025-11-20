<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-8">
  <h2 class="text-2xl font-bold text-gray-800"><?= esc($project['name']) ?></h2>
  <a href="<?= base_url('projects') ?>" 
     class="bg-sky-800 hover:bg-sky-300 text-white px-4 py-2 rounded-lg shadow-sm">
    ← Back to Projects
  </a>
</div>

<!-- Flash Messages -->
<?php if(session()->getFlashdata('success')): ?>
  <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-sm">
    ✅ <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
  <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 border border-red-300 rounded-md shadow-sm">
    ⚠️ <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<!-- Project Summary -->
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-8">
  <h3 class="text-lg font-semibold text-gray-700 mb-3">Project Information</h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
    <p><strong>Manager:</strong> <?= esc($project['manager'] ?: '—') ?></p>
    <p><strong>Capacity:</strong> <?= esc($project['capacity'] ?: '—') ?></p>
    <p><strong>WIP Limit:</strong> <?= esc($project['wip_limit'] ?: '—') ?></p>
    <p><strong>Buffer Days:</strong> <?= esc($project['buffer_days'] ?: '—') ?></p>
    <p><strong>Start Date:</strong> <?= esc($project['start_date'] ?: '—') ?></p>
    <p><strong>End Date:</strong> <?= esc($project['end_date'] ?: '—') ?></p>
<?php
$assignedIds = explode(',', $project['assigned_to'] ?? '');
$assignedNames = [];

foreach ($employees as $emp) {
    if (in_array($emp['id'], $assignedIds)) {
        // ✅ Add role in bracket
        $assignedNames[] = $emp['name'] . ' (' . $emp['role'] . ')';
    }
}
?>
<p><strong>Assigned Employees:</strong> <?= $assignedNames ? implode(', ', $assignedNames) : 'None'; ?></p>

  </div>

  <div class="mt-4">
    <strong>Description:</strong>
    <p class="text-gray-600 mt-1 leading-relaxed"><?= esc($project['description'] ?: 'No description provided.') ?></p>
  </div>

  <!-- Progress Bar -->
  <div class="mt-6">
    <?php 
      $done = (int)($project['done_tasks'] ?? 0);
      $total = (int)($project['total_tasks'] ?? 0);
      $percent = $total > 0 ? round(($done / $total) * 100) : 0;
    ?>
    <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
      <div class="h-3 bg-sky-600" style="width: <?= $percent ?>%;"></div>
    </div>
    <p class="text-sm text-gray-500 mt-1">
      Progress: <?= $done ?>/<?= $total ?> tasks (<?= $percent ?>%)
    </p>
  </div>
</div>

<!-- Team Members Section -->
<!-- Team Members Section -->
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-8">
  <h3 class="text-lg font-semibold text-gray-700 mb-4">Team Members</h3>

  <?php if (!empty($assignedIds)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border border-gray-200 rounded-md">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 text-left">#</th>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Role</th>
            <!-- <th class="px-4 py-2 text-left">Email</th> -->
            <!-- <th class="px-4 py-2 text-left">Phone</th> -->
          </tr>
        </thead>

        <tbody>
          <?php 
            $count = 1;
            foreach ($employees as $emp):
              if (in_array($emp['id'], $assignedIds)):
          ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2"><?= $count++ ?></td>
            <td class="px-4 py-2"><?= esc($emp['name']) ?></td>
            <td class="px-4 py-2"><?= esc($emp['role']) ?></td>
            <!-- <td class="px-4 py-2"><?= esc($emp['email'] ?? '—') ?></td> -->
            <!-- <td class="px-4 py-2"><?= esc($emp['phone'] ?? '—') ?></td> -->
          </tr>
          <?php 
              endif;
            endforeach;
          ?>

          <?php if ($count === 1): ?>
            <tr>
              <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                No team members assigned.
              </td>
            </tr>
          <?php endif; ?>

        </tbody>
      </table>
    </div>

  <?php else: ?>
    <p class="text-gray-500 text-sm">No team members assigned.</p>
  <?php endif; ?>
</div>



<!-- Task List -->
<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
  <h3 class="text-lg font-semibold text-gray-700 mb-4">Tasks Assigned</h3>

  <?php if (!empty($tasks)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border border-gray-200 rounded-md">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 text-left">Title</th>
            <th class="px-4 py-2 text-left">Assigned To</th>
            <th class="px-4 py-2 text-left">Priority</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Estimate (hrs)</th>
            <th class="px-4 py-2 text-left">Due Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tasks as $t): ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2"><?= esc($t['title']) ?></td>
            <td class="px-4 py-2">
              <?php 
                $emp = array_filter($employees, fn($e) => $e['id'] == $t['assigned_to']);
                echo $emp ? esc(array_values($emp)[0]['name']) : '—';
              ?>
            </td>
            <td class="px-4 py-2">
              <span class="px-2 py-1 rounded text-xs font-medium 
                <?= $t['priority'] == 'P1' ? 'bg-red-100 text-red-700' :
                   ($t['priority'] == 'P2' ? 'bg-yellow-100 text-yellow-700' :
                   'bg-green-100 text-green-700') ?>">
                <?= esc($t['priority']) ?>
              </span>
            </td>
            <td class="px-4 py-2">
              <span class="capitalize px-2 py-1 rounded text-xs font-medium
                <?= $t['status'] == 'done' ? 'bg-green-100 text-green-700' :
                   ($t['status'] == 'inprogress' ? 'bg-blue-100 text-blue-700' :
                   ($t['status'] == 'review' ? 'bg-amber-100 text-amber-700' :
                   'bg-gray-100 text-gray-700')) ?>">
                <?= esc($t['status']) ?>
              </span>
            </td>
            <td class="px-4 py-2"><?= esc($t['estimate'] ?: '—') ?></td>
            <td class="px-4 py-2"><?= esc($t['due_date'] ?: '—') ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-500 text-sm">No tasks have been assigned for this project yet.</p>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
