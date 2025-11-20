<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Employee Profile</h2>

<div class="bg-white shadow rounded-xl p-6 space-y-8">

  <!-- Top Section -->
  <div class="flex flex-col md:flex-row items-center md:items-start gap-6 border-b pb-6">
    <div class="flex-shrink-0">
      <?php if ($employee['photo']): ?>
        <img src="<?= base_url('uploads/employees/photos/'.$employee['photo']) ?>" 
             class="w-32 h-32 rounded-full object-cover shadow">
      <?php else: ?>
        <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-4xl font-bold">
          <?= strtoupper(substr($employee['name'], 0, 1)) ?>
        </div>
      <?php endif; ?>
    </div>
    <div>
      <h3 class="text-2xl font-semibold"><?= esc($employee['name']) ?></h3>
      <p class="text-gray-500"><?= esc($employee['designation']) ?>, <?= esc($employee['dept']) ?></p>
      <p class="text-gray-600 mt-1"><strong>Emp Code:</strong> <?= esc($employee['emp_code']) ?></p>
      <p class="text-gray-600"><strong>Role:</strong> <?= esc($employee['role']) ?></p>
    </div>
  </div>

  <!-- Personal Info -->
  <div>
    <h4 class="text-xl font-semibold text-sky-700 mb-3">🧍 Personal Details</h4>
    <div class="grid md:grid-cols-2 gap-4 text-gray-700">
      <p><strong>Email:</strong> <?= esc($employee['email']) ?></p>
      <p><strong>Mobile:</strong> <?= esc($employee['mobile']) ?></p>
      <p><strong>Gender:</strong> <?= esc($employee['gender']) ?></p>
      <p><strong>Date of Birth:</strong> <?= esc($employee['dob']) ?></p>
      <p><strong>Address:</strong> <?= esc($employee['address']) ?></p>
    </div>
  </div>

  <!-- Job Info -->
  <div>
    <h4 class="text-xl font-semibold text-sky-700 mb-3">💼 Job Information</h4>
    <div class="grid md:grid-cols-2 gap-4 text-gray-700">
      <p><strong>Department:</strong> <?= esc($employee['dept']) ?></p>
      <p><strong>Designation:</strong> <?= esc($employee['designation']) ?></p>
      <p><strong>Joining Date:</strong> <?= esc($employee['join_date']) ?></p>
      <p><strong>Experience:</strong> <?= esc($employee['experience']) ?> years</p>
      <p><strong>Salary:</strong> ₹<?= number_format($employee['salary'], 2) ?></p>
    </div>
  </div>

  <!-- Emergency Contact -->
  <div>
    <h4 class="text-xl font-semibold text-sky-700 mb-3">📞 Emergency Contact</h4>
    <div class="grid md:grid-cols-2 gap-4 text-gray-700">
      <p><strong>Name:</strong> <?= esc($employee['emerg_name']) ?></p>
      <p><strong>Phone:</strong> <?= esc($employee['emerg_phone']) ?></p>
    </div>
  </div>

  <!-- ID Details -->
  <div>
    <h4 class="text-xl font-semibold text-sky-700 mb-3">🆔 Identification Details</h4>
    <div class="grid md:grid-cols-3 gap-4 text-gray-700">
      <p><strong>PAN:</strong> <?= esc($employee['pan']) ?></p>
      <p><strong>Aadhaar:</strong> <?= esc($employee['aadhar']) ?></p>
      <p><strong>UAN:</strong> <?= esc($employee['uan']) ?></p>
    </div>
  </div>

  <!-- Tech & Education -->
  <div>
    <h4 class="text-xl font-semibold text-sky-700 mb-3">📚 Skills & Education</h4>
    <div class="grid md:grid-cols-2 gap-4 text-gray-700">
      <p><strong>Tech Stack:</strong> <?= esc($employee['tech_stack']) ?></p>
      <p><strong>Education:</strong> <?= esc($employee['education']) ?></p>
    </div>
  </div>

  <!-- Documents -->
  <div>
    <h4 class="text-xl font-semibold text-sky-700 mb-3">📄 Documents</h4>
    <div class="grid md:grid-cols-2 gap-4 text-gray-700">
      <p>
        <strong>Aadhaar:</strong>
        <?php if ($employee['doc_aadhar']): ?>
          <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_aadhar']) ?>" target="_blank" class="text-sky-600 hover:underline">View File</a>
        <?php else: ?>
          <span class="text-gray-400">Not Uploaded</span>
        <?php endif; ?>
      </p>
      <p>
        <strong>PAN:</strong>
        <?php if ($employee['doc_pan']): ?>
          <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_pan']) ?>" target="_blank" class="text-sky-600 hover:underline">View File</a>
        <?php else: ?>
          <span class="text-gray-400">Not Uploaded</span>
        <?php endif; ?>
      </p>
      <p>
        <strong>Resume:</strong>
        <?php if ($employee['doc_resume']): ?>
          <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_resume']) ?>" target="_blank" class="text-sky-600 hover:underline">View File</a>
        <?php else: ?>
          <span class="text-gray-400">Not Uploaded</span>
        <?php endif; ?>
      </p>
      <p>
        <strong>Offer Letter:</strong>
        <?php if ($employee['doc_offer']): ?>
          <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_offer']) ?>" target="_blank" class="text-sky-600 hover:underline">View File</a>
        <?php else: ?>
          <span class="text-gray-400">Not Uploaded</span>
        <?php endif; ?>
      </p>
    </div>
  </div>

  <!-- Footer Buttons -->
  <div class="flex justify-end gap-3 pt-6 border-t">
    <!-- <a href="< base_url('employees/edit/'.$employee['id']) ?>" class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700">✏️ Edit</a> -->
    <a href="<?= base_url('employees') ?>" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100">← Back to List</a>
  </div>
</div>

<?= $this->endSection() ?>
