<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table      = 'cart';
    protected $primaryKey = 'id';
    protected $allowedFields = [
    'user_id',
    'variant_id',  // Artık product_id yerine variant_id
    'quantity'
];
}
