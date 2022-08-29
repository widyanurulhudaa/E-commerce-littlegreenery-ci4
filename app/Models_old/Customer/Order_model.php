<?php

namespace App\Models\Customer;

use CodeIgniter\Model;

class Order_model extends Model
{
    public $user_id;

    public function __construct()
    {
        helper('global_helper');
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
    }

    public function count_all_orders()
    {
        $id = $this->user_id;

        return $this->db->table('orders')->where('user_id', $id)->countAllResults();
    }

    public function count_process_order()
    {
        $id = $this->user_id;

        return $this->db->table('orders')->where(array('user_id' => $id, 'order_status' => 2))->countAllResults();
    }

    public function get_all_orders($limit, $start)
    {
        $id = $this->user_id;

        $orders = $this->db->query("
            SELECT o.id, o.order_number, o.order_date, o.order_status, o.payment_method, o.total_price, o.total_items, c.name AS coupon, cu.name AS customer
            FROM orders o
            LEFT JOIN coupons c
                ON c.id = o.coupon_id
            JOIN customers cu
                ON cu.user_id = o.user_id
            WHERE o.user_id = '$id'
            ORDER BY o.order_date DESC
            LIMIT $start, $limit
        ");

        return $orders->getResult();
    }

    public function order_with_bank_payments()
    {
        return $this->db->table('orders')->where(array('user_id' => $this->user_id, 'payment_method' => 1, 'order_status' => 1))->orderBy('order_date', 'DESC')->get()->getResult();
    }

    public function is_order_exist($id)
    {
        $user_id = $this->user_id;

        return ($this->db->table('orders')->where(array('id' => $id, 'user_id' => $user_id))->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function order_data($id)
    {
        $data = $this->db->query("
            SELECT o.*, c.name, c.code, p.payment_price, p.payment_date, p.picture_name, p.payment_status, p.confirmed_date, p.payment_data
            FROM orders o
            LEFT JOIN coupons c
                ON c.id = o.coupon_id
            LEFT JOIN payments p
                ON p.order_id = o.id
            WHERE o.id = '$id'
        ");

        return $data->getRow();
    }

    public function order_items($id)
    {
        $items = $this->db->query("
            SELECT oi.product_id, oi.order_qty, oi.order_price, p.name, p.picture_name
            FROM order_items oi
            JOIN products p
	            ON p.id = oi.product_id
            WHERE order_id = '$id'");

        return $items->getResult();
    }

    // public function cancel_order($id)
    // {
    //     $data = $this->order_data($id);
    //     $payment_method = $data->payment_method;

    //     $status =  ($payment_method == 1) ? 5 : 4;

    //     return $this->db->where('id', $id)->update('orders', array('order_status' => $status));
    // }

    // public function delete_order($id)
    // {
    //     if (($this->db->where('order_id', $id)->get('order_items')->num_rows() > 0))
    //         $this->db->where('order_id', $id)->delete('order_items');

    //     if (($this->db->where('order_id', $id)->get('payments')->num_rows() > 0))
    //         $this->db->where('order_id', $id)->delete('payments');

    //     $this->db->where('id', $id)->delete('orders');
    // }

    // public function all_orders()
    // {
    //     return $this->db->where('user_id', $this->user_id)->order_by('order_date', 'DESC')->get('orders')->result();
    // }
}
