<!-- < $this->extend('layouts/main') ?>
< $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Dashboard Overview</h2>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <div class="flex justify-between items-center">
      <h3 class="text-gray-700 font-semibold">Employees</h3>
      <span class="text-sky-600 text-2xl">👥</span>
    </div>
    <p class="mt-4 text-3xl font-bold">< esc($totalEmployees) ?></p>
    <p class="text-gray-500 text-sm">Active Employees</p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <div class="flex justify-between items-center">
      <h3 class="text-gray-700 font-semibold">Projects</h3>
      <span class="text-indigo-600 text-2xl">📦</span>
    </div>
    <p class="mt-4 text-3xl font-bold">< esc($totalProjects) ?></p>
    <p class="text-gray-500 text-sm">Ongoing Projects</p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <div class="flex justify-between items-center">
      <h3 class="text-gray-700 font-semibold">Attendance</h3>
      <span class="text-emerald-600 text-2xl">🕒</span>
    </div>
    <p class="mt-4 text-3xl font-bold"><esc($todayCheckedIn) ?></p>
    <p class="text-gray-500 text-sm">Checked-in Today</p>
  </div>
</div>

< $this->endSection() ?> -->
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Dashboard Overview</h2>

<!-- ===================================================== -->
<!-- ADMIN DASHBOARD VIEW -->
<!-- ===================================================== -->
<?php if ($role === 'Admin') : ?>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <h3 class="text-gray-700 font-semibold">Employees</h3>
    <p class="mt-4 text-3xl font-bold"><?= esc($totalEmployees) ?></p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <h3 class="text-gray-700 font-semibold">Projects</h3>
    <p class="mt-4 text-3xl font-bold"><?= esc($totalProjects) ?></p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
    <h3 class="text-gray-700 font-semibold">Today's Check-in</h3>
    <p class="mt-4 text-3xl font-bold"><?= esc($todayCheckedIn) ?></p>
  </div>

</div>

<?php endif; ?>


<!-- ===================================================== -->
<!-- EMPLOYEE DASHBOARD VIEW (developer, tester, etc.) -->
<!-- ===================================================== -->
<?php if ($role !== 'Admin') : ?>

<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h3 class="text-xl font-semibold mb-4">Your Assigned Projects</h3>

    <?php if (!empty($assignedProjects)) : ?>
        <ul class="space-y-4">
            <?php foreach ($assignedProjects as $p) : ?>
                <li class="p-4 border rounded-lg bg-gray-50">
                    <h4 class="font-bold"><?= esc($p['name']) ?></h4>
                    <p class="text-gray-600"><?= esc($p['description']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="text-gray-500">No projects assigned.</p>
    <?php endif; ?>
</div>


<div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold">Today's Attendance</h3>
    <p class="mt-2 text-2xl font-bold text-sky-600">
        <?= $todayStatus ? esc($todayStatus) : 'Not Checked In' ?>
    </p>
</div>

<?php endif; ?>

<?= $this->endSection() ?>

