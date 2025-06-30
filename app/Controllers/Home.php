<?php

namespace App\Controllers;
use App\Models\ProductsModel;
use App\Models\SaleModel;

class Home extends BaseController
{
    protected $productsModel;
    protected $saleModel;
    public function __construct()
    {
        $this->productsModel = new ProductsModel();
        $this->saleModel = new SaleModel();
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
}
