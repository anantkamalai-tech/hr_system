<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-semibold mb-6">Daily Attendance</h2>

<div class="mx-auto bg-white shadow-md rounded-lg p-6">

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="flex flex-wrap items-center gap-4 mb-6">
        <p class="font-semibold text-lg"><?= esc($employee_name) ?></p>
        <p class="text-gray-500 text-sm"><?= date('d M, Y') ?></p>

        <?php 
        // Safe check for report_submitted
        $reportSubmitted = isset($attendance['report_submitted']) ? $attendance['report_submitted'] : 0;
        $checkOutTime = isset($attendance['check_out']) ? $attendance['check_out'] : null;
        ?>

        <!-- Check-In Button -->
        <form action="<?= base_url('attendance/checkIn') ?>" method="post">
            <button type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition"
                <?= $attendance ? 'disabled class=opacity-50 cursor-not-allowed' : '' ?>>
                Check In
            </button>
        </form>

        <!-- Submit Report Button triggers modal -->
        <button 
            class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition"
            <?= (!$attendance || $reportSubmitted == 1) ? 'disabled class=opacity-50 cursor-not-allowed' : '' ?>
            onclick="document.getElementById('reportFormModal').classList.remove('hidden')">
            Submit Report
        </button>

        <!-- Check-Out Button -->
        <form action="<?= base_url('attendance/checkOut') ?>" method="post">
            <button type="submit"
                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
                <?= (!$attendance || $reportSubmitted == 0 || $checkOutTime) ? 'disabled class=opacity-50 cursor-not-allowed' : '' ?>>
                Check Out
            </button>
        </form>
    </div>

    <p class="text-sm text-red-500 mb-6 text-base italic">
         "Check Out" will only activate after you submit your daily report.
    </p>

    <!-- Modal / Report Form -->
    <div id="reportFormModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg relative">
            <h3 class="text-xl font-semibold mb-4 text-sky-700"> Submit Daily Report</h3>
            <form action="<?= base_url('attendance/saveReport') ?>" method="post">
                <!-- Name -->
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" name="name" value="<?= esc($employee_name) ?>" readonly
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Date</label>
                    <input type="text" name="date" value="<?= date('Y-m-d') ?>" readonly
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <!-- Project Name (Static Dropdown) -->
                <!--<div class="mb-3">-->
                <!--    <label class="block mb-1 font-medium">Project Name</label>-->
                <!--    <select name="project" class="w-full border border-gray-300 rounded px-3 py-2" required>-->
                <!--        <option value="">Select Project</option>-->
                <!--        <option value="Project A">Project A</option>-->
                <!--        <option value="Project B">Project B</option>-->
                <!--        <option value="Project C">Project C</option>-->
                <!--        <option value="Project D">Project D</option>-->
                <!--    </select>-->
                <!--</div>-->
                
                <div class="mb-3">
                <label class="block mb-1 font-medium">Project Name</label>
                <select name="project_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">Select Project</option>
                            <?php foreach ($projects as $project): ?>
                                <option value="<?= esc($project['id']) ?>">
                                    <?= esc($project['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                <!-- Work Description -->
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Work Description</label>
                    <textarea name="work_description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center mt-4">
                    <button type="button" onclick="document.getElementById('reportFormModal').classList.add('hidden')"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save Report</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Work Description Modal -->
<!-- Work Description Modal -->
<div id="workDescriptionModal" 
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
  <div id="workModalBox"
       class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-lg transform scale-95 opacity-0 transition-all duration-200 ease-out">
    
    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-3 mb-4">
      <h3 class="text-xl font-semibold text-blue-700 flex items-center gap-2">
         Work Description
      </h3>
      <button onclick="closeWorkModal()" 
              class="text-gray-400 hover:text-gray-600 transition text-xl">
        ✕
      </button>
    </div>

    <!-- Content -->
    <div class="space-y-3">
      <div>
        <p id="workProject" class="text-sm text-gray-600"></p>
        <p id="workDate" class="text-sm text-gray-600"></p>
      </div>

      <div id="workDescriptionContent" 
           class="bg-gray-50 border rounded-lg p-4 text-gray-800 text-sm leading-relaxed whitespace-pre-line">
      </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-right">
      <button 
        onclick="closeWorkModal()"
        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
        Close
      </button>
    </div>
  </div>
</div>


    <!-- Attendance Table (All Records) -->
    <?php if ($attendances && count($attendances) > 0): ?>
<div class="overflow-x-auto mt-6">
    <table class="w-full border text-sm">
        <thead class="bg-gray-100 border-b">
            <tr class="text-gray-700">
                <th class="p-2 text-left">Employee</th>
                <th class="p-2 text-left">Date</th>
                <th class="p-2 text-left">Check In</th>
                <th class="p-2 text-left">Check Out</th>
                <th class="p-2 text-left">Report</th>
                <th class="p-2 text-left">Total Hours</th>
                <th class="p-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($attendances as $att): 
                $reportSubmittedRow = isset($att['report_submitted']) ? $att['report_submitted'] : 0;
                $checkOutRow = isset($att['check_out']) ? $att['check_out'] : null;
                $workDescription = esc($att['work_description'] ?? 'No work description available.');
            ?>
            <tr class="border-t hover:bg-gray-50">
                <td class="p-2"><?= esc($employee_name) ?></td>
                <td class="p-2"><?= esc($att['date']) ?></td>
                <td class="p-2"><?= esc($att['check_in'] ?? '-') ?></td>
                <td class="p-2"><?= esc($checkOutRow ?? '-') ?></td>
                <td class="p-2">
                    <?php if ($reportSubmittedRow): ?>
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Submitted ✅/ </span>
                    <?php else: ?>
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Pending ⏳</span>
                    <?php endif; ?>
                </td>
                <td class="p-2"><?= esc($att['total_hours'] ?? '-') ?></td>
                <td class="p-2">
                    <?php if (!empty($att['work_description'])): ?>
                        <button 
                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-xs"
                            onclick="showWorkDescription(`<?= nl2br(addslashes($workDescription)) ?>`, '<?= addslashes($att['project_name'] ?? '-') ?>', '<?= esc($att['date']) ?>')">
                             Work Details
                        </button>

                    <?php else: ?>
                        <span class="text-gray-400 text-xs italic">No report</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    <?php else: ?>
        <p class="text-gray-600 mt-4">No attendance records found.</p>
    <?php endif; ?>
</div>

<script>
function showWorkDescription(description, projectName = '', date = '') {
  const modal = document.getElementById('workDescriptionModal');
  const box = document.getElementById('workModalBox');

  document.getElementById('workDescriptionContent').innerHTML = description;
  document.getElementById('workProject').textContent = projectName ? ' Project: ' + projectName : '';
  document.getElementById('workDate').textContent = date ? ' Date: ' + date : '';

  // Show modal and animate
  modal.classList.remove('hidden');
  setTimeout(() => {
    box.classList.remove('scale-95', 'opacity-0');
    box.classList.add('scale-100', 'opacity-100');
  }, 10);
}

function closeWorkModal() {
  const modal = document.getElementById('workDescriptionModal');
  const box = document.getElementById('workModalBox');

  // Animate close
  box.classList.remove('scale-100', 'opacity-100');
  box.classList.add('scale-95', 'opacity-0');

  setTimeout(() => {
    modal.classList.add('hidden');
  }, 150);
}
</script>

<?= $this->endSection() ?>
