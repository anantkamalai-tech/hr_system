<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payslip - <?= esc($payslip['name']) ?></title>
<style>
body { font-family: DejaVu Sans, sans-serif; color:#333; font-size:12px; }
.container { max-width:700px; margin:0 auto; padding:20px; border:1px solid #ddd; }
h2 { text-align:center; color:#003366; }
table { width:100%; border-collapse:collapse; margin-top:15px; }
td,th { border:1px solid #ccc; padding:6px; }
th { background:#f2f2f2; }
.footer { margin-top:30px; font-size:11px; text-align:center; color:#666; }
.right { text-align:right; }
</style>
</head>
<body>
<div class="container">
  <h2>Pay Slip for <?= date('F', mktime(0,0,0,$payslip['month'],1)) ?> <?= $payslip['year'] ?></h2>

  <table>
    <tr><td><b>Emp Code:</b> <?= esc($payslip['emp_code']) ?></td><td><b>Name:</b> <?= esc($payslip['name']) ?></td></tr>
    <tr><td><b>Date of Joining:</b> <?= esc($payslip['join_date']) ?></td><td><b>Department:</b> <?= esc($payslip['dept']) ?></td></tr>
    <tr><td><b>Designation:</b> <?= esc($payslip['designation']) ?></td><td><b>Location:</b> <?= esc($payslip['address']) ?></td></tr>
    <tr><td><b>Account No:</b> <?= esc($payslip['account_no']) ?></td><td><b>Pay Mode:</b> Bank Transfer</td></tr>
  </table>

  <h3 style="margin-top:20px;">Earnings & Deductions</h3>
  <table>
    <tr><th>Particulars</th><th class="right">Amount (₹)</th></tr>
    <tr><td>Basic Salary</td><td class="right"><?= number_format($payslip['basic'],2) ?></td></tr>
    <tr><td>Gross Salary</td><td class="right"><?= number_format($payslip['gross'],2) ?></td></tr>
    <tr><td>Loss of Pay (<?= $payslip['lop_days'] ?> Days)</td><td class="right">-<?= number_format($payslip['lop_days'],2) ?></td></tr>
    <tr><th>Net Pay</th><th class="right"><?= number_format($payslip['net_pay'],2) ?></th></tr>
  </table>

  <div class="footer">
    This is a system-generated payslip. No signature required.  
    <br>Generated on <?= date('d M, Y') ?>
  </div>
</div>
</body>
</html>
