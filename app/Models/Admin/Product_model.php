<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Product_model extends Model
{
    protected $table = 'products';

    public function count_all_products()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('products')->countAllResults();
    }

    public function get_all_products($limit, $start)
    {
        $this->db = \Config\Database::connect();
        $products = $this->db->table('products')->get($limit, $start)->getResult();

        return $products;
    }

    public function search_products($query, $limit, $start)
    {
        $this->db = \Config\Database::connect();
        $products = $this->db->table('products')->like('name', $query)->orLike('description', $query)->get($limit, $start)->getResult();

        return $products;
    }

    public function count_search($query)
    {
        $this->db = \Config\Database::connect();
        $count = $this->db->table('products')->like('name', $query)->orLike('description', $query)->countAllResults();;

        return $count;
    }

    public function add_new_product(array $product)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('products')->insert($product);

        return $this->db->insertID();
    }

    public function is_product_exist($id)
    {
        $this->db = \Config\Database::connect();
        return ($this->db->table('products')->where('id', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function product_data($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->db->query("
            SELECT p.*, pc.name as category_name
            FROM products p
            JOIN product_category pc
                ON pc.id = p.category_id
            WHERE p.id = '$id'
        ")->getRow();

        return $data;
    }

    public function delete_product_image($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('products')->where('id', $id)->update(array('picture_name' => NULL));
    }

    public function is_product_have_image($id)
    {
        $this->db = \Config\Database::connect();
        $data = $this->product_data($id);
        $file = $data->picture_name;
        if ($file == NULL) {
            return FALSE;
        }
        return file_exists('./assets/uploads/products/' . $file) ? TRUE : FALSE;
    }

    public function edit_product($id, $product)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('products')->where('id', $id)->update($product);
    }

    public function delete_product($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('products')->where('id', $id)->delete();
    }

    public function get_all_categories()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('product_category')->orderBy('name', 'ASC')->get()->getResult();
    }

    public function category_data($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('product_category')->where('id', $id)->get()->getRow();
    }

    public function add_category($name)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('product_category')->insert(array('name' => $name));

        return $this->db->insertID();
    }

    public function delete_category($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('product_category')->where('id', $id)->delete();
    }

    public function edit_category($id, $name)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('product_category')->where('id', $id)->update(array('name' => $name));
    }


    public function get_all_coupons()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('coupons')->orderBy('expired_date', 'DESC')->get()->getResult();
    }

    public function add_coupon(array $data)
    {
        $this->db = \Config\Database::connect();
        $this->db->table('coupons')->insert($data);

        return $this->db->insertId();
    }

    public function coupon_data($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('coupons')->where('id', $id)->get()->getRow();
    }

    public function edit_coupon($id, $data)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('coupons')->where('id', $id)->update($data);
    }

    public function delete_coupon($id)
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('coupons')->where('id', $id)->delete();
    }

    public function latest()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('products')->where('is_available', 1)->orderBy('add_date', 'DESC')->limit(5)->get()->getResult();
    }

    public function latest_categories()
    {
        $this->db = \Config\Database::connect();
        return $this->db->table('product_category')->orderBy('id', 'DESC')->limit(5)->get()->getResult();
    }
}
