<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Edit Employee</h2>

<form method="post" enctype="multipart/form-data" 
      action="<?= base_url('employees/update/'.$employee['id']) ?>" 
      class="bg-white p-6 rounded-xl shadow-md space-y-6">

  <!-- Row 1 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Employee Code</label>
      <input name="emp_code" value="<?= esc($employee['emp_code']) ?>" class="w-full border-gray-300 rounded-md" required>
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Full Name</label>
      <input name="name" value="<?= esc($employee['name']) ?>" class="w-full border-gray-300 rounded-md" required>
    </div>
  </div>

  <!-- Row 2 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Email</label>
      <input type="email" name="email" value="<?= esc($employee['email']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Mobile</label>
      <input name="mobile" value="<?= esc($employee['mobile']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 3 -->
  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Gender</label>
      <select name="gender" class="w-full border-gray-300 rounded-md">
        <option value="">Select</option>
        <option <?= $employee['gender']=='Male'?'selected':'' ?>>Male</option>
        <option <?= $employee['gender']=='Female'?'selected':'' ?>>Female</option>
        <option <?= $employee['gender']=='Other'?'selected':'' ?>>Other</option>
      </select>
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Date of Birth</label>
      <input type="date" name="dob" value="<?= esc($employee['dob']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Experience (Years)</label>
      <input type="number" step="0.1" name="experience" value="<?= esc($employee['experience']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 4 -->
  <div>
    <label class="block text-gray-700 mb-1">Address</label>
    <textarea name="address" rows="2" class="w-full border-gray-300 rounded-md"><?= esc($employee['address']) ?></textarea>
  </div>

  <!-- Row 5 -->
  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Role</label>
      <select name="role" class="w-full border-gray-300 rounded-md">
        <option value="">Select Role</option>
        <option <?= $employee['role']=='Software Developer'?'selected':'' ?>>Software Developer</option>
        <option <?= $employee['role']=='QA Engineer'?'selected':'' ?>>QA Engineer</option>
        <option <?= $employee['role']=='UI/UX Designer'?'selected':'' ?>>UI/UX Designer</option>
        <option <?= $employee['role']=='Project Manager'?'selected':'' ?>>Project Manager</option>
        <option <?= $employee['role']=='HR'?'selected':'' ?>>HR</option>
      </select>
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Department</label>
      <input name="dept" value="<?= esc($employee['dept']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Designation</label>
      <input name="designation" value="<?= esc($employee['designation']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 6 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Joining Date</label>
      <input type="date" name="join_date" value="<?= esc($employee['join_date']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Salary (₹)</label>
      <input type="number" step="0.01" name="salary" value="<?= esc($employee['salary']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 7 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Emergency Contact Name</label>
      <input name="emerg_name" value="<?= esc($employee['emerg_name']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Emergency Contact Phone</label>
      <input name="emerg_phone" value="<?= esc($employee['emerg_phone']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 8 -->
  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">PAN</label>
      <input name="pan" value="<?= esc($employee['pan']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Aadhaar</label>
      <input name="aadhar" value="<?= esc($employee['aadhar']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">UAN (EPF)</label>
      <input name="uan" value="<?= esc($employee['uan']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 9 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Tech Stack</label>
      <input name="tech_stack" value="<?= esc($employee['tech_stack']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Highest Education</label>
      <input name="education" value="<?= esc($employee['education']) ?>" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 10 - Photo -->
  <div>
    <label class="block text-gray-700 mb-1">Photo</label>
    <?php if ($employee['photo']): ?>
      <div class="flex items-center gap-3 mb-2">
        <img src="<?= base_url('uploads/employees/photos/'.$employee['photo']) ?>" class="w-16 h-16 rounded-full object-cover">
        <span class="text-gray-500 text-sm"><?= esc($employee['photo']) ?></span>
      </div>
    <?php endif; ?>
    <input type="file" name="photo" accept="image/*" class="w-full border-gray-300 rounded-md">
  </div>

  <!-- Row 11 - Documents -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Aadhaar Document</label>
      <?php if ($employee['doc_aadhar']): ?>
        <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_aadhar']) ?>" target="_blank" class="text-sky-600 text-sm block mb-1">📄 View Existing</a>
      <?php endif; ?>
      <input type="file" name="doc_aadhar" class="w-full border-gray-300 rounded-md">
    </div>

    <div>
      <label class="block text-gray-700 mb-1">PAN Document</label>
      <?php if ($employee['doc_pan']): ?>
        <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_pan']) ?>" target="_blank" class="text-sky-600 text-sm block mb-1">📄 View Existing</a>
      <?php endif; ?>
      <input type="file" name="doc_pan" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Resume (PDF)</label>
      <?php if ($employee['doc_resume']): ?>
        <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_resume']) ?>" target="_blank" class="text-sky-600 text-sm block mb-1">📄 View Existing</a>
      <?php endif; ?>
      <input type="file" name="doc_resume" class="w-full border-gray-300 rounded-md">
    </div>

    <div>
      <label class="block text-gray-700 mb-1">Offer Letter (PDF)</label>
      <?php if ($employee['doc_offer']): ?>
        <a href="<?= base_url('uploads/employees/docs/'.$employee['doc_offer']) ?>" target="_blank" class="text-sky-600 text-sm block mb-1">📄 View Existing</a>
      <?php endif; ?>
      <input type="file" name="doc_offer" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Buttons -->
  <div class="flex justify-end space-x-3 pt-4">
    <a href="<?= base_url('employees') ?>" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100">Cancel</a>
    <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700">Update Employee</button>
  </div>
</form>

<?= $this->endSection() ?>
