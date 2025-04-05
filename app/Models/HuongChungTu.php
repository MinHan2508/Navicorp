<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HuongChungTu extends Model
{

    use HasFactory;
       protected $fillable = [
        'ma_huong_chung_tu',
        'ten_huong_chung_tu',
        'mo_ta',
    ];
    
}
