<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-semibold mb-6"><?= esc($title) ?></h2>

<form method="post" action="<?= isset($project) ? base_url('projects/update/'.$project['id']) : base_url('projects/store') ?>" class="bg-white p-6 rounded-xl shadow space-y-4">
  <div>
    <label class="block text-sm font-medium text-gray-700">Project Name</label>
    <input name="name" value="<?= esc($project['name'] ?? '') ?>" class="mt-1 w-full border-gray-300 rounded-md" required>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" class="mt-1 w-full border-gray-300 rounded-md" rows="3"><?= esc($project['description'] ?? '') ?></textarea>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Start Date</label>
      <input type="date" name="start_date" value="<?= esc($project['start_date'] ?? '') ?>" class="mt-1 w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">End Date</label>
      <input type="date" name="end_date" value="<?= esc($project['end_date'] ?? '') ?>" class="mt-1 w-full border-gray-300 rounded-md">
    </div>
  </div>

  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700">Capacity (hrs/day)</label>
      <input type="number" step="0.5" name="capacity" value="<?= esc($project['capacity'] ?? 6) ?>" class="mt-1 w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">WIP Limit</label>
      <input type="number" name="wip_limit" value="<?= esc($project['wip_limit'] ?? 3) ?>" class="mt-1 w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700">Buffer Days</label>
      <input type="number" name="buffer_days" value="<?= esc($project['buffer_days'] ?? 2) ?>" class="mt-1 w-full border-gray-300 rounded-md">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700">Manager</label>
    <input name="manager" value="<?= esc($project['manager'] ?? '') ?>" class="mt-1 w-full border-gray-300 rounded-md">
  </div>

  <button class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700"><?= isset($project) ? 'Update' : 'Save' ?></button>
</form>

<?= $this->endSection() ?>
