<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Page Wrapper -->
 <h2 class="text-2xl font-semibold mb-6">Joining Letter</h2>
<div class="flex h-screen bg-gray-50 text-gray-800">

  <!-- Left Column: Form -->
  <div class="w-1/3 p-6 bg-white border-r border-gray-200 overflow-y-auto shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Employee & Offer Details</h2>

    <form id="joiningForm" enctype="multipart/form-data" class="space-y-3">
      <!-- Company -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
        <input name="company_name" value="Anantkamal Software Lab" class="w-full p-2 border rounded focus:ring focus:ring-blue-100" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Company CIN / Reg No</label>
        <input name="cin" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Company Address</label>
        <textarea name="company_address" rows="2" class="w-full p-2 border rounded focus:ring focus:ring-blue-100"></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Company Email</label>
        <input name="company_contact" type="email" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <hr class="border-gray-300 my-3">

      <!-- Employee Info -->
      <h3 class="text-gray-800 font-semibold text-base">Employee Info</h3>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Employee Name</label>
        <input name="emp_name" class="w-full p-2 border rounded focus:ring focus:ring-blue-100" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
        <input name="designation" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
        <input name="department" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Joining Date</label>
          <input type="date" name="join_date" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
          <input name="location" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Work Mode</label>
          <select name="work_mode" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
            <option>Onsite</option>
            <option>Remote</option>
            <option>Hybrid</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Annual CTC</label>
          <input name="ctc" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Probation Period</label>
        <input name="probation" placeholder="e.g. 6 months" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Notice Period</label>
        <input name="notice_period" placeholder="e.g. 60 days" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Reporting Manager</label>
        <input name="manager" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Working Hours</label>
        <input name="work_hours" placeholder="e.g. Mon–Fri, 9:30 AM – 6:30 PM" class="w-full p-2 border rounded focus:ring focus:ring-blue-100">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Custom Notes</label>
        <textarea name="notes" rows="2" placeholder="Add any extra info..." class="w-full p-2 border rounded focus:ring focus:ring-blue-100"></textarea>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Company Logo</label>
          <input type="file" name="logo" class="w-full text-gray-700">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Authorized Signature</label>
          <input type="file" name="signature" class="w-full text-gray-700">
        </div>
      </div>

      <div class="flex gap-3 pt-3">
        <button type="submit" class="bg-emerald-600 px-4 py-2 rounded text-white hover:bg-emerald-700">
          Preview Letter
        </button>
        <button type="button" id="downloadBtn" class="hidden bg-blue-600 px-4 py-2 rounded text-white hover:bg-blue-700">
          Download PDF
        </button>
      </div>
    </form>
  </div>

  <!-- Right Column: Live Preview -->
  <div class="flex-1 bg-gray-50 text-gray-900 p-6 overflow-y-auto">
    <h2 class="text-lg font-semibold mb-4">Live Preview</h2>
    <iframe id="pdfPreview" class="w-full h-[85vh] border border-gray-300 rounded shadow"></iframe>
  </div>
</div>

<!-- JS -->
<script>
document.getElementById('joiningForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);

  const res = await fetch('<?= base_url('joiningletter/save') ?>', {
    method: 'POST',
    body: formData
  });
  const result = await res.json();

  if (result.status === 'success') {
    document.getElementById('pdfPreview').src = result.preview_url;
    const dlBtn = document.getElementById('downloadBtn');
    dlBtn.classList.remove('hidden');
    dlBtn.onclick = () => window.open(result.download_url, '_blank');
  } else {
    alert('Error: ' + result.message);
  }
});
</script>

<?= $this->endSection() ?>
