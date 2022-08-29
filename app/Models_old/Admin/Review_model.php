<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Review_model extends Model
{

    protected $table = 'reviews';
    public function count_all_reviews()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('reviews')->countAllResults();
    }

    public function get_all_reviews()
    {
        $this->db = \Config\Database::connect();
        $reviews = $this->db->query("
            SELECT r.*, o.order_number, c.*, r.id as id
            FROM reviews r
            JOIN orders o
                ON o.id = r.order_id
            JOIN users c
                ON c.id = r.user_id
        ");

        return $reviews->getResult();
    }

    public function is_review_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('reviews')->where('id', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function review_data($id)
    {
        $this->db = \Config\Database::connect();
        $review = $this->db->query("
            SELECT r.*, o.order_number
            FROM reviews r
            JOIN orders o
                ON o.id = r.order_id
            WHERE r.id = '$id'
        ");

        return $review->getRow();
    }

    public function delete_data($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('reviews')->where('id', $id)->delete();
    }
}
