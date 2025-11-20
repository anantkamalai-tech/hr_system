<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- <style>
    table.dataTable tbody td {
    white-space: normal !important;
    word-wrap: break-word;
    border: 1px solid #ddd;
}

table.dataTable thead th {
    border: 1px solid #333;
} -->

</style>
<h2 class="text-2xl font-semibold mb-4">Employee Attendance</h2>

<div class="mx-auto bg-white shadow-md rounded-lg p-6">

<!-- Filter -->
<form method="get" class="flex gap-4 mb-4">
    <input type="date" id="filterDate" class="form-control border rounded px-3 py-2" style="width:200px; margin-bottom:10px;">
<!-- 
    <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Search by name"
        class="border rounded px-3 py-2" /> -->

    <!-- <select name="filter" class="border rounded px-3 py-2">
        <option value="">All</option>
        <option value="week" <?= ($filter == 'week') ? 'selected' : '' ?>>This Week</option>
        <option value="month" <?= ($filter == 'month') ? 'selected' : '' ?>>This Month</option>
    </select> -->

    <!-- <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Filter
    </button> -->
</form>

<!-- Attendance Table -->
<div class="overflow-x-auto">
<table id="attendanceTable" class="display nowrap w-full border border-gray-300 text-sm">
    <thead class="bg-gray-100 border-b border-gray-300">
        <tr>
            <th class="p-2 border">Employee</th>
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Check In</th>
            <th class="p-2 border">Check Out</th>
            <th class="p-2 border">Work Description</th>
            <th class="p-2 border">Report</th>
            <th class="p-2 border">Total Hours</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($attendances as $att): ?>
        <tr class="hover:bg-gray-50">
            <td class="p-2 border"><?= esc($att['employee_name']) ?></td>
            <td class="p-2 border"><?= esc($att['date']) ?></td>
            <td class="p-2 border"><?= esc($att['check_in']) ?></td>
            <td class="p-2 border"><?= esc($att['check_out']) ?></td>

            <!-- Work description button + hidden export description -->
            <td class="p-2 border text-center">
                <button class="viewWork bg-green-600 text-white px-2 py-1 rounded text-xs"
                        data-desc="<?= esc($att['work_description'] ?: '-') ?>">
                    View
                </button>
                <span class="hidden export-desc"><?= esc($att['work_description'] ?: '-') ?></span>
            </td>

            <td class="p-2 border"><?= $att['report_submitted'] ? 'Submitted' : 'Pending' ?></td>
            <td class="p-2 border"><?= esc($att['total_hours']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>

<!-- Work Description Modal -->
<div id="workModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg max-w-md w-full">
        <h3 class="text-lg font-semibold mb-3">Work Description</h3>
        <p id="workText" class="text-gray-700 whitespace-pre-wrap"></p>
        <button id="closeModal" class="mt-4 bg-red-600 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>



<style>
/* allow wrapped text */
td, th { white-space: normal !important; }
.export-desc { white-space: pre-wrap !important; }
</style>



<script>
$(document).ready(function () {

    let table = $('#attendanceTable').DataTable({
        scrollX: true,
        pageLength: 10,
        autoWidth: false,
        order: [[1, "desc"]],

        // columnDefs: [
        //     { width: "140px", targets: 0 },
        //     { width: "120px", targets: 1 },
        //     { width: "100px", targets: 2 },
        //     { width: "100px", targets: 3 },
        //     { width: "300px", targets: 4 },
        //     { width: "120px", targets: 5 },
        //     { width: "100px", targets: 6 }
        // ],

        dom: 'Bfrtip',
        buttons: [
            {
    extend: "excelHtml5",
    text: "Export Excel",
    exportOptions: {
        format: {
            body: function (data, row, column, node) {
                if (column === 4) {
                    return $(node).find('.export-desc').text().replace(/<br\s*\/?>/gi, "\n");
                }
                return $(node).text();
            }
        }
    },
    customize: function (xlsx) {
        const sheet = xlsx.xl.worksheets['sheet1.xml'];
        
        // Enable text wrap on all cells in column E (work description)
        $('row c[r^="E"]', sheet).each(function () {
            $(this).attr('s', '55'); // style index for wrap
        });
        
        // Add wrap style if missing
        const styles = xlsx.xl['styles.xml'];
        const cellXfs = $('cellXfs xf', styles);
        if (!cellXfs.filter('[applyAlignment="1"]').length) {
            const wrapStyle = '<xf applyAlignment="1"><alignment wrapText="1"/></xf>';
            $(styles.childNodes[0]).append(wrapStyle);
        }
    }
},
{
    extend: "pdfHtml5",
    text: "Export PDF",
    orientation: "landscape",
    pageSize: "A4",
    customize: function (doc) {
        // align all table text to left
        doc.styles.tableBodyEven.alignment = 'left';
        doc.styles.tableBodyOdd.alignment = 'left';

        // wrap long text in PDF
        const objLayout = {};
        objLayout['hLineWidth'] = function() { return .5; };
        objLayout['vLineWidth'] = function() { return .5; };
        objLayout['hLineColor'] = function() { return '#aaa'; };
        objLayout['vLineColor'] = function() { return '#aaa'; };
        objLayout['paddingLeft'] = function() { return 5; };
        objLayout['paddingRight'] = function() { return 5; };
        doc.content[1].layout = objLayout; 
    },
    exportOptions: {
        format: {
            body: function (data, row, column, node) {
                if (column === 4) {
                    return $(node).find('.export-desc').text();
                }
                return $(node).text();
            }
        }
    }
}

            // {
            //     extend: "print",
            //     text: "Print",
            //     exportOptions: {
            //         format: {
            //             body: function (data, row, column, node) {
            //                 if (column === 4) {
            //                     return $(node).find('.export-desc').text();
            //                 }
            //                 return $(node).text();
            //             }
            //         }
            //     }
            // }
        ]
    });

    // Show modal description
    $(document).on('click', '.viewWork', function () {
        $('#workText').text($(this).data('desc'));
        $('#workModal').removeClass('hidden');
    });

    $('#closeModal').click(function () {
        $('#workModal').addClass('hidden');
    });


        $('#filterDate').on('change', function () {
        var selectedDate = $(this).val();

        if (selectedDate !== "") {
            table.column(1).search("^" + selectedDate + "$", true, false).draw();
        } else {
            table.column(1).search("").draw();
        }
    });
});
</script>

<?= $this->endSection() ?>
