<div class="container-fluid px-3" style="overflow-y: auto;">
        <h3 class="mb-5 mt-5">Sell Item</h3>
        <form method="post" class="align-items-center mb-3 invSellProductForm">
            <div>
                <input type="text" name="Customer_name" autocomplete="name" class="form-control" placeholder="Customer Name" style="width: 300px; display: inline-block; margin-left: 20px;">
                <input type="text" name="Customer_phone" class="form-control" placeholder="Customer Phone" style="width: 200px; display: inline-block; margin-left: 20px;">
                <input type="text" name="Customer_Address" autocomplete="street-address" class="form-control" placeholder="Customer Address" style="width: 300px; display: inline-block; margin-left: 20px;">
            </div>
            <table class="table table-bordered mt-3" style="margin-left: 20px;">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Item Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price/Piece</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="sell_iteam sell_iteam_1" data="1">
                        <td>
                            <select name="item_name_1" class="form-control productName">
                                <option value="">Select Product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= esc($product['id']) ?>"><?= esc($product['name'] . " (" . $product['buying_price'] . ")") ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="quantity_1" class="form-control quantity" placeholder="Quantity" readonly>
                        </td>
                        <td>
                            <p class="mb-0 single_price">N/A</p>
                        </td>
                        <td>
                            <input type="number" name="total_price_1" class="form-control total_price" placeholder="Total Price" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeIteam" data="1">Remove</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-center">
                            <button type="button" class="btn btn-primary" id="addNewIteam">Add Another Product</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">Total Bill</td>
                        <td colspan="2" class="total_invoice_bill">N/A</td>
                    </tr>

                </tbody>
            </table>
            <div class="text-centre">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </div>
            
        </form>
</div>


<script>
// ADD NEW ROW
$(document).on('click',"#addNewIteam", function() {
    //let newRowNumber = $('.sell_iteam').length + 1;
    var lastRowClass = $('.sell_iteam').last().attr('class').split(/\s+/);
    var partOFLastRowC= lastRowClass[lastRowClass.length -1].split('_');
    let newRowNumber = parseInt(partOFLastRowC[partOFLastRowC.length - 1]) + 1;
    let newRow = `
        <tr class="sell_iteam sell_iteam_${newRowNumber}">
            <td>
                <select name="item_name_${newRowNumber}" class="form-control productName">
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= esc($product['id']) ?>"><?= esc($product['name'] . " (" . $product['buying_price'] . ")") ?></option>
                    <?php endforeach; ?>
                </select>
            </td>

            <td>
                <input type="number" name="quantity_${newRowNumber}" class="form-control quantity" placeholder="Quantity" readonly>
            </td>

            <td>
                <p class="mb-0 single_price">N/A</p>
            </td>

            <td>
                <input type="number" name="total_price_${newRowNumber}" class="form-control total_price" placeholder="Total Price" readonly>
            </td>

            <td>
                <button type="button" class="btn btn-danger btn-sm removeIteam">Remove</button>
            </td>
        </tr>`;

    $(newRow).insertBefore($(this).closest('tr'));
});
// REMOVE ROW
$(document).on('click', '.removeIteam', function () {
    $(this).closest('tr').remove();
});


// AUTO CALCULATE PRICE PER PIECE
$(document).on('input', '.quantity, .total_price', function () {

    let row = $(this).closest('tr');
    let qty = parseFloat(row.find('.quantity').val());
    let total = parseFloat(row.find('.total_price').val());

    if (qty > 0 && total > 0) {
        let singlePrice = (total / qty).toFixed(2);
        row.find('.single_price').text(singlePrice);
    } else {
        row.find('.single_price').text("N/A");
    }
});
$(document).on('change', '.productName', function () {

    let row = $(this).closest('tr'); // target only this row

    if ($(this).val() !== "") {
        row.find(".quantity, .total_price").prop("readonly", false);
    } else {
        row.find(".quantity, .total_price").prop("readonly", true);
        row.find(".quantity, .total_price").val(""); // clear values
        row.find(".single_price").text("N/A");
    }
});
// CALCULATE TOTAL BILL
$(document).on('input', '.quantity, .total_price', function () {
    let totalBill = 0;

    $('.total_price').each(function () {
        let price = parseFloat($(this).val());
        if (!isNaN(price)) {
            totalBill += price;
        }
    });

    $('.total_invoice_bill').text(totalBill.toFixed(2));
});
//onsubmit
$('.invSellProductForm').submit(function(e){
    e.preventDefault();

    let formData = $(this).serialize();

    $.ajax({
        url: '/admin/sellbulk',
        type: 'POST',
        data: formData,
        success: function(response) {
            alert('Products sold successfully!');
            location.reload();
        },
        error: function(xhr, status, error) {
            alert('An error occurred while processing the sale: ' + xhr.responseText);
        }
    });
});
</script>