<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main_menu_sub extends Model
{
    protected $table = 'main_menu_sub';

    public function main_menu_has_sub()
    {
        return $this->hasMany(Main_menu::class, 'id', 'id_main_menu');
    }
}
