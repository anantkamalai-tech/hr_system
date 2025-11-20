<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6"><?= $project ? 'Edit Project' : 'Add Project' ?></h2>

<form method="post" 
      action="<?= $project ? base_url('projects/update/'.$project['id']) : base_url('projects/store') ?>" 
      class="bg-white p-6 rounded-xl shadow-md space-y-4 max-w-2xl">

  <div>
    <label class="block mb-1 text-gray-700">Project Title</label>
    <input type="text" name="title" class="w-full border-gray-300 rounded-md" 
           value="<?= esc($project['title'] ?? '') ?>" required>
  </div>

  <div>
    <label class="block mb-1 text-gray-700">Description</label>
    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md"><?= esc($project['description'] ?? '') ?></textarea>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block mb-1 text-gray-700">Start Date</label>
      <input type="date" name="start_date" class="w-full border-gray-300 rounded-md" 
             value="<?= esc($project['start_date'] ?? '') ?>">
    </div>
    <div>
      <label class="block mb-1 text-gray-700">End Date</label>
      <input type="date" name="end_date" class="w-full border-gray-300 rounded-md"
             value="<?= esc($project['end_date'] ?? '') ?>">
    </div>
  </div>

  <div>
    <label class="block mb-1 text-gray-700">Assign To</label>
    <select name="assigned_to" class="w-full border-gray-300 rounded-md">
      <option value="">Select Employee</option>
      <?php foreach ($employees as $emp): ?>
        <option value="<?= esc($emp['name']) ?>" <?= isset($project['assigned_to']) && $project['assigned_to']==$emp['name']?'selected':'' ?>>
          <?= esc($emp['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div>
    <label class="block mb-1 text-gray-700">Status</label>
    <select name="status" class="w-full border-gray-300 rounded-md">
      <?php
        $statuses = ['Planned','In Progress','Completed','On Hold'];
        foreach ($statuses as $s):
      ?>
        <option <?= isset($project['status']) && $project['status']==$s?'selected':'' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <button class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700"><?= $project ? 'Update Project' : 'Save Project' ?></button>
</form>

<?= $this->endSection() ?>
