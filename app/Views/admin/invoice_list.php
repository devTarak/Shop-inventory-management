<div class="container-fluid px-3" style="overflow-y: auto;">
    <h3 class="mb-5 mt-5">Invoice List</h3>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th scope="col">Invoice Number</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($invoices) && is_array($invoices)): ?>
                <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td><?= esc("INV-" . $invoice['invoice_number']) ?></td>
                        <td><?= esc($invoice['Customer_name']) ?></td>
                        <td><?= esc($invoice['Customer_phone']) ?></td>
                        <td><?= esc($invoice['Customer_address']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/invoice/' . $invoice['invoice_number']) ?>" class="btn btn-primary btn-sm">Download Invoice</a>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No invoices found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>