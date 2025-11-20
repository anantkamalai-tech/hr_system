<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-8">
  <h2 class="text-2xl font-bold text-gray-800">Projects</h2>
  <a href="<?= base_url('projects/create') ?>" 
     class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-lg shadow transition">
    + New Project
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

<!-- Projects Grid -->
<?php if (!empty($projects)): ?>
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
  <?php foreach($projects as $p): ?>
  <div class="project-card bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition p-5 relative cursor-pointer"
       data-href="<?= base_url('projects/detail/'.$p['id']) ?>">
       
    <!-- Header -->
    <div class="flex justify-between items-start mb-3">
      <div>
        <h3 class="font-semibold text-lg text-gray-800"><?= esc($p['name']) ?></h3>
        <p class="text-sm text-gray-500">
          Manager: <span class="font-medium"><?= esc($p['manager'] ?: '—') ?></span>
        </p>
      </div>
      <span class="text-xs text-gray-400 whitespace-nowrap">
        <?= esc($p['start_date'] ?: '—') ?> → <?= esc($p['end_date'] ?: '—') ?>
      </span>
    </div>

    <!-- Description -->
    <p class="text-gray-600 text-sm line-clamp-3 mb-4">
      <?= esc($p['description'] ?: 'No description available') ?>
    </p>

    <!-- Progress Info -->
    <div class="mb-3">
      <?php 
        $done = (int)($p['done_tasks'] ?? 0);
        $total = (int)($p['total_tasks'] ?? 0);
        $percent = $total > 0 ? round(($done / $total) * 100) : 0;
      ?>
      <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
        <div class="h-2 bg-sky-500 transition-all duration-300" style="width: <?= $percent ?>%;"></div>
      </div>
      <p class="text-xs text-gray-500 mt-1">Progress: <?= $done ?>/<?= $total ?> (<?= $percent ?>%)</p>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center mt-4">
      <a href="<?= base_url('projects/view/'.$p['id']) ?>" 
         class="text-sky-600 hover:text-sky-800 font-medium text-sm">Add Tasks</a>
      <div class="space-x-3 text-sm">
        <a href="<?= base_url('projects/edit/'.$p['id']) ?>" 
           class="text-amber-600 hover:text-amber-800 font-medium">Edit</a>
        <a href="<?= base_url('projects/delete/'.$p['id']) ?>" 
           onclick="return confirm('Delete this project?')" 
           class="text-red-600 hover:text-red-800 font-medium">Delete</a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php else: ?>
  <div class="text-center text-gray-500 py-10 bg-white border rounded-xl shadow-sm">
    🚀 No projects found. 
    <a href="<?= base_url('projects/create') ?>" class="text-sky-600 hover:underline">Create one</a>
  </div>
<?php endif; ?>

<!-- Clickable card script -->
<script>
document.querySelectorAll('.project-card').forEach(card => {
  card.addEventListener('click', e => {
    // Prevent navigation if user clicked on a link or button inside the card
    if (e.target.tagName === 'A' || e.target.closest('a')) return;
    window.location.href = card.dataset.href;
  });
});
</script>

<?= $this->endSection() ?>


<!--rutuja-->
<!-- $this->extend('layouts/main') ?>-->
<!-- $this->section('content') ?>-->

<!--<div class="flex items-center justify-between mb-6">-->
<!--  <h2 class="text-2xl font-bold">Projects</h2>-->
<!--  <a href="<?= base_url('projects/create') ?>" class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700">+ New Project</a>-->
<!--</div>-->

<!--<?php if(session()->getFlashdata('success')): ?>-->
<!--  <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded"><?= session()->getFlashdata('success') ?></div>-->
<!--<?php endif; ?>-->
<!--<?php if(session()->getFlashdata('error')): ?>-->
<!--  <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 rounded"><?= session()->getFlashdata('error') ?></div>-->
<!--<?php endif; ?>-->

