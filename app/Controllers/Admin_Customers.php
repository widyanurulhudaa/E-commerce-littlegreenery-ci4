<?php

namespace App\Controllers;

use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Payment_model;

class Admin_Customers extends BaseController
{
    public function __construct()
    {

        $this->order = new Order_model();
        $this->customer = new Customer_model();
        $this->session = session();
        $this->payment = new Payment_model();
    }

    public function index()
    {
        $params['title'] = 'Kelola Pembayaran';

        return view('admin/customers/customers', $params);
    }

    public function view($id = 0)
    {
        if ($this->customer->is_customer_exist($id)) {
            $data = $this->customer->customer_data($id);

            $customer['title'] = $data->name;

            $customer['customer'] = $data;
            $customer['flash'] = $this->session->setflashdata('customer_flash');
            $customer['orders'] = $this->order->order_by($id);
            $customer['payments'] = $this->payment->payment_by($id);

            return view('admin/customers/view', $customer);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit($id = 0)
    {
    }

    public function api($action = '')
    {
        switch ($action) {
            case 'customers':
                $customers = $this->customer->get_all_customers();

                $n = 0;
                foreach ($customers as $customer) {
                    $customers[$n]->profile_picture = base_url('assets/uploads/users/' . $customer->profile_picture);

                    $n++;
                }

                $customers['data'] = $customers;

                $response = $customers;
                break;
            case 'delete':
                $id = $this->input->getPost('id');

                $this->customer->delete_customer($id);

                $response = array('code' => 204);
                break;
        }

        return $this->response->setJSON($response);
    }
}
