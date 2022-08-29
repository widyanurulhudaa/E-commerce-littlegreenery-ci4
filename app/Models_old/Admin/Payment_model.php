<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Payment_model extends Model
{
    protected $table = 'payments';


    public function count_all_payments()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('payments')->countAllResults();
    }

    public function sum_success_payment()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('orders')->select('SUM(total_price) as total_payment')->where('order_status', 4)->orWhere('order_status', 3)->get()->getRow()->total_payment;
    }

    public function payment_overview()
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT p.*, o.order_number, c.name, c.profile_picture, o.user_id
            FROM payments p
            JOIN orders o
	            ON o.id = p.order_id
            JOIN users c
	            ON c.id = o.user_id
            WHERE p.payment_status = '1'
            LIMIT 5")->getResult();

        return $data;
    }

    public function set_payment_status($id, $status, $order)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('orders')->where('id', $order)->update(array('order_status' => 2));

        return $this->db->table('payments')->where('id', $id)->update(array('payment_status' => $status));
    }

    public function get_all_payments()
    {
        $this->db = \Config\Database::connect();
        $payments = $this->db->query("
            SELECT p.id, p.payment_date, p.order_id, p.payment_price, p.payment_status as status, o.order_number, c.name AS customer
            FROM payments p
            JOIN orders o
                ON o.id = p.order_id
            JOIN users c
                ON c.id = o.user_id
            ORDER BY p.payment_date DESC
        ");

        return $payments->getResult();
    }

    public function is_payment_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('payments')->where('id', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function payment_data($id)
    {
        $this->db = \Config\Database::connect();
        $payment = $this->db->query("
            SELECT p.*, o.order_number, c.name AS customer
            FROM payments p
            JOIN orders o
                ON o.id = p.order_id
            JOIN users c
                ON c.id = o.user_id
            WHERE p.id = '$id'
        ");

        return $payment->getRow();
    }

    public function payment_by($id)
    {
        $this->db = \Config\Database::connect();
        $payments = $this->db->query("
            SELECT p.id, p.payment_date, p.order_id, p.payment_price, p.payment_status as status, o.order_number, c.name AS customer, p.payment_status
            FROM payments p
            JOIN orders o
                ON o.id = p.order_id
            JOIN users c
                ON c.id = o.user_id
            WHERE o.user_id = '$id'
        ");

        return $payments->getResult();
    }
}
