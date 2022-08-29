<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    public function get_all_products()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $data = $builder->get();
        return $data->getResultArray();
    }
    public function get_home_products()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $data = $builder->limit(8)->orderBy('add_date', 'DESC')->get();
        return $data->getResultArray();
    }

    public function best_deal_product()
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT * FROM products
         where product.is_available = 1 
         ORDER BY products.current_discount DESC")->getFirstRow();

        return $data;
    }
    public function sold($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('order_items');
        $builder->selectSum('order_qty');
        $builder->where('product_id', $id);
        $data = $builder->get();
        return $data->getRow();
        // return ($this->db->where(array('id' => $id, 'sku' => $sku))->get('products')->num_rows() > 0) ? TRUE : FALSE;
    }
    public function is_product_exist($id, $sku)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where(array('id' => $id, 'sku' => $sku));
        $data  = $builder->countAllResults();
        return $data > 0 ? TRUE : FALSE;
        // return ($this->db->where(array('id' => $id, 'sku' => $sku))->get('products')->num_rows() > 0) ? TRUE : FALSE;
    }

    public function product_data($id)
    {
        $db = \Config\Database::connect();
        $data = $db->query("
            SELECT p.*, pc.name as category_name
            FROM products p
            JOIN product_category pc
                ON pc.id = p.category_id
            WHERE p.id = '$id'
        ")->getRow();

        return $data;
    }

    public function related_products($current, $category)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where(array('id !=' => $current, 'category_id' => $category));
        $builder->limit(4);
        $data = $builder->get();
        return $data->getResult();
        // return $this->db->where(array('id !=' => $current, 'category_id' => $category))->limit(4)->get('products')->result();
    }

    public function create_order($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->insert($data);
        $id = $db->insertID();
        return $id;
    }

    public function create_order_items($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('order_items');
        return $builder->insertBatch($data);
    }
}
