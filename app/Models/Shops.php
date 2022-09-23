<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
    use HasFactory;

    protected $table = "shops";
    protected $fillable = [
        'items',
        'user_id',
        'price',
        'category',
        'color',
    ];  
}

