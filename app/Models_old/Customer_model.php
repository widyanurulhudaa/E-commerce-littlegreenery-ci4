<?php

namespace App\Models;

use CodeIgniter\Model;

class Customer_model extends Model
{

    public function data()
    {
        $id = get_current_user_id();
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $id);
        $data = $builder->get();
        $data->getResult();
        return $data;
    }

    public function is_coupon_exist($code)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('coupons');
        $builder->where('code', $code);
        $data = $builder->countAllResults();
        return ($data > 0) ? TRUE : FALSE;
    }

    public function is_coupon_active($code)
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT * FROM coupons WHERE coupons.code = '$code'")->getRow();
        return ($data->is_active == 1) ? TRUE : FALSE;
    }

    public function is_coupon_expired($code)
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT * FROM coupons WHERE coupons.code = '$code'")->getRow();
        $expired_at = $data->expired_date;
        return (strtotime($expired_at) > time()) ? FALSE : TRUE;
    }

    public function get_coupon_credit($code)
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT * FROM coupons WHERE coupons.code = '$code'")->getRow();
        $credit = $data->credit;
        return $credit;
    }

    public function get_coupon_id($code)
    {
        $db = \Config\Database::connect();
        $data = $db->query("SELECT * FROM coupons WHERE coupons.code = '$code'")->getRow();
        return $data->id;
    }
}
