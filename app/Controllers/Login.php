<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SettingModel;
use App\Models\ReviewModel;

class Login extends BaseController
{
    // protected $helpers = 'global_helper';
    public function __construct()
    {
        $this->ReviewModel = new ReviewModel();
        $this->SettingModel = new SettingModel();
        $this->ProductModel = new ProductModel();
    }
    public function index()
    {

        return view('auth\loginn', [
            'config' => config('Auth'),
        ]);
    }
    public function daftar()
    {

        return view('auth\register1');
    }
}
