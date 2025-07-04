<div class="container-fluid px-3">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">Add New Product</h3>
    </div>
    <div>
        <form id="addnewproductform" method="POST" class="w-50 mx-auto">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" required>
            </div>
            <div class="mb-3">
                <label for="product_quantity" class="form-label">Quantity</label>
                <input type="number" name="product_quantity" id="product_quantity" class="form-control" placeholder="Quantity" min="0" required>
            </div>
            <div class="mb-3">
                <label for="product_sku" class="form-label">SKU</label>
                <input type="text" name="product_sku" id="product_sku" class="form-control" placeholder="SKU" required>
            </div>
            <div class="mb-3">
                <label for="product_buying_price" class="form-label">Buying Price</label>
                <input type="number" name="product_buying_price" id="product_buying_price" class="form-control" placeholder="Buying Price" step="0.01" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>
<script>
    $(document).on('submit', '#addnewproductform', function(e){
        e.preventDefault();
        let proformData = $(this).serialize();
        $.ajax({
            url: '<?= base_url('admin/products/add') ?>',
            type: 'POST',
            data: proformData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#addnewproductform')[0].reset();
                } else {
                    alert('Error adding product: ' + (response.message || 'Unknown error.'));
                }
            },
            error: function() {
                alert('An error occurred while adding the product.');
            }
        });
    });
</script>