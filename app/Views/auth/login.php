<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Task Management System - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">

  <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-200">

    <!-- Company Logo & Title -->
    <div class="text-center mb-6">
      <img src="<?= base_url('uploads/logo.jpeg') ?>" alt="Company Logo" 
           class="w-20 h-20 mx-auto mb-3 rounded-full bg-white shadow-sm border border-gray-200">
      <!--<h1 class="text-2xl font-bold text-orange-600">Anantkamal</h1>-->
      <p class="text-black-600 font-bold text-2xl">Task Management System</p>
    </div>

    <!-- Flash Error -->
    <?php if (session()->getFlashdata('error')): ?>
      <div class="text-red-600 text-center text-sm mb-4">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="<?= base_url('/login') ?>" class="space-y-5">
      <div>
        <label class="block text-gray-700 font-medium mb-1">Email Address</label>
        <input type="email" name="email" 
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
               placeholder="Enter your email" required>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Password</label>
        <input type="password" name="password"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
               placeholder="Enter your password" required>
      </div>

      <!--<div class="flex justify-between items-center text-sm">-->
      <!--  <label class="inline-flex items-center">-->
      <!--    <input type="checkbox" class="accent-blue-600">-->
      <!--    <span class="ml-2 text-gray-600">Remember Me</span>-->
      <!--  </label>-->
      <!--  <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>-->
      <!--</div>-->

      <button type="submit"
              class="w-full bg-black hover:bg-orange-700 text-white py-2 rounded-lg font-semibold transition-all">
        Login
      </button>
    </form>

    <p class="text-center text-gray-500 text-sm mt-6">
      © <?= date('Y') ?> <span class="text-orange-600 font-semibold">Anantkamal Software Labs</span> • All Rights Reserved
    </p>
  </div>

</body>
</html>
