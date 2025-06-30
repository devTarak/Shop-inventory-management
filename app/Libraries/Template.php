<?php

namespace App\Libraries;

class Template
{
    public function admin_panel(string $view, array $data = []): string
    {
        return view('admin/head', $data)
             . view('admin/sidebar', $data)
             . view('admin/' . $view, $data)
             . view('admin/footer', $data);
    }
}