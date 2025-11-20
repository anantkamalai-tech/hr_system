<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">💳 Generate Payslip (Basic Salary Only)</h2>

<form method="post" action="<?= base_url('payslips/store') ?>" id="payslipForm" class="space-y-8">

  <!-- Employee Selection -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">👤 Employee & Period</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div>
        <label>Employee</label>
        <select id="employee_id" name="employee_id" class="w-full border-gray-300 rounded-md" required>
          <option value="">Select Employee</option>
          <?php foreach ($employees as $emp): ?>
            <option value="<?= $emp['id'] ?>"><?= esc($emp['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>Month</label>
        <select id="month" name="month" class="w-full border-gray-300 rounded-md">
          <?php
          foreach (range(1,12) as $m) {
            $selected = $m == date('n') ? 'selected' : '';
            echo "<option value='$m' $selected>".date('F', mktime(0,0,0,$m,1))."</option>";
          }
          ?>
        </select>
      </div>
      <div>
        <label>Year</label>
        <input id="year" type="number" name="year" value="<?= date('Y') ?>" class="w-full border-gray-300 rounded-md">
      </div>
    </div>

    <div id="employee-info" class="grid md:grid-cols-3 gap-4 mt-4 bg-gray-50 p-4 rounded-lg hidden">
      <div><label>Emp Code:</label><input id="emp_code" readonly class="w-full border-gray-300 bg-gray-100"></div>
      <div><label>Name:</label><input id="emp_name" readonly class="w-full border-gray-300 bg-gray-100"></div>
      <div><label>Date of Joining:</label><input id="date_of_joining" readonly class="w-full border-gray-300 bg-gray-100"></div>
      <div><label>Pay Mode:</label><input id="pay_mode" readonly class="w-full border-gray-300 bg-gray-100"></div>
      <div><label>Department:</label><input id="dept" readonly class="w-full border-gray-300 bg-gray-100"></div>
      <div><label>Designation:</label><input id="designation" readonly class="w-full border-gray-300 bg-gray-100"></div>
      <div><label>Location:</label><input id="location" readonly class="w-full border-gray-300 bg-gray-100"></div>
      <div><label>Account No:</label><input id="account_no" readonly class="w-full border-gray-300 bg-gray-100"></div>
    </div>
  </div>

  <!-- Attendance -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">🗓 Attendance Summary</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label>Working Days</label><input id="working_days" name="working_days" readonly class="bg-gray-100 w-full"></div>
      <div><label>Present Days</label><input id="present_days" name="present_days" readonly class="bg-gray-100 w-full"></div>
      <div><label>Approved Leave</label><input id="approved_leave_days" name="approved_leave_days" readonly class="bg-gray-100 w-full"></div>
      <div><label>LOP (Auto)</label><input id="lop_days" name="lop_days" readonly class="bg-gray-100 w-full"></div>
    </div>
  </div>

  <!-- Basic Salary -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">💰 Salary Details</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label>Basic Salary (₹)</label><input id="basic" name="basic" value="0" class="w-full border-gray-300 rounded-md"></div>
    </div>
  </div>

  <!-- Summary -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">📊 Summary</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label>Gross (₹)</label><input id="gross" name="gross" readonly class="bg-gray-100 w-full"></div>
      <div><label>Loss of Pay (₹)</label><input id="lop_amount" name="lop_amount" readonly class="bg-gray-100 w-full"></div>
      <div><label>Net Pay (₹)</label><input id="net_pay" name="net_pay" readonly class="bg-green-100 w-full font-semibold"></div>
    </div>
  </div>

  <div class="flex justify-end gap-3">
    <button type="button" id="calcBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">🔢 Calculate</button>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">💾 Save Payslip</button>
  </div>
</form>

<script>
function v(id){ return parseFloat(document.getElementById(id).value)||0; }
function setVal(id,v){ document.getElementById(id).value=v; }

document.getElementById('employee_id').addEventListener('change', fetchEmployeeData);
document.getElementById('month').addEventListener('change', fetchEmployeeData);
document.getElementById('year').addEventListener('input', fetchEmployeeData);

function fetchEmployeeData() {
  const empId = document.getElementById('employee_id').value;
  if (!empId) return;

  const month = document.getElementById('month').value;
  const year = document.getElementById('year').value;

  fetch(`<?= base_url('payslips/getEmployeeDetails/') ?>${empId}?month=${month}&year=${year}`)
    .then(res => res.json())
    .then(data => {
      if (data.employee) {
        document.getElementById('employee-info').classList.remove('hidden');
        setVal('emp_code', data.employee.emp_code || '');
        setVal('emp_name', data.employee.name || '');
        setVal('date_of_joining', data.employee.date_of_joining || '');
        setVal('pay_mode', data.employee.pay_mode || '');
        setVal('dept', data.employee.dept || '');
        setVal('designation', data.employee.designation || '');
        setVal('location', data.employee.location || '');
        setVal('account_no', data.employee.account_no || '');
      }
      if (data.attendance) {
        setVal('working_days', data.attendance.working_days);
        setVal('present_days', data.attendance.present_days);
        setVal('approved_leave_days', data.attendance.approved_leave_days);
        setVal('lop_days', data.attendance.absent_days);
      }
    });
}

document.getElementById('calcBtn').addEventListener('click', ()=>{
  const basic = v('basic');
  const gross = basic;
  const working = v('working_days');
  const present = v('present_days');
  const leave = v('approved_leave_days');
  const lopDays = Math.max(0, working - (present + leave));
  const perDay = working>0 ? gross/working : 0;
  const lopAmt = perDay*lopDays;
  const net = gross - lopAmt;
  setVal('gross', gross.toFixed(2));
  setVal('lop_amount', lopAmt.toFixed(2));
  setVal('net_pay', net.toFixed(2));
});
</script>

<?= $this->endSection() ?>
