<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 1.6; }
    .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; }
    .logo { max-height: 80px; }
    .section { margin-top: 15px; }
    .footer { text-align: right; margin-top: 40px; }
  </style>
</head>
<body>
  <div class="header">
    <?php if (!empty($data['logo_path'])): ?>
      <img src="<?= base_url($data['logo_path']) ?>" class="logo">
    <?php endif; ?>
    <h2><?= esc($data['company_name']) ?></h2>
    <p><?= esc($data['company_address']) ?></p>
  </div>

  <p>Dear <?= esc($data['emp_name']) ?>,</p>
  <p>We are pleased to offer you the position of <b><?= esc($data['designation']) ?></b> in our <?= esc($data['department']) ?> department effective from <?= esc($data['join_date']) ?>.</p>

  <p>Work Location: <?= esc($data['location']) ?>  
     | Work Mode: <?= esc($data['work_mode']) ?>  
     | CTC: <?= esc($data['ctc']) ?></p>

  <div class="footer">
    <?php if (!empty($data['sign_path'])): ?>
      <img src="<?= base_url($data['sign_path']) ?>" style="max-height:60px;"><br>
    <?php endif; ?>
    <b>Authorized Signatory</b><br>
    <?= esc($data['company_name']) ?>
  </div>
</body>
</html>