<!--<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">-->
<!--  <?php foreach($projects as $p): ?>-->
<!--  <div class="bg-white shadow rounded-xl p-4 border">-->
<!--    <div class="flex justify-between items-center">-->
<!--      <div>-->
<!--        <div class="font-semibold text-lg"><?= esc($p['name']) ?></div>-->
<!--        <div class="text-gray-500 text-sm"><?= esc($p['manager'] ?: '—') ?></div>-->
<!--      </div>-->
<!--      <div class="text-xs text-gray-500"><?= esc($p['start_date'] ?: '—') ?> → <?= esc($p['end_date'] ?: '—') ?></div>-->
<!--    </div>-->
<!--    <p class="text-gray-600 text-sm mt-2"><?= esc($p['description'] ?: 'No description') ?></p>-->

<!--    <div class="mt-3 flex items-center justify-between text-sm">-->
<!--      <span class="px-2 py-1 rounded bg-gray-100">Tasks: <?= (int)($p['done_tasks'] ?? 0) ?>/<?= (int)($p['total_tasks'] ?? 0) ?></span>-->
<!--      <div class="space-x-3">-->
<!--        <a href="<?= base_url('projects/view/'.$p['id']) ?>" class="text-sky-600 hover:underline">View</a>-->
<!--        <a href="<?= base_url('projects/edit/'.$p['id']) ?>" class="text-amber-600 hover:underline">Edit</a>-->
<!--        <a href="<?= base_url('projects/delete/'.$p['id']) ?>" class="text-red-600 hover:underline" onclick="return confirm('Delete this project?')">Delete</a>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--  <?php endforeach; ?>-->
<!--</div>-->

<!-- $this->endSection() ?>-->



<!--<= $this->extend('layouts/main') ?>-->
<!--<= $this->section('content') ?>-->

<!--<h2 class="text-3xl font-semibold mb-6">Projects</h2>-->

<!--<php if (session()->getFlashdata('success')): ?>-->
<!--  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">-->
<!--    <= session()->getFlashdata('success') ?>-->
<!--  </div>-->
<!--<php endif; ?>-->

<!--<a href="<= base_url('projects/create') ?>" class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700 mb-4 inline-block">➕ Add Project</a>-->

<!--<div class="overflow-x-auto bg-white shadow rounded-xl">-->
<!--  <table class="min-w-full border text-sm">-->
<!--    <thead class="bg-gray-100 text-gray-700">-->
<!--      <tr>-->
<!--        <th class="py-2 px-4 border-b">#</th>-->
<!--        <th class="py-2 px-4 border-b">Title</th>-->
<!--        <th class="py-2 px-4 border-b">Start</th>-->
<!--        <th class="py-2 px-4 border-b">End</th>-->
<!--        <th class="py-2 px-4 border-b">Status</th>-->
<!--        <th class="py-2 px-4 border-b text-center">Actions</th>-->
<!--      </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--      <php foreach ($projects as $p): ?>-->
<!--        <tr class="hover:bg-gray-50">-->
<!--          <td class="py-2 px-4 border-b"><= esc($p['id']) ?></td>-->
<!--          <td class="py-2 px-4 border-b">-->
<!--            <a href="<= base_url('projects/view/'.$p['id']) ?>" class="text-sky-600 hover:underline"><= esc($p['title']) ?></a>-->
<!--          </td>-->
<!--          <td class="py-2 px-4 border-b"><= esc($p['start_date']) ?></td>-->
<!--          <td class="py-2 px-4 border-b"><= esc($p['end_date']) ?></td>-->
<!--          <td class="py-2 px-4 border-b"><= esc($p['status']) ?></td>-->
<!--          <td class="py-2 px-4 border-b text-center">-->
<!--            <a href="<= base_url('projects/delete/'.$p['id']) ?>" class="text-red-600 hover:underline" onclick="return confirm('Delete project?')">🗑️ Delete</a>-->
<!--          </td>-->
<!--        </tr>-->
<!--      <php endforeach; ?>-->
<!--    </tbody>-->
<!--  </table>-->
<!--</div>-->

<!--<= $this->endSection() ?>-->
