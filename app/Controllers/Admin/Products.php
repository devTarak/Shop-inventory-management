<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
class Products extends BaseController
{
    protected $productsModel;
    protected $session;
    public function __construct()
    {
        $this->productsModel = new ProductsModel();
        $this->session = session();
    }
    public function index()
    {
        $data['products'] = $this->productsModel->findAll();
        return $this->template->admin_panel('allproducts', [
            'title' => 'Products',
            'page_title' => 'Products',
            'page_description' => 'Manage your products.',
            'products' => $data['products'],
        ],);
    }
    public function getSingleProduct()
    {
        $productId = $this->request->getPost('product_id');
        $product = $this->productsModel->find($productId);
        
        if ($product) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $product
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Product not found.'
            ]);
        }
    }
    public function editProduct()
    {
        $productId = $this->request->getPost('product_id');
        $data = [
            'name' => $this->request->getPost('product_name'),
            'quantity' => $this->request->getPost('product_quantity'),
            'sku' => $this->request->getPost('product_sku'),
            'buying_price' => $this->request->getPost('product_buying_price'),
        ];

        if ($this->productsModel->update($productId, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update product.'
            ]);
        }
    }
    public function addProduct()
    {
        $data = [
            'name' => $this->request->getPost('product_name'),
            'quantity' => $this->request->getPost('product_quantity'),
            'sku' => $this->request->getPost('product_sku'),
            'buying_price' => $this->request->getPost('product_buying_price'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->productsModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product added successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add product.'
            ]);
        }
    }
    public function deleteProduct()
    {
        $productId = $this->request->getVar('product_id');

        if ($this->productsModel->delete($productId)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product deleted successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete product.'
            ]);
        }
    }
    public function addnewproductpage(){
        return $this->template->admin_panel('addnewproduct', [
            'title' => 'Add New Product',
            'page_title' => 'Add New Product',
            'page_description' => 'Manage your products.',
        ],);
    }
}
