<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-gray-800 mb-6"><?= esc($title) ?></h2>

<form method="post" 
      action="<?= isset($project) ? base_url('projects/update/'.$project['id']) : base_url('projects/store') ?>" 
      class="bg-white border border-gray-200 p-6 rounded-xl shadow-md space-y-5">

  <!-- Project Name -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
    <input name="name" 
           value="<?= esc($project['name'] ?? '') ?>" 
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none" 
           required>
  </div>
  
<div class="mb-3">
    <label class="block mb-1 font-medium">Assigned To (Employees)</label>
    <select name="assigned_to[]" multiple 
            class="w-full border border-gray-300 rounded px-3 py-2" required>
        <?php 
        $selectedEmployees = isset($project['assigned_to']) 
            ? explode(',', $project['assigned_to']) 
            : [];
        ?>
        <?php foreach ($employees as $emp): ?>
            <option value="<?= esc($emp['id']) ?>"
                <?= in_array($emp['id'], $selectedEmployees) ? 'selected' : '' ?>>
                <?= esc($emp['name']) ?> (<?= esc($emp['role'] ?? 'Employee') ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <small class="text-gray-500">Hold Ctrl (Windows) or Cmd (Mac) to select multiple employees.</small>
</div>



  <!-- Description -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
    <textarea name="description" 
              rows="3" 
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none"><?= esc($project['description'] ?? '') ?></textarea>
  </div>

  <!-- Dates -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
      <input type="date" 
             name="start_date" 
             value="<?= esc($project['start_date'] ?? '') ?>" 
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
      <input type="date" 
             name="end_date" 
             value="<?= esc($project['end_date'] ?? '') ?>" 
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>
  </div>

  <!-- Capacity / WIP / Buffer -->
  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Capacity (hrs/day)</label>
      <input type="number" 
             step="0.5" 
             name="capacity" 
             value="<?= esc($project['capacity'] ?? 6) ?>" 
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">WIP Limit</label>
      <input type="number" 
             name="wip_limit" 
             value="<?= esc($project['wip_limit'] ?? 3) ?>" 
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Buffer Days</label>
      <input type="number" 
             name="buffer_days" 
             value="<?= esc($project['buffer_days'] ?? 2) ?>" 
             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
    </div>
  </div>

  <!-- Manager -->
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Manager</label>
    <input name="manager" 
           value="<?= esc($project['manager'] ?? '') ?>" 
           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
  </div>

  <!-- Buttons -->
  <div class="flex justify-end space-x-3 pt-2">
    <a href="<?= base_url('projects') ?>" 
       class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
      Cancel
    </a>

    <button type="submit" 
            class="bg-sky-600 text-white px-5 py-2 rounded-lg hover:bg-sky-700 transition shadow">
      <?= isset($project) ? 'Update Project' : 'Save Project' ?>
    </button>
  </div>
</form>

<?= $this->endSection() ?>
