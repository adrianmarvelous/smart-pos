<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main_menu extends Model
{
    protected $table = 'main_menu';

    public function menu_sub()
    {
        return $this->hasMany(Main_menu_sub::class, 'id_main_menu', 'id');
    }
}
