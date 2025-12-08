<style>
    @page {
        margin: 0 !important;
        padding: 0 !important;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
        font-family: Arial, sans-serif;
    }

    .pdf-wrapper {
        width: 794px;
        /* A4 width in px */
        margin: 0 auto;
        padding: 0;
        background: white;
    }
</style>

<div class="pdf-wrapper">
    <img src="<?= FCPATH . 'include/image/SDI_TECHNOLOGY.jpg' ?>" alt="">
</div>
<div class="InvDetails" style="width:794px; margin:0 auto; padding:0px 60px; text-align:left;">
    <p>Date: <?= esc(date('Y-m-d', strtotime($invoiceData[0]['created_at']))) ?></p>
    <h4 style="text-align:left; font-size:20px"><?php echo("Inv-" . $invoiceData[0]['invoice_number']) ?></h4>
</div>
<div style="width:794px; margin:0 auto; padding:0px 60px; text-align:left;">
    <h2 style="font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 24px;">Billing To,</h2>
    <div style="font-family: Georgia, 'Times New Roman', Times, serif; font-size:16px; line-height:0.1; padding-left:20px">
        <h3><?= esc($invoiceData[0]['customer_name']) ?></h3>
        <p><?= esc($invoiceData[0]['address']) ?></p>
        <p><?= esc($invoiceData[0]['phone']) ?></p>
    </div>
</div>
<div style="width:794px; margin:0 auto; padding:0px 60px; text-align:centre;">
    <table style="width:100%;" border="1" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th style="font-size:16px;">Product Name</th>
                <th style="font-size:16px;">SKU</th>
                <th style="font-size:16px;">Quantity</th>
                <th style="font-size:16px;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceData as $item) : ?>
                <tr>
                    <td style="padding:8px; font-size:14px;"><?= esc($item['product_name']) ?></td>
                    <td style="padding:8px; font-size:14px;"><?= esc($item['product_sku']) ?></td>
                    <td style="padding:8px; font-size:14px; text-align:center;"><?= esc($item['quantity']) ?></td>
                    <td style="padding:8px; font-size:14px; text-align:right;"><?= number_format(esc($item['selling_price']), 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="padding:8px; font-size:14px; text-align:center;">Total Amount</td>
                <td colspan="1" style="padding:8px; font-size:14px; text-align:right;" class="TotalAmount"><?= esc($invoiceTotal) ?> BDT</td>
            </tr>
        </tbody>
    </table>
</div>
<div style="width:794px; margin:0 auto; padding:80px 60px; text-align:center;">
    <p style="text-align:center;">This invoice is electronicaly generated.</p>
</div>