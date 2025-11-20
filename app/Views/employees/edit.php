<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Edit Employee</h2>

<form method="post" enctype="multipart/form-data"
      action="<?= base_url('employees/update/' . $employee['id']) ?>"
      class="bg-white p-6 rounded-xl shadow-md space-y-8">

  <!-- SECTION 1: Basic Info -->
  <div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-3">Basic Info</h3>
    <div class="grid md:grid-cols-3 gap-4">

      <div>
        <label class="block mb-1">Full Name</label>
        <input name="name" value="<?= esc($employee['name']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="e.g. Priya Sharma">
      </div>

      <div>
        <label class="block mb-1">Email</label>
        <input type="email" name="email" value="<?= esc($employee['email']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="name@company.com">
      </div>

      <div>
  <label class="block mb-1">Password(Leave blank if you don't want to change)</label>
  <div class="relative">
    <input type="password" name="password" id="password" 
           class="w-full border rounded px-3 py-2 pr-10"
           placeholder="Enter password">

    <!-- Eye Icon -->
    <button type="button" id="togglePassword" 
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
      <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" 
           viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
           class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" 
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-.407 1.296-1.1 2.487-2.015 3.465M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </button>
  </div>
</div>

      <div>
        <label class="block mb-1">Mobile</label>
        <input name="mobile" value="<?= esc($employee['mobile']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="9xxxxxxxxx">
      </div>

      <div>
        <label class="block mb-1">Gender</label>
        <select name="gender" class="w-full border border-gray-300 rounded-md p-2">
          <option value="">Select</option>
          <option <?= $employee['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
          <option <?= $employee['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
          <option <?= $employee['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
      </div>

      <div>
        <label class="block mb-1">Date of Birth</label>
        <input type="date" name="dob" value="<?= esc($employee['dob']) ?>"
               class="w-full border border-gray-300 rounded-md p-2">
      </div>

      <div>
        <label class="block mb-1">Address</label>
        <textarea name="address" rows="2"
                  class="w-full border border-gray-300 rounded-md p-2"
                  placeholder="House, Street, City, Pincode"><?= esc($employee['address']) ?></textarea>
      </div>

      <div>
        <label class="block mb-1">Role</label>
        <select name="role" class="w-full border border-gray-300 rounded-md p-2">
          <option value="">Select Role</option>
          <option <?= $employee['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
          <option <?= $employee['role'] == 'Software Developer' ? 'selected' : '' ?>>Software Developer</option>
            <option <?= $employee['role'] == 'Software Tester' ? 'selected' : '' ?>>Software Tester</option>
            <option <?= $employee['role'] == 'Flutter Developer' ? 'selected' : '' ?>>Flutter Developer</option>
              <option <?= $employee['role'] == 'Python Developer' ? 'selected' : '' ?>>Python Developer</option>
                  <option <?= $employee['role'] == 'AI Engineer' ? 'selected' : '' ?>>AI Engineer</option>
          <option <?= $employee['role'] == 'QA Engineer' ? 'selected' : '' ?>>QA Engineer</option>
          <option <?= $employee['role'] == 'UI/UX Designer' ? 'selected' : '' ?>>UI/UX Designer</option>
          <option <?= $employee['role'] == 'Project Manager' ? 'selected' : '' ?>>Project Manager</option>
          <option <?= $employee['role'] == 'HR' ? 'selected' : '' ?>>HR</option>
          <option <?= $employee['role'] == 'Freelancer' ? 'selected' : '' ?>>Freelancer</option>

        </select>
      </div>

      <div>
        <label class="block mb-1">Department</label>
        <input name="dept" value="<?= esc($employee['dept']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="e.g. Engineering">
      </div>

      <div>
        <label class="block mb-1">Designation</label>
        <input name="designation" value="<?= esc($employee['designation']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="e.g. Sr. Developer">
      </div>

      <div>
        <label class="block mb-1">Employee Code</label>
        <input name="emp_code" value="<?= esc($employee['emp_code']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="EMP001">
      </div>

      <div>
        <label class="block mb-1">Date of Joining</label>
        <input type="date" name="join_date" value="<?= esc($employee['join_date']) ?>"
               class="w-full border border-gray-300 rounded-md p-2">
      </div>

      <div>
        <label class="block mb-1">Experience (Years)</label>
        <input name="experience" value="<?= esc($employee['experience']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="3.5">
      </div>
    </div>
  </div>

  <!-- SECTION 2: Contact & IDs -->
  <div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-3">Contact & IDs</h3>
    <div class="grid md:grid-cols-3 gap-4">

      <div>
        <label class="block mb-1">Emergency Contact Name</label>
        <input name="emerg_name" value="<?= esc($employee['emerg_name']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="Guardian Name">
      </div>

      <div>
        <label class="block mb-1">Emergency Contact Phone</label>
        <input name="emerg_phone" value="<?= esc($employee['emerg_phone']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="9xxxxxxxxx">
      </div>

      <div>
        <label class="block mb-1">PAN</label>
        <input name="pan" value="<?= esc($employee['pan']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="ABCDE1234F">
      </div>

      <div>
        <label class="block mb-1">Aadhaar</label>
        <input name="aadhar" value="<?= esc($employee['aadhar']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="xxxx-xxxx-xxxx">
      </div>

      <div>
        <label class="block mb-1">UAN (EPF)</label>
        <input name="uan" value="<?= esc($employee['uan']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="UAN Number">
      </div>

      <div>
        <label class="block mb-1">Tech Stack (comma separated)</label>
        <input name="tech_stack" value="<?= esc($employee['tech_stack']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="Laravel, MySQL, Vue">
      </div>

      <div>
        <label class="block mb-1">CTC / Month (₹)</label>
        <input name="salary" value="<?= esc($employee['salary']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="45000">
      </div>

      <div>
        <label class="block mb-1">Highest Education</label>
        <input name="education" value="<?= esc($employee['education']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="B.Tech (CS)">
      </div>
    </div>
  </div>

  <!-- SECTION 3: Bank Details & Documents -->
  <div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-3">Bank Details & Documents Upload</h3>
    <div class="grid md:grid-cols-3 gap-4">

      <div>
        <label class="block mb-1">Bank Name</label>
        <input name="bank_name" value="<?= esc($employee['bank_name']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="HDFC Bank">
      </div>

      <div>
        <label class="block mb-1">IFSC</label>
        <input name="ifsc" value="<?= esc($employee['ifsc']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="HDFC0001234">
      </div>

      <div>
        <label class="block mb-1">Account Number</label>
        <input name="account_no" value="<?= esc($employee['account_no']) ?>"
               class="w-full border border-gray-300 rounded-md p-2" placeholder="xxxxxxxxxxxx">
      </div>

      <!-- Document Uploads -->
      <div>
        <label class="block mb-1">Aadhaar (PDF/JPG/PNG)</label>
        <input type="file" name="doc_aadhar" accept=".pdf,image/*"
               class="w-full border border-gray-300 rounded-md p-2">
        <?php if (!empty($employee['doc_aadhar'])): ?>
          <p class="text-sm mt-1 text-blue-600">
            <a href="<?= base_url('uploads/employees/docs/' . $employee['doc_aadhar']) ?>" target="_blank">View existing</a>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block mb-1">PAN (PDF/JPG/PNG)</label>
        <input type="file" name="doc_pan" accept=".pdf,image/*"
               class="w-full border border-gray-300 rounded-md p-2">
        <?php if (!empty($employee['doc_pan'])): ?>
          <p class="text-sm mt-1 text-blue-600">
            <a href="<?= base_url('uploads/employees/docs/' . $employee['doc_pan']) ?>" target="_blank">View existing</a>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block mb-1">Resume / CV (PDF)</label>
        <input type="file" name="doc_resume" accept="application/pdf"
               class="w-full border border-gray-300 rounded-md p-2">
        <?php if (!empty($employee['doc_resume'])): ?>
          <p class="text-sm mt-1 text-blue-600">
            <a href="<?= base_url('uploads/employees/docs/' . $employee['doc_resume']) ?>" target="_blank">View existing</a>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block mb-1">Offer / Appointment Letter (PDF)</label>
        <input type="file" name="doc_offer" accept="application/pdf"
               class="w-full border border-gray-300 rounded-md p-2">
        <?php if (!empty($employee['doc_offer'])): ?>
          <p class="text-sm mt-1 text-blue-600">
            <a href="<?= base_url('uploads/employees/docs/' . $employee['doc_offer']) ?>" target="_blank">View existing</a>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block mb-1">Photo</label>
        <input type="file" name="photo" accept="image/*"
               class="w-full border border-gray-300 rounded-md p-2">
        <?php if (!empty($employee['photo'])): ?>
          <img src="<?= base_url('uploads/employees/photos/' . $employee['photo']) ?>"
               class="w-20 h-20 rounded-full mt-2 object-cover border">
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Save Button -->
  <div class="flex justify-end pt-4">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
      Update Employee
    </button>
        <a href="<?= base_url('employees') ?>" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100">← Back to List</a>

  </div>

</form>
<script>
$(document).ready(function() {
  // Password show/hide toggle
  $('#togglePassword').on('click', function() {
    const passwordField = $('#password');
    const icon = $('#eyeIcon');

    // Toggle field type
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);

    // Toggle icon (eye / eye-slash)
    if (type === 'text') {
      icon.html(`<path stroke-linecap="round" stroke-linejoin="round"
        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7
        .407-1.296 1.1-2.487 2.015-3.465m2.3-2.3A9.97 9.97 0 0112 5
        c4.478 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.043 5.255M15
        12a3 3 0 11-6 0 3 3 0 016 0z" />`);
    } else {
      icon.html(`<path stroke-linecap="round" stroke-linejoin="round"
        d="M2.458 12C3.732 7.943 7.523 5 12 5
        c4.478 0 8.268 2.943 9.542 7-.407 1.296-1.1
        2.487-2.015 3.465M15 12a3 3 0 11-6 0
        3 3 0 016 0z" />`);
    }
  });
});
</script>
<?= $this->endSection() ?>
