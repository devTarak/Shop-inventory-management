<div class="container-fluid px-3" style="overflow-y: auto;">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">All Products</h3>
        <button type="button" class="btn btn-success addProduct" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-lg"></i> Add Product
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover w-100">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Buying Price/pice</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 0;?>
                <?php if (!empty($products) && is_array($products)): ?>
                    <?php foreach ($products as $product): 
                        $i++;?>
                        <tr>
                            <td><?= esc($i) ?></td>
                            <td><?= esc($product['name']) ?></td>
                            <td><?= esc($product['quantity']) ?></td>
                            <td><?= esc($product['sku']) ?></td>
                            <td><?= esc($product['buying_price']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary productEdit"data-bs-toggle="modal"
                                        data-bs-target="#editProductModal" data-id="<?= $product['id'] ?>">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger productDelete" data-id="<?= $product['id'] ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal for Add Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" method="POST">
                    <div class="mb-3">
                        <label for="new_product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="new_product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_product_quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="new_product_quantity" name="product_quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_product_sku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="new_product_sku" name="product_sku" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_product_buying_price" class="form-label">Buying Price</label>
                        <input type="number" class="form-control" id="new_product_buying_price" name="product_buying_price" step="0.01" min="0" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary addproductsave">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal for Add Product -->
<!-- Modal for Edit Product -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="product_quantity" name="product_quantity" required>   
                    </div>
                    <div class="mb-3">
                        <label for="product_sku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="product_sku" name="product_sku" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_buying_price" class="form-label">Buying Price</label>
                        <input type="number" class="form-control" id="product_buying_price" name="product_buying_price" step="0.01" min="0" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary editproductsave" data-id="">Save changes</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal for Edit Product -->
<script>
    $(document).on('click', '.addProduct', function() {
        $('#addProductForm')[0].reset();
    });
    $(document).on('submit', '#addProductForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url('admin/products/add') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error adding product.');
            }
        });
    });
    $(document).on('click', '.productEdit', function(){
        let productId = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/products/get') ?>',
            type: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#product_name').val(response.data.name);
                    $('#product_quantity').val(response.data.quantity);
                    $('#product_sku').val(response.data.sku);
                    $('#product_buying_price').val(response.data.buying_price);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error retrieving product details.');
            }
        });
        $('.editproductsave').attr('data-id', productId);
    })
    $(document).on('submit', '#editProductForm', function(e) {
        e.preventDefault();
        let productId = $('.editproductsave').data('id');
        $.ajax({
            url: '<?= base_url('admin/products/edit') ?>',
            type: 'POST',
            data: $(this).serialize() + '&product_id=' + productId,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error updating product.');
            }
        });
    });
    $(document).on('click', '.productDelete', function() {
        let productId = $(this).data('id');
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: '<?= base_url('admin/products/delete') ?>?product_id=' + productId,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error deleting product.');
                }
            });
        }
    });
</script>