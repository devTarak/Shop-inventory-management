<div class="container-fluid px-3" style="overflow-y: auto;">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">Sell Product</h3>
        <form method="get" class="row g-3 align-items-center" id="searchProductForm">
            <div class="col-auto">
                <input type="text" class="form-control" id="Search_product_name" name="Search_product_name"
                    placeholder="Search by Name">
            </div>
            <div class="col-auto">
                <input type="text" class="form-control" id="Search_product_sku" name="Search_product_sku"
                    placeholder="Search by SKU">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary" id="search_Product_btn">Search</button>
            </div>
        </form>
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
                    <td>
                        <?= esc($i) ?>
                    </td>
                    <td>
                        <?= esc($product['name']) ?>
                    </td>
                    <td>
                        <?= esc($product['quantity']) ?>
                    </td>
                    <td>
                        <?= esc($product['sku']) ?>
                    </td>
                    <td>
                        <?= esc($product['buying_price']) ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary sellProduct" data-bs-toggle="modal"
                            data-bs-target="#sellProduct" data-id="<?= $product['id'] ?>">sale</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No products found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal for Sell Product -->
<div class="modal fade" id="sellProduct" tabindex="-1" aria-labelledby="sellProductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sellProductLabel">Sell Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sellProductForm" method="POST">
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="sell_product_name" id="sell_product_name">
                    <input type="hidden" name="sell_product_sku" id="sell_product_sku">
                    <input type="hidden" name="sell_product_buy_price" id="sell_product_buy_price">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity to Sell</label>
                        <input type="number" min="1" max="" step="1" class="form-control" id="quantity_to_sell" name="quantity"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Selling Price(Total)</label>
                        <input type="number" class="form-control" id="selling_price" name="selling_price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">sale</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('submit', '#searchProductForm', function (e) {
        e.preventDefault();
        var searchName = $('#Search_product_name').val().trim();
        var searchSKU = $('#Search_product_sku').val().trim();

        // If all fields are empty
        if (!searchName && !searchSKU) {
            alert('Please fill at least one field to search.');
            location.reload();
            return false;
        }

        // Only one field should be filled, not both
        if (searchName && searchSKU) {
            alert('Please fill either Name or SKU, not both.');
            location.reload();
            return false;
        }

        $.ajax({
            url: '<?= base_url('admin/searchProducts') ?>',
            type: 'GET',
            data: {
            product_name: searchName,
            product_sku: searchSKU
        },
            dataType: 'JSON',
            success: function (response) {
                var html = '';
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function (product, index) {
                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + $('<div>').text(product.name).html() + '</td>' +
                            '<td>' + $('<div>').text(product.quantity).html() + '</td>' +
                            '<td>' + $('<div>').text(product.sku).html() + '</td>' +
                            '<td>' + $('<div>').text(product.buying_price).html() + '</td>' +
                            '<td>' +
                            '<button type="button" class="btn btn-sm btn-primary sellProduct" data-bs-toggle="modal" data-bs-target="#sellProduct" data-id="' + product.id + '">sale</button>' +
                            '</td>' +
                            '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="6" class="text-center">No products found.</td></tr>';
                }
                $('tbody').html(html);
            },
            error: function () {
                alert('Error searching products.');
            }
        });
    });
    $(document).on('click', '.sellProduct', function () {
        let productId = $(this).data('id');
        $('#product_id').val(productId);
        $('#sell_product_name').val('');
        $('#sell_product_sku').val('');
        $.ajax({
            url: '<?= base_url('admin/products/get') ?>',
            type: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#sell_product_name').val(response.data.name);
                    $('#sell_product_sku').val(response.data.sku);
                    $('#sell_product_buy_price').val(response.data.buying_price);
                    $('#quantity_to_sell').attr('max', response.data.quantity);
                } else {
                    alert('Product not found.');
                }
            },
            error: function () {
                alert('Error fetching product details.');
            }
        });
    });
    $(document).on('submit', '#sellProductForm', function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url('admin/sell/product') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    alert('Product sold successfully.');
                    location.reload();
                } else {
                    alert('Error selling product: ' + response.message);
                }
            },
            error: function () {
                alert('Error processing the sale.');
            }
        });
    });
</script>