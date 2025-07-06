<?php

namespace App\Libraries;
use App\Models\UsersModel;

class Template
{
    protected $usersModel;
    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }
    public function admin_panel(string $view, array $data = []): string
    {
        $session = session();
        if ($session->get('logged_in')) {
            $user_id = $session->get('user_id');
            $user = $this->usersModel->find($user_id);
            if ($user) {
                $data['user_name'] = $user['username'];
            } else {
                $data['user'] = null; // User not found, handle accordingly
            }
        } else {
            return redirect()->to(base_url())->with('error', 'You must be logged in to access that page.');
        }
        return view('admin/head', $data)
             . view('admin/sidebar', $data)
             . view('admin/' . $view, $data)
             . view('admin/footer', $data);
    }
}