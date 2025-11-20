<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Employees</h2>

<?php if (session()->getFlashdata('success')): ?>
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<a href="<?= base_url('employees/create') ?>" class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700 mb-4 inline-block">➕ Add Employee</a>

<div class="overflow-x-auto bg-white shadow rounded-xl">
  <table class="min-w-full border border-gray-200 text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="py-2 px-4 border-b">#</th>
        <th class="py-2 px-4 border-b">Photo</th>
        <th class="py-2 px-4 border-b">Name</th>
        <th class="py-2 px-4 border-b">Email</th>
        <th class="py-2 px-4 border-b">Department</th>
        <th class="py-2 px-4 border-b">Designation</th>
        <th class="py-2 px-4 border-b">Salary</th>
        <th class="py-2 px-4 border-b text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($employees as $e): ?>
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b"><?= esc($e['id']) ?></td>
          <td class="py-2 px-4 border-b">
            <?php if ($e['photo']): ?>
              <img src="<?= base_url('uploads/employees/photos/'.$e['photo']) ?>" class="w-10 h-10 rounded-full object-cover">
            <?php else: ?>
              <span class="text-gray-400 italic">No Photo</span>
            <?php endif; ?>
          </td>
          <td class="py-2 px-4 border-b">
            <a href="<?= base_url('employees/profile/'.$e['id']) ?>" class="text-sky-600 hover:underline font-medium">
              <?= esc($e['name']) ?>
            </a>
          </td>
          <td class="py-2 px-4 border-b"><?= esc($e['email']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($e['dept']) ?></td>
          <td class="py-2 px-4 border-b"><?= esc($e['designation']) ?></td>
          <td class="py-2 px-4 border-b">₹<?= number_format($e['salary'], 2) ?></td>
          <td class="py-2 px-4 border-b text-center">
            <a href="<?= base_url('employees/edit/'.$e['id']) ?>" class="text-blue-600 hover:underline mr-2">✏️</a>
            <a href="<?= base_url('employees/delete/'.$e['id']) ?>" onclick="return confirm('Delete this employee?')" class="text-red-600 hover:underline">🗑️</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
