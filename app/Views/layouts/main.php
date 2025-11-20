<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'Admin Panel') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind -->
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
   <link rel="stylesheet" href="<?= base_url('public/assets/css/output.css') ?>">
  <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables + Buttons -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

  <style>
    body { font-family: 'Inter', sans-serif; background: #f9fafb; color: #1e293b; }
    .active { background-color: #e0f2fe; color: #0369a1; font-weight: 600; }
    .sidebar-collapsed .sidebar-text { display: none; }
    .sidebar-collapsed .sidebar-icon { margin: auto; }
    .sidebar-collapsed nav a { justify-content: center; }
  </style>
<!--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>-->
</head>

<body class="bg-gray-200 min-h-screen">

  <!-- ✅ Top Bar -->
  <header class="bg-gray-500 w-full shadow-sm fixed top-0 left-0 z-50 flex items-center justify-between px-6 py-3 border-b">
    <div class="flex items-center space-x-3">
      <!-- Hamburger for Mobile -->
      <button id="menuOpen" class="text-2xl lg:hidden text-gray-700 focus:outline-none">☰</button>
      <!--<h1 class="text-2xl font-bold text-orange-700">Anantkamal</h1>-->
    </div>

    <?php $empId = session()->get('employee_id'); // or session()->get('id') ?>

 
    <?php if (session()->get('isLoggedIn')): ?>
         <a href="<?= base_url('employees/profile/' . $empId) ?>">
      <div class="flex items-center space-x-3">
        <?php 
          $photo = session()->get('photo');
          $photoUrl = $photo ? base_url('uploads/employees/photos/' . $photo) : 'https://ui-avatars.com/api/?name=' . urlencode(session()->get('name'));
        ?>
        <img src="<?= esc($photoUrl) ?>" alt="Profile" class="w-9 h-9 rounded-full border object-cover">
        <div class="hidden sm:block">
          <p class="text-sm font-semibold text-white"><?= esc(session()->get('name')) ?></p>
          <p class="text-xs text-white capitalize"><?= esc(session()->get('role')) ?></p>
        </div>
      </div>
    </a>
    <?php endif; ?>
  </header>

  <!-- ✅ Overlay for mobile -->
  <div id="overlay" class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>

  <!-- ✅ Sidebar -->
  <aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-[#252733] text-white shadow-md border-r transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">

    <!-- Sidebar Header -->
    <div class="px-6 py-4 border-b flex items-center justify-between">
      <h1 class="text-3xl font-bold text-white-700 sidebar-text">Anantkamal</h1>
      <div class="flex items-center space-x-2">
        <button id="collapseBtn" class="hidden lg:block text-gray-500 text-xl" title="Collapse Sidebar">⏩</button>
        <button id="menuClose" class="lg:hidden text-gray-500 text-2xl">&times;</button>
      </div>
    </div>

    <!-- ✅ Sidebar Menu -->
    <nav class="flex-1 p-4 overflow-y-auto space-y-1">

      <!-- Common Menu -->
      <a href="<?= base_url('/') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black <?= uri_string() == '' ? 'active' : '' ?>">
        <span class="sidebar-icon">🏠</span><span class="ml-2 sidebar-text">Dashboard</span>
      </a>

      <!-- ✅ Admin Menu -->
      <?php if (session()->get('role') === 'Admin'): ?>
        <a href="<?= base_url('employees') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">👥</span><span class="ml-2 sidebar-text">Employees</span>
        </a>

        <a href="<?= base_url('sop') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">📝</span><span class="ml-2 sidebar-text">SOP</span>
        </a>

        <a href="<?= base_url('joiningletter') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">📜</span><span class="ml-2 sidebar-text">Joining Letter</span>
        </a>

        <a href="<?= base_url('projects') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">📦</span><span class="ml-2 sidebar-text">Projects & Tasks</span>
        </a>
        
        <a href="<?= base_url('tasks') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">📦</span><span class="ml-2 sidebar-text">Assign Tasks</span>
        </a>

        <!--<a href="<?= base_url('attendance') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50">-->
        <!--  <span class="sidebar-icon">🕒</span><span class="ml-2 sidebar-text">Employee Attendance List</span>-->
        <!--</a>-->
                <a href="<?= base_url('admin/attendance') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">🕒</span><span class="ml-2 sidebar-text"> Attendance List</span>
        </a>

        <!--<a href="<?= base_url('dailyreports') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">-->
        <!--  <span class="sidebar-icon">📄</span><span class="ml-2 sidebar-text">Daily Reports</span>-->
        <!--</a>-->

        <!--<a href="<?= base_url('leaves') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50">-->
        <!--  <span class="sidebar-icon">🌴</span><span class="ml-2 sidebar-text">Leave Applications List</span>-->
        <!--</a>-->
        
        <a href="<?= base_url('admin/leave-list') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">🗓️</span><span class="ml-2 sidebar-text">Leave List</span>
        </a>
        
       

        <!-- <a href="<?= base_url('payslips') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">💳</span><span class="ml-2 sidebar-text">Payslips</span>
        </a> -->

        <!--<a href="<?= base_url('reports') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50">-->
        <!--  <span class="sidebar-icon">📈</span><span class="ml-2 sidebar-text">Reports</span>-->
        <!--</a>-->

        <!--<a href="<?= base_url('settings') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50">-->
        <!--  <span class="sidebar-icon">⚙️</span><span class="ml-2 sidebar-text">Settings</span>-->
        <!--</a>-->
      <?php endif; ?>

      <!-- ✅ Employee Menu -->
      <?php if (session()->get('role') !== 'Admin'): ?>
        <a href="<?= base_url('projects/my-projects') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">📦</span><span class="ml-2 sidebar-text">My Projects</span>
        </a>

        <a href="<?= base_url('attendance') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">🕒</span><span class="ml-2 sidebar-text">My Attendance</span>
        </a>

        <!--<a href="<?= base_url('dailyreports') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">-->
        <!--  <span class="sidebar-icon">📝</span><span class="ml-2 sidebar-text">Daily Reports</span>-->
        <!--</a>-->

        <a href="<?= base_url('leave') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">🗓️</span><span class="ml-2 sidebar-text">Leave Application</span>
        </a>
        
        <a href="<?= base_url('employee/tasks') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">📦</span><span class="ml-2 sidebar-text">My Tasks</span>
        </a>

        <!-- <a href="<?= base_url('payslips') ?>" class="flex items-center px-4 py-2 rounded hover:bg-sky-50 hover:text-black">
          <span class="sidebar-icon">💳</span><span class="ml-2 sidebar-text">My Payslips</span>
        </a> -->
      <?php endif; ?>
    </nav>

    <!-- ✅ Logout -->
    <div class="p-4 border-t">
      <a href="<?= base_url('/logout') ?>" class="block text-white-600 text-sm font-medium">🚪 Logout</a>
    </div>
  </aside>

  <!-- ✅ Main Content -->
  <main id="mainContent" class="lg:ml-64 pt-20 p-6 transition-all duration-300">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- ✅ Sidebar Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const open = document.getElementById('menuOpen');
      const close = document.getElementById('menuClose');
      const collapseBtn = document.getElementById('collapseBtn');
      const mainContent = document.getElementById('mainContent');
      let isCollapsed = false;

      open?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
      });

      close?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
      });

      overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
      });

      collapseBtn?.addEventListener('click', () => {
        isCollapsed = !isCollapsed;
        sidebar.classList.toggle('sidebar-collapsed');
        sidebar.classList.toggle('w-20');
        sidebar.classList.toggle('w-64');
        mainContent.classList.toggle('lg:ml-20');
        mainContent.classList.toggle('lg:ml-64');
        collapseBtn.textContent = isCollapsed ? '⏪' : '⏩';
      });
    });
  </script>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
