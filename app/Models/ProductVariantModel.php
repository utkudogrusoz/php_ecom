<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table         = 'product_variants';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'product_id',
        'variant_value',
        'stock'
    ];

    // Örnek timestamps (eğer tablonuzda created_at, updated_at varsa)
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}
