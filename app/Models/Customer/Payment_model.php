<?php

namespace App\Models\Customer;

use CodeIgniter\Model;

class Payment_model extends Model
{
    protected $table = 'payments';


    public function count_all_payments()
    {

        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        $id = $this->user_id;

        return $this->db->table('payments')->join('orders', 'orders.id = payments.order_id')->where('orders.user_id', $id)->countAllResults();
    }

    public function get_all_payments()
    {
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        $id = $this->user_id;

        $payments = $this->db->query("
            SELECT p.*, o.order_number
            FROM payments p
            JOIN orders o
                ON o.id = p.order_id
            WHERE o.user_id = '$id'
            ORDER BY p.payment_date DESC
        ");

        return $payments->getResult();
    }

    public function register_payment($id, array $data)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('orders')->where('id', $id)->update(array('order_status' => 2));
        $this->db->table('payments')->insert($data);

        return $this->db->insertID();
    }

    public function payment_list()
    {
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        $id = $this->user_id;

        $payments = $this->db->query("
            SELECT p.*, o.order_number
            FROM payments p
            JOIN orders o
	            ON o.id = p.order_id
            WHERE o.user_id = '$id'
            ORDER BY `p`.`payment_date` DESC
            LIMIT 10");

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
        $data = $this->db->table('payments p')->select('p.*, o.order_number')->join('orders o', 'o.id = p.order_id')->where('p.id', $id)->get()->getRow();

        return $data;
    }
}
