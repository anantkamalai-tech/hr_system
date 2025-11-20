<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">Register Employee</h2>

<form id="employeeForm" method="post" enctype="multipart/form-data" 
      action="<?= base_url('employees/store') ?>" 
      class="bg-white p-6 rounded-xl shadow-md space-y-8">

  <!-- SECTION 1: Basic Info -->
  <div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-3">Basic Info</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-1">Full Name</label>
        <input name="name" id="name" class="w-full border border-gray-300 rounded-md p-2" placeholder="e.g. Priya Sharma">
      </div>
      <div>
        <label class="block mb-1">Email</label>
        <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-md p-2" placeholder="name@company.com">
      </div>
      <!--<div>-->
      <!--  <label class="block mb-1">Password</label>-->
      <!--  <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2">-->
      <!--</div>-->
      <div>
  <label class="block mb-1">Password</label>
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
        <input name="mobile" id="mobile" class="w-full border border-gray-300 rounded-md p-2" placeholder="9xxxxxxxxx">
      </div>
      <div>
        <label class="block mb-1">Gender</label>
        <select name="gender" id="gender" class="w-full border border-gray-300 rounded-md p-2">
          <option value="">Select</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
      </div>
      <div>
        <label class="block mb-1">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div>
        <label class="block mb-1">Address</label>
        <textarea name="address" id="address" rows="2" class="w-full border border-gray-300 rounded-md p-2" placeholder="House, Street, City, Pincode"></textarea>
      </div>
      <div>
        <label class="block mb-1">Role</label>
        <select name="role" id="role" class="w-full border border-gray-300 rounded-md p-2">
          <option value="">Select Role</option>
          <option>Admin</option>
          <option>Software Developer</option>
           <option>Software Tester</option>
            <option>Software Tester</option>
            <option>Flutter Developer</option>
           <option>Python Developer</option>
           <option>AI Engineer</option>
          <option>QA Engineer</option>
          <option>UI/UX Designer</option>
          <option>Project Manager</option>
          <option>HR</option>
          <option>Freelancer</option>
        </select>
      </div>
      <div>
        <label class="block mb-1">Department</label>
        <input name="dept" id="dept" class="w-full border border-gray-300 rounded-md p-2" placeholder="e.g. Engineering">
      </div>
      <div>
        <label class="block mb-1">Designation</label>
        <input name="designation" id="designation" class="w-full border border-gray-300 rounded-md p-2" placeholder="e.g. Sr. Developer">
      </div>
      <div>
        <label class="block mb-1">Employee Code</label>
        <input name="emp_code" id="emp_code" class="w-full border border-gray-300 rounded-md p-2" placeholder="EMP001">
      </div>
      <div>
        <label class="block mb-1">Date of Joining</label>
        <input type="date" name="join_date" id="join_date" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div>
        <label class="block mb-1">Experience (Years)</label>
        <input name="experience" id="experience" class="w-full border border-gray-300 rounded-md p-2" placeholder="3.5">
      </div>
    </div>
  </div>

  <!-- SECTION 2: Contact & IDs -->
  <div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-3">Contact & IDs</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-1">Emergency Contact Name</label>
        <input name="emerg_name" id="emerg_name" class="w-full border border-gray-300 rounded-md p-2" placeholder="Guardian Name">
      </div>
      <div>
        <label class="block mb-1">Emergency Contact Phone</label>
        <input name="emerg_phone" id="emerg_phone" class="w-full border border-gray-300 rounded-md p-2" placeholder="9xxxxxxxxx">
      </div>
      <div>
        <label class="block mb-1">PAN</label>
        <input name="pan" id="pan" class="w-full border border-gray-300 rounded-md p-2" placeholder="ABCDE1234F">
      </div>
      <div>
        <label class="block mb-1">Aadhaar</label>
        <input name="aadhar" id="aadhar" class="w-full border border-gray-300 rounded-md p-2" placeholder="xxxx-xxxx-xxxx">
      </div>
      <div>
        <label class="block mb-1">UAN (EPF)</label>
        <input name="uan" id="uan" class="w-full border border-gray-300 rounded-md p-2" placeholder="UAN Number">
      </div>
      <div>
        <label class="block mb-1">Tech Stack (comma separated)</label>
        <input name="tech_stack" id="tech_stack" class="w-full border border-gray-300 rounded-md p-2" placeholder="Laravel, MySQL, Vue">
      </div>
      <div>
        <label class="block mb-1">CTC / Month (₹)</label>
        <input name="salary" id="salary" class="w-full border border-gray-300 rounded-md p-2" placeholder="45000">
      </div>
      <div>
        <label class="block mb-1">Highest Education</label>
        <input name="education" id="education" class="w-full border border-gray-300 rounded-md p-2" placeholder="B.Tech (CS)">
      </div>
    </div>
  </div>

  <!-- SECTION 3: Bank & Documents -->
  <div class="border rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-3">Bank Details & Documents</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-1">Bank Name</label>
        <input name="bank_name" id="bank_name" class="w-full border border-gray-300 rounded-md p-2" placeholder="HDFC Bank">
      </div>
      <div>
        <label class="block mb-1">IFSC</label>
        <input name="ifsc" id="ifsc" class="w-full border border-gray-300 rounded-md p-2" placeholder="HDFC0001234">
      </div>
      <div>
        <label class="block mb-1">Account Number</label>
        <input name="account_no" id="account_no" class="w-full border border-gray-300 rounded-md p-2" placeholder="xxxxxxxxxxxx">
      </div>
      <div>
        <label class="block mb-1">Aadhaar (PDF)</label>
        <input type="file" name="doc_aadhar" id="doc_aadhar" accept="application/pdf" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div>
        <label class="block mb-1">PAN (PDF)</label>
        <input type="file" name="doc_pan" id="doc_pan" accept="application/pdf" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div>
        <label class="block mb-1">Resume / CV (PDF)</label>
        <input type="file" name="doc_resume" id="doc_resume" accept="application/pdf" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div>
        <label class="block mb-1">Offer / Appointment Letter (PDF)</label>
        <input type="file" name="doc_offer" id="doc_offer" accept="application/pdf" class="w-full border border-gray-300 rounded-md p-2">
      </div>
      <div>
        <label class="block mb-1">Photo</label>
        <input type="file" name="photo" id="photo" accept="image/*" class="w-full border border-gray-300 rounded-md p-2">
      </div>
    </div>
  </div>

  <!-- Save Button -->
  <div class="flex justify-end pt-4">

    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md">Save Employee</button>
    <a href="<?= base_url('employees') ?>" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100">← Back to List</a>

  </div>

