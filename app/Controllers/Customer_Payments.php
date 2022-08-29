<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\Customer\Order_model;
use App\Models\Customer\Payment_model;
use App\Models\ReviewModel;
use phpDocumentor\Reflection\Types\This;

class Customer_Payments extends BaseController
{
    public function __construct()
    {

        $this->validation =  \Config\Services::validation();
        $this->order = new Order_model();
        $this->payment = new Payment_model();
        $this->session = session();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_table') ? $this->request->getVar('page_table') : 1;
        $data = [
            'title' => 'Pembayaran Saya',
            'payments' => $this->payment->select('payments.*, o.order_number')
                ->join('orders o', 'o.id = payments.order_id')
                ->where('o.user_id', user_id())
                ->orderBy('payment_date', 'DESC')
                ->paginate(10, 'table'),
            'pager' => $this->payment->pager,
            'currentPage' => $currentPage
        ];
        return view('customers/payments/payments', $data);
    }

    public function confirm()
    {
        $order = $this->request->getGet('order');

        $payments['title'] = 'Konfirmasi Pembayaran';

        $payments['orders'] = $this->order->order_with_bank_payments();
        $payments['banks'] = (array) json_decode(get_settings('payment_banks'));
        $payments['order_id'] = $order;
        $payments['flash'] = $this->session->getFlashdata('payment_flash');
        $payments['payments'] = $this->payment->payment_list();
        return view('customers/payments/confirm', $payments);
    }

    public function do_confirm()
    {

        $validate = $this->validate([
            'order_id' => [
                'label' => 'Order',
                'rules' => 'required|numeric'
            ],
            'bank_name' => [
                'label' => 'Nama bank',
                'rules' => 'required'
            ],
            'name' => [
                'label' => 'Nama pengirim',
                'rules' => 'required'
            ],
            'bank_number' => [
                'label' => 'Jumlah transfer',
                'rules' => 'required'
            ],
            'bank' => [
                'label' => 'Bank transfer tujuan',
                'rules' => 'required'
            ],
            'picture' => [
                'rules' => 'uploaded[picture]'
                    . '|is_image[picture]'
                    . '|mime_in[picture,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[picture,5096]',
            ]
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $order_id = $this->request->getPost('order_id');
        $bank_name = $this->request->getPost('bank_name');
        $bank_number = $this->request->getPost('bank_number');
        $transfer = $this->request->getPost('transfer');
        $name = $this->request->getPost('name');
        $bank = $this->request->getPost('bank');

        $img = $this->request->getFile('picture');
        $img->move('assets/uploads/payments');
        $picture_name = $img->getName();

        $data = array(
            'transfer_to' => $bank,
            'source' => array(
                'bank' => $bank_name,
                'name' => $name,
                'number' => $bank_number
            )
        );
        $data = json_encode($data);

        $payment = array(
            'order_id' => $order_id,
            'payment_price' => $transfer,
            'payment_date' => date('Y-m-d H:i:s'),
            'picture_name' => $picture_name,
            'payment_data' => $data
        );

        $this->payment->register_payment($order_id, $payment);
        $this->session->setflashdata('payment_flash', 'Konfirmasi berhasil dilakukan. Admin akan memverifikasinya dalam waktu 1x24 jam');

        return redirect()->to(base_url('customer_payments/confirm'));
    }

    public function view($id = 0)
    {
        if ($this->payment->is_payment_exist($id)) {
            $data = $this->payment->payment_data($id);
            $banks = json_decode(get_settings('payment_banks'));
            $banks = (array) $banks;

            $payment['title'] = 'Pembayaran Order #' . $data->order_number;

            $payment['data'] = $data;
            $payment['banks'] = $banks;

            $payment['payment'] = json_decode($data->payment_data);

            return view('customers/payments/view', $payment);
        } else {
            // show_404();
        }
    }
}
