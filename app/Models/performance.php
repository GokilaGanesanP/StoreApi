<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class performance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'store_id',
        'packages_done',
        'package_date'
    ];
}