</form>

<!-- jQuery + Validation -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- (Optional) Additional methods for pattern, etc. -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
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

<script>
// $(document).ready(function() {
//     $("#employeeForm").validate({
//         rules: {
//             name: { required: true, minlength: 3 },
//             email: { required: true, email: true },
//             password: { required: true, minlength: 6 },
//             mobile: { required: true, digits: true, minlength: 10, maxlength: 10 },
//             gender: "required",
//             dob: "required",
//             role: "required",
//             dept: "required",
//             designation: "required",
//             emp_code: "required",
//             join_date: "required",
//             experience: { required: true, number: true },
//             bank_name: "required",
//             ifsc: "required",
//             account_no: "required",
//             doc_aadhar: "required",
//             doc_pan: "required",
//             doc_resume: "required",
//             doc_offer: "required",
//             photo: "required"
//         },
//         messages: {
//             name: { required: "Please enter full name", minlength: "At least 3 characters" },
//             email: { required: "Please enter email", email: "Enter valid email" },
//             password: { required: "Enter password", minlength: "At least 6 characters" },
//             mobile: { required: "Enter mobile", digits: "Digits only", minlength: "10 digits", maxlength: "10 digits" },
//             gender: "Select gender",
//             dob: "Select DOB",
//             role: "Select role",
//             dept: "Enter department",
//             designation: "Enter designation",
//             emp_code: "Enter employee code",
//             join_date: "Select joining date",
//             experience: { required: "Enter experience", number: "Enter number only" },
//             bank_name: "Enter bank name",
//             ifsc: "Enter IFSC",
//             account_no: "Enter account number",
//             doc_aadhar: "Upload Aadhaar",
//             doc_pan: "Upload PAN",
//             doc_resume: "Upload resume",
//             doc_offer: "Upload offer letter",
//             photo: "Upload photo"
//         },
//         errorElement: "span",
//         errorClass: "text-red-600 text-sm",
//         highlight: function(element) { $(element).addClass('border-red-500'); },
//         unhighlight: function(element) { $(element).removeClass('border-red-500'); }
//     });
// });
</script>


<?= $this->endSection() ?>
