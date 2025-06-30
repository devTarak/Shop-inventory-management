<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
       return $this->template->admin_panel('home', [
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'page_description' => 'Welcome to Tarak\'s Inventory Management Lite',
        ]);
    }
}
