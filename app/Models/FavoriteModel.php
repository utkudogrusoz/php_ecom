<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table         = 'favorites';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'product_id'];

    // Opsiyonel timestamps ayarı
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}
