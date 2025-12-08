<div class="container-fluid px-3" style="overflow-y: auto;">
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">Expenses</h3>
        <button type="button" class="btn btn-success addNewExpenses" data-bs-toggle="modal" data-bs-target="#addExpensesModal">
            <i class="bi bi-plus-lg"></i> Add New Expense
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Expense Purpose</th>
                    <th scope="col">Expenser Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Expense Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($expenses['expence_data']) && is_array($expenses['expence_data'])) : ?>
                    <?php foreach ($expenses['expence_data'] as $index => $expense) : ?>
                        <tr>
                            <th scope="row"><?= esc($index + 1 + ($expenses['pager']->getCurrentPage() - 1) * $expenses['pager']->getPerPage()) ?></th>
                            <td><?= esc($expense['expencePurpose']) ?></td>
                            <td><?= esc($expense['expenser_name']) ?></td>
                            <td><?= esc($expense['amount']) ?></td>
                            <td><?= esc($expense['expense_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No expenses found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?= $expenses['pager']->links() ?>
    </div>
</div>
<!-- Modal for Add Expenses -->
<div class="modal fade" id="addExpensesModal" tabindex="-1" aria-labelledby="addExpensesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpensesModalLabel">Add New Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addExpensesForm" method="POST">
                    <div class="mb-3">
                        <label for="expense_purpose" class="form-label">Expense Purpose</label>
                        <input type="text" class="form-control" id="expense_purpose" name="expense_purpose" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenser_name" class="form-label">Expenser Name</label>
                        <input type="text" class="form-control" id="expenser_name" name="expenser_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="expense_date" class="form-label">Expense Date</label>
                        <input type="date" class="form-control" id="expense_date" name="expense_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Expense</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#addExpensesForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('admin/expenses/add') ?>',
                data: $(this).serialize(),
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error adding expense: ' + error);
                }
            });
        });
    });
</script>