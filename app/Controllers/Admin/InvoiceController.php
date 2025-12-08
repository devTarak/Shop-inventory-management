<?php

namespace App\Controllers\Admin;
require_once ROOTPATH . 'vendor/autoload.php';
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\SaleModel;
use App\Models\CustomerModel;
use App\Models\SellForInvModel;
use Mpdf\Mpdf;

class InvoiceController extends BaseController
{
    protected $customer;
    protected $sellLog;
    protected $productModel;
    protected $saleModel;
    public function __construct()
    {
        $this->customer = new CustomerModel();
        $this->sellLog = new sellForInvModel();
        $this->productModel = new ProductsModel();
        $this->saleModel = new SaleModel();
    }
    public function sellBulkPage(){
        $products = $this->productModel->where('quantity >', 0)->findAll();
        return $this->template->admin_panel('sellbulk', [
            'title' => 'Sell Bulk Product',
            'page_title' => 'Sell Bulk Product',
            'page_description' => 'Sell multiple products from your inventory at once.',
            'products' => $products
        ]);
    }
    public function sellProductBalk(){
        $rules = [
            'Customer_name'  => 'required',
            'Customer_phone' => 'required|numeric',
            'Customer_Address'=> 'required'
        ];
        if (!$this->validate($rules)) {
            return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'error' => 'Fillup The Required Fields',
            ]);
        }else{
            $data = $this->request->getPost();
            $CustomerData = [
            'name' => $data['Customer_name'],
            'phone' => $data['Customer_phone'],
            'address' => $data['Customer_Address']
            ];
            $invoiceID = date('YmdHis');
            $customerId = $this->customer->insert($CustomerData);
            $SoldItemArray=[];
            $tempDataLenth = count($data) - 3;
            $itemsCount = $tempDataLenth / 3;
            $tempDataArray = array_slice(array_keys($data),3);
            $subFieldId = []; 
              foreach($tempDataArray as $fieldName){
                 $parts = explode('_', $fieldName);
                 $subFieldId[] = end($parts);
                }
            $uniqueSubFieldId = array_values(array_unique($subFieldId));
            for ($i = 1; $i <= $itemsCount; $i++) {
                if (isset($data['item_name_' . $uniqueSubFieldId[$i-1]]) && isset($data['quantity_' . $uniqueSubFieldId[$i-1]]) && isset($data['total_price_' . $uniqueSubFieldId[$i-1]])) {
                    $productInfo = $this->productModel->find($data['item_name_' . $uniqueSubFieldId[$i-1]]);
                    if(!empty($productInfo)){
                        $itemData = [
                            'product_name' => $productInfo['name'],
                            'product_sku' => $productInfo['sku'],
                            'quantity' => (int)$data['quantity_' . $uniqueSubFieldId[$i-1]],
                            'product_buying_price' => $productInfo['buying_price'],
                            'selling_price' => $data['total_price_' . $uniqueSubFieldId[$i-1]],
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                        $item = $this->saleModel->insert($itemData);
                        $sellLogData = [
                            'invoice_number' => $invoiceID,
                            'Customer_id' => (int)$customerId,
                            'Sold_intem_id' => (int)$item,
                        ];
                        $invSoldItem = $this->sellLog->insert($sellLogData);
                        $SoldItemArray[] = $invSoldItem;
                        $newStock = $productInfo['quantity'] - $data['quantity_' . $uniqueSubFieldId[$i-1]];
                        $this->productModel->update($data['item_name_' . $uniqueSubFieldId[$i-1]], ['quantity' => $newStock]);
                    }else{
                        if(!empty($SoldItemArray)){
                            foreach($SoldItemArray as $soldItemId){
                                $sellid = $this->sellLog->find($soldItemId);;
                                $this->sellLog->delete($soldItemId);
                                $this->saleModel->delete($sellid['Sold_intem_id']);
                                $this->customer->delete($customerId);
                            }
                        }
                        return redirect()->to('/admin/sellbulk')->with('error', 'Invalid product selected.');
                    }
                }else{
                    return $this->response
                    ->setStatusCode(422)
                    ->setJSON([
                        'error' => 'Fillup The Required Fields',
                    ]); 
                }
            }
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Bulk sale processed successfully.'
            ]);
        }
    }
    public function invoicePage(){
        $invoices = $this->sellLog
            ->distinct()
            ->select('sell_log.invoice_number, sell_log.Customer_id, customers.name as Customer_name, customers.phone as Customer_phone, customers.address as Customer_address')
            ->join('customers', 'customers.id = sell_log.Customer_id', 'left')
            ->orderBy('sell_log.invoice_number', 'DESC')
            ->findAll();
        
        return $this->template->admin_panel('invoice_list', [
            'title' => 'Invoice List',
            'page_title' => 'Invoice List',
            'page_description' => 'View and manage all invoices generated from sales.',
            'invoices' => $invoices
        ]);
    }
    public function viewInvoice($invoiceNumber)
{
    $invoiceData = $this->sellLog->getInvoice($invoiceNumber);

    if (empty($invoiceData)) {
        return redirect()->to('/admin/invoice-list')->with('error', 'Invoice not found.');
    }

    // Calculate invoice total
    $invoiceTotal = 0;
    foreach ($invoiceData as $item) {
        $invoiceTotal += $item['selling_price'];
    }

    // Load the HTML view
    $html = view('invoice_template', [
        'invoiceData' => $invoiceData,
        'invoiceTotal' => $invoiceTotal
    ]);

    // Create mPDF instance
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_top' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'margin_right' => 0
    ]);

    // Write HTML to PDF
    $mpdf->WriteHTML($html);

    // Set headers for CI4 response
    $this->response->setHeader('Content-Type', 'application/pdf');
    $this->response->setHeader('Content-Disposition', 'inline; filename="Invoice_'.$invoiceNumber.'.pdf"');

    // Output PDF directly to browser
    $mpdf->Output("Invoice_$invoiceNumber.pdf", "I");

    // Stop further execution to avoid extra output
    exit;
}
}