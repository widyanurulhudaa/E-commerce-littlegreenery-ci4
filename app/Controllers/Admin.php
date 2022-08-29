<?php

namespace App\Controllers;

use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Payment_model;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->product = new Product_model();
        $this->customer = new Customer_model();
        $this->order = new Order_model();
        $this->payment = new Payment_model();
    }

    public function index()
    {
        $overview['title'] = 'Admin ' . get_store_name();

        $overview['total_products'] = $this->product->count_all_products();
        $overview['total_customers'] = $this->customer->count_all_customers();
        $overview['total_order'] = $this->order->count_all_orders();
        $overview['total_income'] = $this->payment->sum_success_payment();

        $overview['products'] = $this->product->latest();
        $overview['categories'] = $this->product->latest_categories();
        $overview['payments'] = $this->payment->payment_overview();
        $overview['orders'] = $this->order->latest_orders();
        $overview['customers'] = $this->customer->latest_customers();

        $overview['order_overviews'] = $this->order->order_overview();
        $overview['income_overviews'] = $this->order->income_overview();

        return view('admin\overview', $overview);
    }
}
