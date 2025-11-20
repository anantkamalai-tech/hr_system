<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!--<h2 class="text-2xl font-semibold mb-6 text-blue-700">👷 My Assigned Projects</h2>-->
<h2 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-2">My Assigned Projects</h2>
<?php if (empty($myProjects)): ?>
    <p class="text-gray-500">You are not assigned to any projects yet.</p>
<?php else: ?>
    <div class="space-y-6">
        <?php foreach ($myProjects as $item): ?>
            <?php $p = $item['project']; $manager = $item['manager']; $tasks = $item['tasks']; ?>

            <div class="bg-white border border-gray-200 rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-bold text-gray-800"><?= esc($p['name']) ?></h3>
                    <a href="<?= base_url('projects/detail/' . $p['id']) ?>" class="text-blue-600 hover:underline text-sm">View Full Project →</a>
                </div>

                <p class="text-gray-600 text-sm mb-3">
                    <strong>Start Date:</strong> <?= esc($p['start_date'] ?: 'N/A') ?> | 
                    <strong>End Date:</strong> <?= esc($p['end_date'] ?: 'N/A') ?><br>
                    <strong>Manager:</strong> <?= $manager ? esc($manager['name']) . ' (' . esc($manager['role']) . ')' : 'N/A'; ?>
                </p>

                <?php if (!empty($tasks)): ?>
                    <div class="border-t pt-3 mt-3">
                        <h4 class="font-semibold text-gray-700 mb-2">📝 Your Tasks in this Project:</h4>
                        <ul class="list-disc pl-5 space-y-1 text-gray-700">
                            <?php foreach ($tasks as $task): ?>
                                <li>
                                    <span class="font-medium"><?= esc($task['title']) ?></span>
                                    <?php if (!empty($task['status'])): ?>
                                        <span class="text-sm text-gray-500">[<?= ucfirst($task['status']) ?>]</span>
                                    <?php endif; ?>
                                    <?php if (!empty($task['due_date'])): ?>
                                        <span class="text-sm text-red-500">(Due: <?= esc($task['due_date']) ?>)</span>
                                    <?php endif; ?>
                                     <span class="text-sm text-green-500"> *Please refer to the My Tasks module for full task details.</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500 mt-2">No tasks assigned to you in this project.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
