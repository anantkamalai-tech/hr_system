<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2 class="text-3xl font-semibold mb-6">💳 Generate Salary Slip</h2>

<?php if (session()->getFlashdata('success')): ?>
  <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<form method="post" action="<?= base_url('payslips/store') ?>" id="payslipForm" class="space-y-8">

  <!-- Employee & Period -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">👤 Employee & Period</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div>
        <label class="block text-gray-600 mb-1">Employee</label>
        <select name="employee_id" class="w-full border-gray-300 rounded-md" required>
          <option value="">Select Employee</option>
          <?php foreach ($employees as $emp): ?>
            <option value="<?= esc($emp['id']) ?>"><?= esc($emp['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-gray-600 mb-1">Month</label>
        <select name="month" class="w-full border-gray-300 rounded-md">
          <?php foreach (['January','February','March','April','May','June','July','August','September','October','November','December'] as $m): ?>
            <option><?= $m ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label class="block text-gray-600 mb-1">Year</label>
        <input type="number" name="year" value="<?= date('Y') ?>" class="w-full border-gray-300 rounded-md">
      </div>
    </div>
  </div>

  <!-- Attendance -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">🕒 Attendance</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label class="block mb-1">Working Days</label><input type="number" id="working_days" name="working_days" value="26" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Present Days</label><input type="number" id="present_days" name="present_days" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Paid Leave</label><input type="number" id="paid_leave" name="paid_leave" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Half Days</label><input type="number" step="0.5" id="half_days" name="half_days" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Overtime (hours)</label><input type="number" step="0.5" id="overtime_hours" name="overtime_hours" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">LOP (auto)</label><input type="text" id="lop_days" name="lop_days" readonly class="w-full border-gray-300 rounded-md bg-gray-100"></div>
    </div>
  </div>

  <!-- Earnings -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">💰 Earnings</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label class="block mb-1">Basic (₹)</label><input type="number" id="basic" name="basic" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">HRA (₹)</label><input type="number" id="hra" name="hra" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Conveyance (₹)</label><input type="number" id="convey" name="convey" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Special Allowance (₹)</label><input type="number" id="special" name="special" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Other Earnings (₹)</label><input type="number" id="other_earn" name="other_earn" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Variable / Bonus (₹)</label><input type="number" id="variable_pay" name="variable_pay" value="0" class="w-full border-gray-300 rounded-md"></div>
    </div>
  </div>

  <!-- Deductions -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">🧾 Deductions</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label class="block mb-1">PF (₹)</label><input type="number" id="pf" name="pf" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">ESI (₹)</label><input type="number" id="esi" name="esi" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Professional Tax (₹)</label><input type="number" id="pt" name="pt" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">TDS (₹)</label><input type="number" id="tds" name="tds" value="0" class="w-full border-gray-300 rounded-md"></div>
      <div><label class="block mb-1">Other Deductions (₹)</label><input type="number" id="other_ded" name="other_ded" value="0" class="w-full border-gray-300 rounded-md"></div>
    </div>
  </div>

  <!-- Summary (auto) -->
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4 border-b pb-2">📊 Summary</h3>
    <div class="grid md:grid-cols-3 gap-4">
      <div><label class="block mb-1">Gross</label><input type="text" id="gross" name="gross" readonly class="w-full border-gray-300 rounded-md bg-gray-100"></div>
      <div><label class="block mb-1">Total Deductions</label><input type="text" id="deductions" name="deductions" readonly class="w-full border-gray-300 rounded-md bg-gray-100"></div>
      <div><label class="block mb-1">Net Pay</label><input type="text" id="net_pay" name="net_pay" readonly class="w-full border-gray-300 rounded-md bg-green-100 font-semibold"></div>
    </div>
  </div>

  <div class="flex justify-end gap-3">
    <button type="button" id="calcBtn" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700">🔢 Calculate</button>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">💾 Save Payslip</button>
    <a href="<?= base_url('payslips') ?>" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-100">Cancel</a>
  </div>
</form>

<script>
function v(id){ return parseFloat(document.getElementById(id).value)||0; }
function setNum(id, num){ document.getElementById(id).value = (num||0).toFixed(2); }

function calc() {
  const working = v('working_days');
  const present = v('present_days');
  const leave   = v('paid_leave');
  const half    = v('half_days');

  const gross = v('basic')+v('hra')+v('convey')+v('special')+v('other_earn')+v('variable_pay');
  const perDay = working>0 ? (gross/working) : 0;
  const payableDays = present + leave + (half*0.5);
  const lopDays = Math.max(0, working - payableDays);
  const lopAmt  = lopDays * perDay;

  const deductions = v('pf')+v('esi')+v('pt')+v('tds')+v('other_ded') + lopAmt;
  const net = gross - deductions;

  setNum('lop_days', lopDays);
  setNum('gross', gross);
  setNum('deductions', deductions);
  setNum('net_pay', net);
}

document.getElementById('calcBtn').addEventListener('click', calc);
document.addEventListener('input', (e)=>{ if(['INPUT','SELECT'].includes(e.target.tagName)) calc(); });
calc();
</script>

<?= $this->endSection() ?>
