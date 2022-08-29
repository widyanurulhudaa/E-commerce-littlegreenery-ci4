<?php

namespace App\Controllers;

use App\Models\Admin\Product_model;
use App\Models\SettingModel;
use App\Models\ReviewModel;
use phpDocumentor\Reflection\Types\This;

class Product extends BaseController
{
    // protected $helpers = 'global_helper';
    public function __construct()
    {
        $this->ProductModel = new Product_model();
    }
    public function index()
    {

        $data = [
            'store_name' => 'Toko Ku',
            'title' => 'Product',
            'products' => $this->ProductModel->paginate(8, 'card'),
            'pager' => $this->ProductModel->pager,
            'cart' => \Config\Services::cart()
        ];
        return view('themes\littlegreenery\shop\product', $data);
    }
    public function cek()
    {
        $cart = \Config\Services::cart();
        $response = $cart->contents();
        dd($response);
    }
    public function clear()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
    }
}
