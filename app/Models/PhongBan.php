<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    protected $fillable = ['ma_phong_ban', 'ten_phong_ban'];

    
        public function nguoiTao()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_nguoi_tao');
    }

       
    use HasFactory;
    
}
