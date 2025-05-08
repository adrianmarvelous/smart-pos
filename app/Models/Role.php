<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    // Defining the relationship with users
    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'user_id');
    }
}
