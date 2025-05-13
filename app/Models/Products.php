<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'store_id',
        'name',
        'varian',
        'size',
        'unit',
        'photo',
        'barcode',
    ];
    public function products()
    {
        return $this->belongsTo(Store::class, 'id', 'store_id');
    }
}
