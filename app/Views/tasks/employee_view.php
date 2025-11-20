<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto bg-white shadow rounded-xl p-6">
  <!-- Header -->
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-2xl font-semibold text-gray-800"><?= esc($task['title']) ?></h2>
    <a href="<?= base_url('employee/tasks') ?>" 
       class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">
      ← Back
    </a>
  </div>

  <!-- Info Grid -->
  <div class="grid md:grid-cols-2 gap-4 text-sm">
    <div>
      <div class="text-gray-500">Project</div>
      <div class="font-medium"><?= esc($task['project_name'] ?? '—') ?></div>
    </div>
    <div>
      <div class="text-gray-500">Status</div>
      <div class="font-medium capitalize"><?= esc($task['status']) ?></div>
    </div>
    <div>
      <div class="text-gray-500">Due Date</div>
      <div class="font-medium"><?= esc($task['due_date'] ?: '—') ?></div>
    </div>
    <div>
      <div class="text-gray-500">Estimate (hrs)</div>
      <div class="font-medium"><?= esc($task['estimate'] ?: '—') ?></div>
    </div>
  </div>

  <!-- Description -->
  <div class="mt-5">
    <div class="text-gray-500">Description</div>
    <p class="text-gray-800 whitespace-pre-line border rounded-md p-3 bg-gray-50 mt-1">
      <?= esc($task['description'] ?: '—') ?>
    </p>
  </div>

  <!-- Dependencies -->
  <div class="mt-4">
    <div class="text-gray-500">Dependencies</div>
    <p class="text-gray-800 border rounded-md p-3 bg-gray-50 mt-1">
      <?= esc($task['dependencies'] ?: '—') ?>
    </p>
  </div>

  <!-- Update Form -->
  <div class="mt-8 border-t pt-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-2">Update Task</h3>
    <form method="POST" action="<?= base_url('employee/tasks/update/' . $task['id']) ?>" class="space-y-3">
      <div>
        <label class="block text-gray-600 mb-1">Status</label>
        <select name="status" class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring-sky-500 focus:border-sky-500">
          <option value="backlog"    <?= $task['status']=='backlog'?'selected':'' ?>>Backlog</option>
          <option value="inprogress" <?= $task['status']=='inprogress'?'selected':'' ?>>In Progress</option>
          <option value="review"     <?= $task['status']=='review'?'selected':'' ?>>Review</option>
          <option value="done"       <?= $task['status']=='done'?'selected':'' ?>>Done</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-600 mb-1">Comment</label>
        <textarea name="comment" rows="3" 
                  class="border border-gray-300 rounded-md px-3 py-2 w-full focus:ring-sky-500 focus:border-sky-500"
                  placeholder="Add your comment here..."><?= esc($task['comment'] ?? '') ?></textarea>
      </div>

      <button type="submit" 
              class="bg-sky-600 text-white px-5 py-2 rounded-md text-sm hover:bg-sky-700">
        Save Changes
      </button>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
