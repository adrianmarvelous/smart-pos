<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasRole extends Model
{
    protected $table = 'models_has_roles';
    protected $fillable = [
        'user_id',
        'role_id',
        'store_id',
    ];

    public function hasUser()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
    public function hasRole()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
