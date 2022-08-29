<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\Customer\Order_model;
use App\Models\ReviewModel;
use phpDocumentor\Reflection\Types\This;

class Customer_Orders extends BaseController
{
    public function __construct()
    {

        $this->order = new Order_model();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_table') ? $this->request->getVar('page_table') : 1;
        $data = [
            'title' => 'Order Saya',
            'orders' => $this->order->select('orders.id, orders.order_number, orders.order_date, orders.order_status, orders.payment_method, orders.total_price, orders.total_items, c.name AS coupon, cu.name AS customer')
                ->join('coupons c', 'c.id = orders.coupon_id', 'left')
                ->join('users cu', 'cu.id = orders.user_id')
                ->where('orders.user_id', user_id())
                ->orderBy('order_date', 'DESC')
                ->paginate(10, 'table'),
            'pager' => $this->order->pager,
            'currentPage' => $currentPage
        ];
        return view('customers/orders/orders', $data);
    }

    public function view($id = 0)
    {
        if ($this->order->is_order_exist($id)) {
            $data = $this->order->order_data($id);
            $items = $this->order->order_items($id);
            $banks = json_decode(get_settings('payment_banks'));
            $banks = (array) $banks;

            $order['title'] = 'Order #' . $data->order_number;

            $order['data'] = $data;
            $order['items'] = $items;
            $order['delivery_data'] = json_decode($data->delivery_data);
            $order['banks'] = $banks;

            return view('customers/orders/view', $order);
        } else {
            //show_404();
        }
    }

    public function order_api()
    {
        $action = $this->request->getGet('action');

        switch ($action) {
            case 'cancel_order':
                $id = $this->request->getPost('id');
                $data = $this->order->order_data($id);

                if (($data->payment_method == 1 && $data->order_status == 1) || ($data->payment_method == 2 && $data->order_status == 1)) {
                    $this->order->cancel_order($id);
                    $response = array('code' => 200, 'success' => TRUE, 'message' => 'Order dibatalkan');
                } else {
                    $response = array('code' => 200, 'error' => TRUE, 'message' => 'Order tidak dapat dibatalkan');
                }
                break;
            case 'delete_order':
                $id = $this->request->getPost('id');
                $data = $this->order->order_data($id);

                if (($data->payment_method == 1 && ($data->order_status == 5 || $data->order_status == 4)) || ($data->payment_method == 2 && ($data->order_status == 4 || $data->order_status == 3))) {
                    $this->order->delete_order($id);
                    $response = array('code' => 200, 'success' => TRUE, 'message' => 'Order dihapus');
                } else {
                    $response = array('code' => 200, 'error' => TRUE, 'message' => 'Order tidak dapat dihapus');
                }
                break;
        }

        return $this->response->setJSON($response);
    }
}
