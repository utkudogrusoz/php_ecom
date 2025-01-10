<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailsModel extends Model
{
    protected $table      = 'order_details';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'variant_id',
        'quantity'
    ];
}
