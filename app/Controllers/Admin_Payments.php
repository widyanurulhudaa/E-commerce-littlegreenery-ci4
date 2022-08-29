<?php

namespace App\Controllers;

use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Payment_model;

class Admin_Payments extends BaseController
{
    public function __construct()
    {

        $this->order = new Order_model();

        $this->session = session();
        $this->payment = new Payment_model();
    }

    public function index()
    {

        $pager = \Config\Services::pager();
        $payments = [
            'title' => 'Kelola Pembayaran',
            'payments' => $this->payment
                ->select('payments.id, payments.payment_date, payments.order_id, payments.payment_price, payments.payment_status as status, o.order_number, c.name AS customer')
                ->join('orders o', 'o.id = payments.order_id')
                ->join(' users c', 'c.id = o.user_id')
                ->orderBy('payments.payment_date DESC')
                ->paginate(10, 'table'),
            'pager' => $this->payment->pager
        ];

        return view('admin/payments/payments', $payments);
    }

    public function view($id = 0)
    {
        if ($this->payment->is_payment_exist($id)) {
            $data = $this->payment->payment_data($id);

            $banks = json_decode(get_settings('payment_banks'));
            $banks = (array) $banks;

            $payments['title'] = 'Pembayaran Order #' . $data->order_number;

            $payments['banks'] = $banks;
            $payments['payment'] = $data;
            $payments['flash'] = $this->session->markasflashdata('payment_flash');

            return view('admin/payments/view', $payments);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function verify()
    {
        $id = $this->request->getPost('id');
        $order = $this->request->getPost('order');
        $action = $this->request->getPost('action');
        $redir = $this->request->getPost('redir');

        if ($action == 1) {
            $status = 2;
            $flash = 'Pembayaran berhasil dikonfirmasi';
        } else if ($action == 2) {
            $status = 3;
            $flash = 'Pembayaran ditandai sebagai tidak ada';
        } else {
            $flash = 'Tidak ada tindakan dilakukan';
        }

        $this->payment->set_payment_status($id, $status, $order);

        $this->session->setflashdata('payment_flash', $flash);

        if ($redir == 1)
            return redirect()->to('admin_payments/view/' . $id);

        return redirect()->to('admin_orders/view/' . $order . '#payment_flash');
    }
}
