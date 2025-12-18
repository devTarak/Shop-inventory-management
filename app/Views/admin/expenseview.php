<div class="container-fluid px-3" style="overflow-y: auto;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">Expenses</h3>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExpensesModal">
            <i class="bi bi-plus-lg"></i> Add New Expense
        </button>
    </div>

    <!-- Search Form -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="POST" class="row g-3 align-items-center" id="searchExpenceForm">
            <div class="col-auto">
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="col-auto">
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <!-- Expense Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Expense Purpose</th>
                    <th>Expenser Name</th>
                    <th>Amount</th>
                    <th>Expense Date</th>
                </tr>
            </thead>

            <tbody id="expenseTableBody">
                <?php $total = 0; ?>
                <?php if (!empty($expenses['expence_data'])): ?>
                    <?php foreach ($expenses['expence_data'] as $index => $expense): ?>
                        <?php $total += $expense['amount']; ?>
                        <tr>
                            <th><?= esc($index + 1 + ($expenses['pager']->getCurrentPage() - 1) * $expenses['pager']->getPerPage()) ?></th>
                            <td><?= esc($expense['expencePurpose']) ?></td>
                            <td><?= esc($expense['expenser_name']) ?></td>
                            <td><?= esc($expense['amount']) ?></td>
                            <td><?= esc($expense['expense_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No expenses found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

            <tfoot>
                <tr class="table-dark">
                    <th colspan="3" class="text-center">Total Expense</th>
                    <th id="totalExpense"><?= number_format($total, 2) ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <?= $expenses['pager']->links() ?>
    </div>
</div>

<!-- =======================
     ADD EXPENSE MODAL
======================= -->
<div class="modal fade" id="addExpensesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="addExpensesForm">
                    <div class="mb-3">
                        <label class="form-label">Expense Purpose</label>
                        <input type="text" class="form-control" name="expense_purpose" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expenser Name</label>
                        <input type="text" class="form-control" name="expenser_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expense Date</label>
                        <input type="date" class="form-control" name="expense_date" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Add Expense
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- =======================
     SCRIPT
======================= -->
<script>
$(document).ready(function () {

    /* ==========================
       ADD EXPENSE AJAX
    ========================== */
    $('#addExpensesForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '<?= base_url('admin/expenses/add') ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function () {
                location.reload();
            },
            error: function () {
                alert('Failed to add expense');
            }
        });
    });


    /* ==========================
       SEARCH EXPENSES
    ========================== */
    $('#searchExpenceForm').on('submit', function (e) {
        e.preventDefault();

        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();

        if (!startDate || !endDate) {
            alert('Please select both dates');
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/expenses/search') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function (response) {

                let tbody = $('#expenseTableBody');
                tbody.empty();

                let total = 0;

                if (response.length > 0) {
                    response.forEach(function (row, index) {
                        total += parseFloat(row.amount);

                        tbody.append(`
                            <tr>
                                <th>${index + 1}</th>
                                <td>${row.expencePurpose}</td>
                                <td>${row.expenser_name}</td>
                                <td>${row.amount}</td>
                                <td>${row.expense_date}</td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append(`
                        <tr>
                            <td colspan="5" class="text-center">No expenses found.</td>
                        </tr>
                    `);
                }

                $('#totalExpense').text(total.toFixed(2));
            },
            error: function () {
                alert('Search failed');
            }
        });
    });


    /* ==========================
       DEFAULT LAST 30 DAYS
    ========================== */
    let today = new Date();
    let lastMonth = new Date();
    lastMonth.setMonth(today.getMonth() - 1);

    function formatDate(d) {
        return d.toISOString().split('T')[0];
    }

    $('#start_date').val(formatDate(lastMonth));
    $('#end_date').val(formatDate(today));

});
</script>