<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SettingModel;
use App\Models\ReviewModel;
use phpDocumentor\Reflection\Types\This;

class Home extends BaseController
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
        $best_deal = $this->ProductModel->where(['is_available' => 1])->orderBy('current_discount', 'DESC')->first();
        $setting = $this->SettingModel->findAll();
        $produk = $this->ProductModel->get_home_products();
        $reviews = $this->ReviewModel->getReview();
        $data = [
            'store_name' => 'Toko Ku',
            'title' => 'Halaman Utama',
            'products' => $produk,
            'setting'  => $setting,
            'best_deal'  => $best_deal,
            'reviews' => $reviews,
            'cart' => \Config\Services::cart()
        ];
        return view('themes\littlegreenery\home', $data);
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
