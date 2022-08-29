<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    
    public function getSetting($key = '')
    {
        $db = \Config\Database::connect();
        $builder = $db->table('settings');
        $builder->select('content');
        $builder->where('key', $key);
        $query = $builder->get();
        $query->getResultArray();
        return $query['content'];
    }
}
