<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Setting_model extends Model
{

    protected $table = 'users';
    public function get_profile()
    {
        helper('auth');
        $this->db = \Config\Database::connect();
        $id = user_id();
        $user = $this->db->table('users')->where('id', $id)->get();

        return $user->getRow();
    }

    public function update_profile($data)
    {
        helper('auth');
        $this->db = \Config\Database::connect();
        $id = user_id();;
        return $this->db->table('users')->where('id', $id)->update($data);
    }
}
