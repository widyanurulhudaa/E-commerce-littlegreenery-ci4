<?php

namespace App\Controllers;

use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Payment_model;

class Admin_Orders extends BaseController
{
    public function __construct()
    {

        $this->order = new Order_model();
        $this->session = session();
    }

    public function index()
    {
        //$search = $this->input->getGet('search_query');

        // if ($search) {
        //     $orders['title'] = 'Cari "' . $search . '"';
        // } else {
        $orders['title'] = 'Kelola Order';
        // }
        $orders['orders'] = $this->order->select('orders.*, u.name, u.id as id_user')->join('users u', 'u.id = orders.user_id')->orderBy('order_date', 'DESC')->paginate(10, 'table');
        // dd($orders['orders']);
        $orders['pager'] = $this->order->pager;
        return view('admin/orders/orders', $orders);
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
            $order['order_flash'] = $this->session->setflashdata('order_flash');
            $order['payment_flash'] = $this->session->setflashdata('payment_flash');

            return view('admin/orders/view', $order);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function status()
    {
        $status = $this->request->getPost('status');
        $order = $this->request->getPost('order');

        $this->order->set_status($status, $order);
        $this->session->setflashdata('order_flash', 'Status berhasil diperbarui');

        return redirect()->to(base_url('admin_orders/view/' . $order));
    }

    // public function pdf($id)
    // {
    //     if ($this->order->is_order_exist($id)) {
    //         $this->load->library('pdf');
    //         $data = $this->order->order_data($id);

    //         $items = $this->order->order_items($id);
    //         $banks = json_decode(get_settings('payment_banks'));
    //         $banks = (array) $banks;

    //         $params['data'] = $data;
    //         $params['items'] = $items;
    //         $params['delivery_data'] = json_decode($data->delivery_data);
    //         $params['banks'] = $banks;

    //         $html = $this->load->view('orders/pdf', $params, true);
    //         $this->pdf->createPDF($html, 'order_' . $data->order_number, false, 'A3');
    //     } else {
    //         show_404();
    //     }
    // }
}
