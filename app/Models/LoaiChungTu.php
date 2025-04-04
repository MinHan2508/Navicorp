<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiChungTu extends Model
{
    use HasFactory;
    protected $fillable = [
        'ma_loai_chung_tu', 
        'ten_loai_chung_tu',
        'ghi_chu'
    ];
}
