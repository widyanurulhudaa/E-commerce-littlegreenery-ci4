<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Customer_model extends Model
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function count_all_customers()
    {
        return $this->db->table('auth_groups_users')->where('group_id', 2)->countAllResults();
    }

    public function latest_customers()
    {
        return $this->db->table('auth_groups_users g')
            ->select('g.group_id,g.user_id, u.name, u.phone_number, u.address, u.profile_picture,u.created_at,u.id')
            ->join('users u', 'u.id = g.user_id', 'left')
            ->where('g.group_id', 2)
            ->where('u.active', 1)
            ->orderBy('u.created_at', 'DESC')->get()->getResult();
    }

    public function get_all_customers()
    {
        // $customers = $this->db->query("
        //     SELECT c.user_id as id, c.profile_picture, c.name, u.email, c.phone_number, c.address
        //     FROM customers c
        //     JOIN users u
        //         ON u.id = c.user_id
        //     ORDER BY u.register_date DESC
        // ");
        $customers = $this->db->table('users u')
            ->join('auth_groups_users g', 'g.user_id= u.id')
            ->where('g.group_id', 2)
            ->orderBy('u.created_at', 'DESC')->get();
        return $customers->getResult();
    }

    public function delete_customer($id)
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS=0;");

        $this->db->table('users')->where('id', $id)->delete();
        $this->db->table('orders')->where('user_id', $id)->delete();
        $this->db->query("
            DELETE order_item
            FROM order_item
            JOIN orders
                ON orders.id = order_item.order_id
            WHERE orders.user_id = '$id'");
        $this->db->query("
            DELETE payments
            FROM payments
            INNER JOIN orders ON orders.id = payments.order_id
            WHERE orders.user_id = '$id'");
        $this->db->query("DELETE orders FROM orders WHERE user_id = '$id'");
    }

    public function is_customer_exist($id)
    {
        return ($this->db->table('users')->where('id', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function customer_data($id)
    {
        // $customer = $this->db->query("
        //     SELECT c.user_id as id, c.profile_picture, c.name, u.email, c.phone_number, c.address, u.register_date
        //     FROM customers c
        //     JOIN users u
        //         ON u.id = c.user_id
        //     WHERE c.user_id = '$id'
        // ");
        return $this->db->table('users')->where('id', $id)->get()->getRow();
    }
}
