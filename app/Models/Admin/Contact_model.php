<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Contact_model extends Model
{

    protected $table = 'contacts';
    public function get_all_contacts()
    {
        return $this->db->table('contacts')->orderBy('contact_date', 'DESC')->get()->getResult();
    }

    public function is_contact_exist($id)
    {
        return ($this->db->table('contacts')->where('id', $id)->countAllResults() > 0) ? TRUE : FALSE;
    }

    public function contact_data($id)
    {
        return $this->db->table('contacts')->where('id', $id)->get()->getRow();
    }

    public function set_status($id, $status)
    {
        return $this->db->table('contacts')->where('id', $id)->update(array('status' => $status));
    }
}
