<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaiTro extends Model
{
    use HasFactory;
    protected $table = 'vai_tros';

    protected $fillable = [
        'ma_vai_tro',
        'ten_vai_tro',
        'ghi_chu',
    ];
}
