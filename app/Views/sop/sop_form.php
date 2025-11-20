<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<header class="bg-white border-b shadow-sm px-6 py-4 flex justify-between items-center">
  <div>
    <h1 class="font-semibold text-xl text-gray-800">Anantkamal Software Lab</h1>
    <p class="text-sm text-gray-500">Employee SOP | Consent & Digital Signature</p>
  </div>
  <div class="text-right text-sm text-gray-500">
    <p><strong>Date:</strong> <span id="currentDate"></span></p>
  </div>
</header>

<div class="bg-red-50 text-red-500 text-center py-2 text-sm border-b">
  Please read the Standard Operating Procedure carefully and then provide your consent and signature.
</div>

<main class="max-w-7xl mx-auto my-6 px-4 grid md:grid-cols-3 gap-6">
  <!-- SOP Section -->
  <section id="sopSection" class="md:col-span-2 bg-white rounded-xl shadow p-6 border overflow-y-auto max-h-[80vh]">
    <h2 class="text-lg font-semibold mb-3">Employee SOP (Read-only)</h2>
    <div id="sopContent" class="space-y-4 text-sm leading-relaxed">
      <div>
        <h3 class="font-semibold text-gray-800">1. Company Overview</h3>
        <p>We are committed to delivering high-quality digital products while maintaining professionalism and integrity.</p>
      </div>
      <div>
        <h3 class="font-semibold text-gray-800">2. Code of Conduct</h3>
        <ul class="list-disc list-inside">
          <li>Maintain respectful behavior with colleagues and clients.</li>
          <li>Complete assigned work on time.</li>
          <li>Show honesty and teamwork in all activities.</li>
        </ul>
      </div>
      <div>
        <h3 class="font-semibold text-gray-800">3. Responsibilities</h3>
        <ul class="list-disc list-inside">
          <li>Report progress to your reporting manager daily.</li>
          <li>Get approval before major code or process changes.</li>
        </ul>
      </div>
      <div>
        <h3 class="font-semibold text-gray-800">4. Data Security</h3>
        <ul class="list-disc list-inside">
          <li>Keep all credentials and project information confidential.</li>
          <li>Use only authorized company tools.</li>
        </ul>
      </div>
      <div>
        <h3 class="font-semibold text-gray-800">5. Attendance & Leave</h3>
        <ul class="list-disc list-inside">
          <li>Mark IN/OUT daily.</li>
          <li>Apply planned leave one day in advance.</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Employee Form -->
  <aside class="bg-white rounded-xl shadow p-6 border">
    <h2 class="text-lg font-semibold mb-4">Employee Details</h2>
    <form id="sopForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Full Name *</label>
        <input type="text" id="name" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Employee ID *</label>
        <input type="text" id="empId" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Department</label>
        <input type="text" id="dept" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Official Email *</label>
        <input type="email" id="email" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Effective Date *</label>
        <input type="date" id="date" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
      </div>
      <div class="flex items-start space-x-2">
        <input type="checkbox" id="consent" required class="mt-1">
        <label for="consent" class="text-sm text-gray-700">I have read and agree to follow the above-mentioned SOP.</label>
      </div>

      <!-- Signature -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Digital Signature</label>
        <canvas id="signature-pad" class="border rounded-lg w-full h-32 bg-gray-50"></canvas>
        <button type="button" id="clear" class="mt-2 text-sm text-red-500 hover:text-red-700">Clear</button>
      </div>

      <button type="submit" class="w-full bg-indigo-600 text-white font-medium py-2 rounded-lg hover:bg-indigo-700">
        Submit & Generate PDF
      </button>
    </form>
  </aside>
</main>

<!-- <footer class="text-center text-xs text-gray-500 py-4">
  © 2025 Anantkamal Software Lab · Secure e-Consent
</footer> -->

<!-- ✅ Libraries -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
  document.getElementById("currentDate").textContent = new Date().toLocaleDateString('en-IN');
  const canvas = document.getElementById('signature-pad');
  const signaturePad = new SignaturePad(canvas);
  document.getElementById('clear').addEventListener('click', () => signaturePad.clear());

  document.getElementById('sopForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    if (signaturePad.isEmpty()) {
      alert("Please provide your signature before submitting.");
      return;
    }

    const data = {
      name: document.getElementById('name').value,
      empId: document.getElementById('empId').value,
      dept: document.getElementById('dept').value,
      email: document.getElementById('email').value,
      date: document.getElementById('date').value,
      consent: document.getElementById('consent').checked,
      signature: signaturePad.toDataURL()
    };

    // ✅ Step 1: Save data to database
    const response = await fetch('<?= base_url('sop/save') ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });
    const result = await response.json();

    if (result.status === 'success') {
      // ✅ Step 2: Generate PDF after saving
      const sopSection = document.getElementById('sopSection');
      const sopCanvas = await html2canvas(sopSection, { scale: 1.5 });
      const sopImg = sopCanvas.toDataURL('image/png');
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF('p', 'pt', 'a4');
      let yPos = 40;

      pdf.setFontSize(14);
      pdf.text("Anantkamal Software Lab - SOP Consent", 40, yPos);
      yPos += 40;

      pdf.setFontSize(11);
      pdf.text(`Name: ${data.name}`, 40, yPos); yPos += 20;
      pdf.text(`Employee ID: ${data.empId}`, 40, yPos); yPos += 20;
      pdf.text(`Department: ${data.dept}`, 40, yPos); yPos += 20;
      pdf.text(`Email: ${data.email}`, 40, yPos); yPos += 20;
      pdf.text(`Effective Date: ${data.date}`, 40, yPos); yPos += 30;

      const pdfWidth = pdf.internal.pageSize.getWidth() - 80;
      const imgHeight = (sopCanvas.height * pdfWidth) / sopCanvas.width;
      pdf.addImage(sopImg, 'PNG', 40, yPos, pdfWidth, imgHeight);

      pdf.addPage();
      pdf.setFontSize(12);
      pdf.text("Employee Signature", 40, 60);
      pdf.addImage(data.signature, 'PNG', 40, 80, 150, 80);
      pdf.text("Consent: I confirm that I have read and agree to follow the SOP.", 40, 190);

      pdf.save(`SOP_${data.empId}_${data.name}.pdf`);
      alert("✅ SOP saved and PDF generated successfully!");
    } else {
      alert("❌ " + result.message);
    }

    e.target.reset();
    signaturePad.clear();
  });
</script>

<?= $this->endSection() ?>
