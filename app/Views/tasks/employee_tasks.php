<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-between mb-6">
<h2 class="text-2xl font-semibold text-gray-800 mb-4"><?= esc($title) ?></h2>
 <a href="<?= base_url('tasks/create') ?>" 
     class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition">
     + New Task
  </a>
</div>
<div class="bg-white p-4 rounded-xl shadow">
  <table class="min-w-full border border-gray-200 text-sm">
    <thead class="bg-gray-100 text-gray-700">
      <tr>
        <th class="px-4 py-2 border">Project</th>
        <th class="px-4 py-2 border">Task Title</th>
        <th class="px-4 py-2 border">Due Date</th>
        <th class="px-4 py-2 border">Status</th>
        <th class="px-4 py-2 border">Comment</th>
        <th class="px-4 py-2 border text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tasks as $task): ?>
        <tr class="hover:bg-gray-50">
          <td class="border px-4 py-2"><?= esc($task['project_name']) ?></td>
          <td class="border px-4 py-2 font-medium"><?= esc($task['title']) ?></td>
          <td class="border px-4 py-2"><?= esc($task['due_date'] ?: '—') ?></td>
          <td class="border px-4 py-2">
            <select form="form-<?= $task['id'] ?>" name="status"
                    class="border border-gray-300 rounded-md text-sm px-2 py-1 focus:ring-sky-500 focus:border-sky-500">
              <option value="backlog"    <?= $task['status']=='backlog'?'selected':'' ?>>Backlog</option>
              <option value="inprogress" <?= $task['status']=='inprogress'?'selected':'' ?>>In Progress</option>
              <option value="review"     <?= $task['status']=='review'?'selected':'' ?>>Review</option>
              <option value="done"       <?= $task['status']=='done'?'selected':'' ?>>Done</option>
            </select>
          </td>
          <td class="border px-4 py-2">
            <textarea form="form-<?= $task['id'] ?>" name="comment" rows="2"
                      class="w-full border border-gray-300 rounded-md p-1 text-sm"
                      placeholder="Add comment..."><?= esc($task['comment'] ?? '') ?></textarea>
          </td>
          <td class="border px-4 py-2 text-center">
            <form id="form-<?= $task['id'] ?>" method="POST" action="<?= base_url('employee/tasks/update/'.$task['id']) ?>" class="inline-block">
              <button type="submit" class="bg-sky-600 text-white px-3 py-1 rounded text-xs hover:bg-sky-700">
                Update
              </button>
            </form>
            <a href="<?= base_url('employee/tasks/view/'.$task['id']) ?>" 
               class="ml-2 bg-gray-800 text-white px-3 py-1 rounded text-xs hover:bg-gray-900">
              View
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
