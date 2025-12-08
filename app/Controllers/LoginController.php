<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use App\Models\UsersModel;

class LoginController extends BaseController
{
    protected $session;
    protected $usersModel;
    public function __construct()
    {
      $this->session = session();
      $this->usersModel = new UsersModel();

    }

    public function index()
    {
        return view('login');
    }
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $this->usersModel->where('username', $username)->first();


        if ($user !== null && password_verify($password, $user['password'])) {
            $this->session->set('logged_in', true);
            $this->session->set('user_id', $user['id']);
            return redirect()->to('/admin')->with('message', 'You have successfully logged in.');
        } else {
            return redirect()->to(base_url())->with('error', 'Invalid username or password');
        }
    }
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url())->with('message', 'You have been logged out successfully.');
    }
}
