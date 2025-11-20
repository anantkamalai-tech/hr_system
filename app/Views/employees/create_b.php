<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Add Employee</h2>

<form method="post" enctype="multipart/form-data" 
      action="<?= base_url('employees/store') ?>" 
      class="bg-white p-6 rounded-xl shadow-md space-y-6">

  <!-- Row 1 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Employee Code</label>
      <input name="emp_code" class="w-full border-gray-300 rounded-md" placeholder="EMP001" required>
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Full Name</label>
      <input name="name" class="w-full border-gray-300 rounded-md" placeholder="John Doe" required>
    </div>
  </div>

  <!-- Row 2 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Email</label>
      <input type="email" name="email" class="w-full border-gray-300 rounded-md" placeholder="name@company.com">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Mobile</label>
      <input name="mobile" class="w-full border-gray-300 rounded-md" placeholder="9876543210">
    </div>
  </div>

  <!-- Row 3 -->
  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Gender</label>
      <select name="gender" class="w-full border-gray-300 rounded-md">
        <option value="">Select</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Date of Birth</label>
      <input type="date" name="dob" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Experience (Years)</label>
      <input type="number" step="0.1" name="experience" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Row 4 -->
  <div>
    <label class="block text-gray-700 mb-1">Address</label>
    <textarea name="address" rows="2" class="w-full border-gray-300 rounded-md" placeholder="House no, Street, City, Pincode"></textarea>
  </div>

  <!-- Row 5 -->
  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Role</label>
      <select name="role" class="w-full border-gray-300 rounded-md">
        <option value="">Select Role</option>
        <option>Software Developer</option>
        <option>QA Engineer</option>
        <option>UI/UX Designer</option>
        <option>Project Manager</option>
        <option>HR</option>
      </select>
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Department</label>
      <input name="dept" class="w-full border-gray-300 rounded-md" placeholder="Engineering, Design, HR">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Designation</label>
      <input name="designation" class="w-full border-gray-300 rounded-md" placeholder="Sr. Developer">
    </div>
  </div>

  <!-- Row 6 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Joining Date</label>
      <input type="date" name="join_date" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Salary (₹)</label>
      <input type="number" step="0.01" name="salary" class="w-full border-gray-300 rounded-md" placeholder="45000">
    </div>
  </div>

  <!-- Row 7 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Emergency Contact Name</label>
      <input name="emerg_name" class="w-full border-gray-300 rounded-md" placeholder="Guardian Name">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Emergency Contact Phone</label>
      <input name="emerg_phone" class="w-full border-gray-300 rounded-md" placeholder="9876543210">
    </div>
  </div>

  <!-- Row 8 -->
  <div class="grid md:grid-cols-3 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">PAN</label>
      <input name="pan" class="w-full border-gray-300 rounded-md" placeholder="ABCDE1234F">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Aadhaar</label>
      <input name="aadhar" class="w-full border-gray-300 rounded-md" placeholder="XXXX-XXXX-XXXX">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">UAN (EPF)</label>
      <input name="uan" class="w-full border-gray-300 rounded-md" placeholder="UAN Number">
    </div>
  </div>

  <!-- Row 9 -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Tech Stack (comma separated)</label>
      <input name="tech_stack" class="w-full border-gray-300 rounded-md" placeholder="Laravel, Vue, MySQL">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Highest Education</label>
      <input name="education" class="w-full border-gray-300 rounded-md" placeholder="B.Tech (CS)">
    </div>
  </div>

  <!-- Row 10 -->
  <div>
    <label class="block text-gray-700 mb-1">Photo</label>
    <input type="file" name="photo" accept="image/*" class="w-full border-gray-300 rounded-md">
  </div>

  <!-- Row 11 - Documents -->
  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Aadhaar Document (PDF/JPG/PNG)</label>
      <input type="file" name="doc_aadhar" accept=".pdf,image/*" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">PAN Document (PDF/JPG/PNG)</label>
      <input type="file" name="doc_pan" accept=".pdf,image/*" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-gray-700 mb-1">Resume (PDF)</label>
      <input type="file" name="doc_resume" accept="application/pdf" class="w-full border-gray-300 rounded-md">
    </div>
    <div>
      <label class="block text-gray-700 mb-1">Offer / Appointment Letter (PDF)</label>
      <input type="file" name="doc_offer" accept="application/pdf" class="w-full border-gray-300 rounded-md">
    </div>
  </div>

  <!-- Buttons -->
  <div class="flex justify-end space-x-3 pt-4">
    <a href="<?= base_url('employees') ?>" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100">Cancel</a>
    <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700">Save Employee</button>
  </div>

</form>

<?= $this->endSection() ?>
