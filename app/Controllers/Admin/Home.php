<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\SaleModel;
use App\Models\UsersModel;

class Home extends BaseController
{
    protected $productsModel;
    protected $saleModel;
    protected $usersModel;
    protected $session;
    public function __construct()
    {
        $this->productsModel = new ProductsModel();
        $this->saleModel = new SaleModel();
        $this->usersModel = new UsersModel();
        $this->session = session();
    }
    public function index(): string
    {
        // Fetch all products from the database
        $products = $this->productsModel->findAll();
        $totalProducts = count($products);
        // Fetch all sales from the database
        $today = date('Y-m-d');
        $todaySales = $this->saleModel
            ->where('DATE(created_at)', $today)
            ->countAllResults();
        $lastSold = $this->saleModel->orderBy('created_at', 'DESC')->first();
        $status = 'None';
        if ($lastSold) {
            $quantity = $lastSold['quantity'] ?? 1;
            $quantity = ($quantity > 0) ? $quantity : 1;
            $sellPrice = $lastSold['selling_price'] ?? 0;
            $buyPrice = $lastSold['product_buying_price'] ?? 0;
            $singleSellPrice = $sellPrice / $quantity;
            $profit = $singleSellPrice - $buyPrice;
            if ($profit > 0) {
            $status = 'Profited';
            } elseif ($profit < 0) {
            $status = 'Loss';
            }
        }
        // Calculate last month's total profit
        $firstDayLastMonth = date('Y-m-01', strtotime('first day of last month'));
        $lastDayLastMonth = date('Y-m-t', strtotime('last day of last month'));

        $lastMonthSales = $this->saleModel
            ->select('SUM(product_buying_price) as total_buying, SUM(selling_price) as total_selling')
            ->where('created_at >=', $firstDayLastMonth)
            ->where('created_at <=', $lastDayLastMonth)
            ->first();

        $totalBuying = $lastMonthSales['total_buying'] ?? 0;
        $totalSelling = $lastMonthSales['total_selling'] ?? 0;
        $lastMonthProfit = $totalSelling - $totalBuying;
       return $this->template->admin_panel('home', [
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'page_description' => 'Welcome to Tarak\'s Inventory Management Lite',
            'total_products' => $totalProducts,
            'today_sales' => $todaySales,
            'last_sold_status' => $status,
            'last_month_profit' => $lastMonthProfit,
        ]);
    }
    public function user()
    {
        if ($this->session->get('logged_in')) {
            $user_id = $this->session->get('user_id');
            $user = $this->usersModel->find($user_id);
            if ($user) {
                return $this->template->admin_panel('profile', [
                    'title' => 'User Profile',
                    'page_title' => 'User Profile',
                    'page_description' => 'Manage your profile information',
                    'user_name' => $user['username'],
                    'user_email' => $user['email'],
                ]);
            } else {
                return redirect()->to(base_url('admin'))->with('error', 'User not found.');
            }
        } else {
            return redirect()->to(base_url())->with('error', 'You must be logged in to access that page.');
        }
    }
    public function changePassword()
    {
        $this->session = session();
        if ($this->session->get('logged_in')) {
            $user_id = $this->session->get('user_id');
            $new_password = $this->request->getPost('new_password');
            $confirm_password = $this->request->getPost('confirm_password');

            if ($new_password === $confirm_password) {
                $this->usersModel->update($user_id, ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);
                return redirect()->to(base_url('admin/user'))->with('success', 'Password changed successfully.');
            } else {
                return redirect()->to(base_url('admin/user'))->with('error', 'Passwords do not match.');
            }
        } else {
            return redirect()->to(base_url())->with('error', 'You must be logged in to change your password.');
        }
    }
}
