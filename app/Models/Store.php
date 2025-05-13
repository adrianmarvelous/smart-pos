<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    protected $table = 'stores';
    protected $fillable = [
        'store_name',
        'address',
        'user_id',
    ];

    
    public function products()
    {
        return $this->hasMany(Products::class, 'store_id', 'id');
    }
}
