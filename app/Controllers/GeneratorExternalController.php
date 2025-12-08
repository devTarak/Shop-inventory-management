<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class GeneratorExternalController extends BaseController
{
    public function index($a)
    {
        $hastest = password_hash($a, PASSWORD_DEFAULT);
        echo $hastest;
    }
}
