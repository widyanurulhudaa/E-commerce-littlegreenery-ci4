<?php

namespace App\Models\Customer;

use CodeIgniter\Model;

class Review_model extends Model
{
    protected $table = 'reviews';

    public function count_all_reviews()
    {
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        return $this->db->table('reviews')->where('user_id', $this->user_id)->countAllResults();
    }

    public function get_all_reviews($limit, $start)
    {
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        $reviews = $this->db->query("
            SELECT r.*, o.order_number
            FROM reviews r
            JOIN orders o
                ON o.id = r.order_id
            WHERE r.user_id = '$this->user_id'
            LIMIT $start, $limit
        ");

        return $reviews->getResult();
    }

    public function write_review($data)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('reviews')->insert($data);

        return $this->db->insertID();
    }

    public function is_review_exist($id)
    {
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        return ($this->db->table('reviews')->where(array('id' => $id, 'user_id' => $this->user_id))->countAllResults() > 0) ? TRUE : FALSE;
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

    public function delete_review($id)
    {
        return $this->db->table('reviews')->where(array('id' => $id, 'user_id' => $this->user_id))->delete();
    }
}
