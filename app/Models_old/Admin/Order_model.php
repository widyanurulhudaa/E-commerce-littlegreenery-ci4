<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Order_model extends Model
{
    protected $table = 'orders';


    public function count_all_orders($search = null)
    {
        $this->db = \Config\Database::connect();
        if (empty($search)) {
            return $this->db->table('orders')->countAll();
        } else {
            $count = $this->db->table('orders o')
                ->join('users c', 'c.id = o.user_id')
                ->like('u.name', $search)
                ->orLike('o.order_number', $search)
                ->countAllResults();
        }
    }

    public function get_all_orders($limit, $start, $search = null)
    {
        // $orders = $this->db->query("
        //     SELECT o.id, o.order_number, o.order_date, o.order_status, o.payment_method, o.total_price, o.total_items, c.name AS coupon, cu.name AS customer
        //     FROM orders o
        //     LEFT JOIN coupons c
        //         ON c.id = o.coupon_id
        //     JOIN customers cu
        //         ON cu.user_id = o.user_id
        //     ORDER BY o.order_date DESC
        //     LIMIT $start, $limit
        // ");
        $this->db = \Config\Database::connect();
        $this->db->table('orders o')->select('o.id, o.order_number, o.order_date, o.order_status, o.payment_method, o.total_price, o.total_items, c.name AS coupon, cu.name AS customer')
            ->join('coupons c', 'c.id = o.coupon_id', 'left')
            ->join('users cu', 'cu.id = o.user_id', 'left')
            ->orderBy('o.order_date', 'DESC')
            ->limit($limit, $start);

        if (!is_null($search)) {
            $this->db->table('orders o')->like('o.order_number', $search)
                ->orLike('o.total_price', $search)
                ->orLike('cu.name', $search);
        }

        $orders = $this->db->table('orders o')->get();

        return $orders->getResult();
    }

    public function latest_orders()
    {
        $this->db = \Config\Database::connect();
        $orders = $this->db->query("
            SELECT o.id, o.order_number, o.order_date, o.order_status, o.payment_method, o.total_price, o.total_items, c.name AS coupon, cu.name AS customer
            FROM orders o
            LEFT JOIN coupons c
                ON c.id = o.coupon_id
            JOIN users cu
                ON cu.id = o.user_id
            ORDER BY o.order_date DESC
            LIMIT 5
        ");

        return $orders->getResult();
    }

    public function is_order_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('orders')->where('id', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function order_data($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT o.*, c.name, c.code, p.id as payment_id, p.payment_price, p.payment_date, p.picture_name, p.payment_status, p.confirmed_date, p.payment_data
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
        $this->db = \Config\Database::connect();
        $items = $this->db->query("
            SELECT oi.product_id, oi.order_qty, oi.order_price, p.name, p.picture_name
            FROM order_items oi
            JOIN products p
	            ON p.id = oi.product_id
            WHERE order_id = '$id'");

        return $items->getResult();
    }

    public function set_status($status, $order)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('orders')->where('id', $order)->update(array('order_status' => $status));
    }

    public function product_ordered($id)
    {
        $this->db = \Config\Database::connect();
        $orders = $this->db->query("
            SELECT oi.*, o.id as order_id, o.order_number, o.order_date, c.name, p.product_unit AS unit
            FROM order_items oi
            JOIN orders o
	            ON o.id = oi.order_id
            JOIN users c
                ON c.id = o.user_id
            JOIN products p
	            ON p.id = oi.product_id
            WHERE oi.product_id = '$id'");

        return $orders->getResult();
    }

    public function order_by($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('orders')->where('user_id', $id)->orderBy('order_date', 'DESC')->get()->getResult();
    }

    public function order_overview()
    {
        $this->db = \Config\Database::connect();
        $overview = $this->db->query("
            SELECT MONTH(order_date) month, COUNT(order_date) sale 
            FROM orders
            WHERE order_date >= NOW() - INTERVAL 1 YEAR
            GROUP BY MONTH(order_date)");

        return $overview->getResult();
    }

    public function income_overview()
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT  MONTH(order_date) AS month, SUM(total_price) AS income
            FROM orders
            GROUP BY MONTH(order_date)");

        return $data->getResult();
    }
}
