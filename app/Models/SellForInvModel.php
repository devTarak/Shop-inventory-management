<?php

namespace App\Models;

use CodeIgniter\Model;

class SellForInvModel extends Model
{
    protected $table            = 'sell_log';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id','invoice_number','Customer_id','Sold_intem_id'];
    
    public function getInvoice($invoice)
    {
        return $this->select('sell_log.*, customers.name AS customer_name, customers.phone, customers.address, sales.product_name, sales.product_sku, sales.quantity, sales.selling_price')
                    ->join('customers', 'customers.id = sell_log.Customer_id')
                    ->join('sales', 'sales.id = sell_log.Sold_intem_id')
                    ->where('sell_log.invoice_number', $invoice)
                    ->findAll();
    }
}
