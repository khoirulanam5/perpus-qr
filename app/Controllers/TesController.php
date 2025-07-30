<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TesController extends BaseController
{
    public function index()
    {
        return view('admin\dashboard\index', [
            'title' => 'Test'
        ]);
    }
}
