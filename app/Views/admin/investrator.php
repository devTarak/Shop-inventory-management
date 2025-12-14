<div class="container-fluid px-3" style="overflow-y: auto;">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">Invesment</h3>
        <button type="button" class="btn btn-success addNewInvesment" data-bs-toggle="modal" data-bs-target="#addInvesmentModal">
            <i class="bi bi-plus-lg"></i> Add New Invesment
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-sthiped table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Investor Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                    <th scope="col">Note</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($invesments['invest_data']) && is_array($invesments['invest_data'])) : ?>
                    <?php foreach ($invesments['invest_data'] as $index => $invesment) : ?>
                        <tr>
                            <th scope="row"><?= esc($index + 1 + ($invesments['pager']->getCurrentPage() - 1) * $invesments['pager']->getPerPage()) ?></th>
                            <td><?= esc($invesment['investor_name']) ?></td>
                            <td><?= esc($invesment['amount']) ?></td>
                            <td><?= esc($invesment['invest_date']) ?></td>
                            <td><?= esc($invesment['note']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No invesments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal for Add Invesment -->
<div class="modal fade" id="addInvesmentModal" tabindex="-1" aria-labelledby="addInvesmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInvesmentModalLabel">Add New Invesment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addInvesmentForm" method="POST">
                    <div class="mb-3">
                        <label for="investor_name" class="form-label">Investor Name</label>
                        <select name="investor_name" class="form-control" id="investor_name">
                            <option value="" disabled selected>Select Investor</option>
                            <?php foreach($inv_names as $inv_name): ?>
                                <option value="<?= esc($inv_name['id']) ?>"><?= esc($inv_name['investor_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="invest_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="invest_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Invesment</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#addInvesmentForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?= site_url('admin/invesmant') ?>',
            data: formData,
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('An error occurred while adding the invesment.');
            }
        });
    });
</script>