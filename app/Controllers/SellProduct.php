<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\SaleModel;

class SellProduct extends BaseController
{
    protected $productsModel;
    protected $saleModel;
    public function __construct()
    {
        $this->productsModel = new ProductsModel();
        $this->saleModel = new SaleModel();
    }
    public function index()
    {
        // Fetch all products from the database
        $products = $this->productsModel->findAll();
        return $this->template->admin_panel('sellproduct', [
            'title' => 'Sell Product',
            'page_title' => 'Sell Product',
            'page_description' => 'Sell a product from your inventory.',
            'products' => $products,
        ]);
    }
    public function searchProducts()
    {
        $productName = $this->request->getGet('product_name');
        $productSKU = $this->request->getGet('product_sku');

        // Validate input
        if (empty($productName) && empty($productSKU)) {
            return $this->response->setJSON(['error' => 'Please fill at least one field to search.']);
        }

        if (!empty($productName) && !empty($productSKU)) {
            return $this->response->setJSON(['error' => 'Please fill either Name or SKU, not both.']);
        }

        // Search logic
        if (!empty($productSKU)) {
            // Exact match for SKU
            $products = $this->productsModel->where('sku', $productSKU)->findAll();
        } else {
            // Partial match for product name
            $products = $this->productsModel
                ->like('name', $productName, 'both')
                ->findAll();
        }

        // Return the results as JSON
        return $this->response->setJSON($products);
    }
    public function sellProduct()
    {
        $productId = $this->request->getPost('product_id');
        $sellingPrice = $this->request->getPost('selling_price');
        $sellQuantity = $this->request->getPost('quantity');

        // Validate input
        if (empty($productId) || empty($sellingPrice) || empty($sellQuantity)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product ID, Selling Price, and Quantity are required.'
            ]);
        }

        if (!is_numeric($sellQuantity) || $sellQuantity <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Quantity must be a positive number.'
            ]);
        }

        // Fetch product details
        $product = $this->productsModel->find($productId);
        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product not found.'
            ]);
        }

        // Check available quantity
        if ($product['quantity'] < $sellQuantity) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Not enough product quantity in stock.'
            ]);
        }

        // Create sale record
        $saleData = [
            'product_name' => $product['name'],
            'product_sku' => $product['sku'],
            'quantity' => (int)$sellQuantity,
            'product_buying_price' => $product['buying_price'],
            'selling_price' => $sellingPrice,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->saleModel->insert($saleData)) {
            // Update product quantity
            $newQuantity = $product['quantity'] - $sellQuantity;
            $this->productsModel->update($productId, ['quantity' => $newQuantity]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product sold successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to record the sale.'
            ]);
        }
    }
}
