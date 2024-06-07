<?php

namespace App\Models;

use CodeIgniter\Model;
// use CodeIgniter\Database\ConnectionInterface;


class model_dashboard extends Model
{
    protected $db;
    // protected $table      = 'ref_dashboard';
    // protected $primaryKey = 'id_dashboard';
    // protected $useAutoIncrement = true;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

}