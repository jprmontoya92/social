<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $guarded = [];
    //deshabilitamos esta opcion siempre y cuando no pasemos request()->all() en los registros
}
