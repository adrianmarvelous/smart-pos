<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_Stock extends Model
{
    use SoftDeletes;
    protected $table = 'product_stock';
    protected $fillable = [
        'product_id',
        'stock',
        'date',
        'deleted_at',
        'created_at',
        'update_at',
    ];
}
