<?php

namespace App\Models\Customer;

use CodeIgniter\Model;

class Profile_model extends Model
{
    protected $table = 'users';


    public function get_profile()
    {
        helper('auth');
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        $id = $this->user_id;
        $data = $this->db->table('users')->where('id', $id)->get();

        return $data->getRow();
    }

    public function update_account($data)
    {
        helper('auth');
        $this->db = \Config\Database::connect();
        $this->user_id = get_current_user_id();
        return $this->db->table('users')->where('id', $this->user_id)->update($data);
    }
}
